<?php

/**
* 
*/
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Resources\LinkResource;
use Redirect;
use View;
use URL;
use App\Link as Link;
use App\Audit as Audit;

class LinkController extends BaseController {
	// WEB PART
	public function make(Request $request) {
		//echo Input::get('url');
		$validator = Validator::make(Input::all(), array(
			'url' => 'required|url|max:255',
		));

		if ($validator->fails()) {
			$audit_action = Audit::create(array(
				'event' => 'link_add_error',
				'type' => 'get',
				'ip' => $request->ip(),
				'new_value' => Input::get('url'),
				'user_agent' => $request->server('HTTP_USER_AGENT'),
			));
			$audit_action->save();

			return Redirect::action('HomeController@index')->withInput()->withErrors($validator);
		} else {
			$url = Input::get('url');
			$code = null;

			$exists = Link::where('url', '=', $url);

			if ($exists->count() === 1) {
				echo $code = $exists->first()->code;
			} else {
				$created = Link::create(array(
					'url' => $url,					
				));
				if ($created) {
					$code = base_convert($created->id, 10, 36);

					Link::where('id', '=', $created->id)->update(array(
						'code' => $code,
					));
				}

				$audit_action = Audit::create(array(
					'event' => 'link_add',
					'type' => 'post',
					'new_value' => $url,
					'ip' => $request->ip(),
					'user_agent' => $request->server('HTTP_USER_AGENT'),
				));
				$audit_action->save();

			}

			if ($code) {
				return Redirect::action('HomeController@index')->with('global', 'Ok. Created. Short url: <a href="' .URL::action('LinkController@get', $code) . '">' . URL::action('LinkController@get', $code) . '</a>');
			}
		}
		return Redirect::action('HomeController@index')->with('global', 'Error occured, try again');
	}

	public function get($code, Request $request) {
		$link = Link::where('code', '=', $code);

		if ($link->count() === 1) {
			$hits = $link->first()->hits;
			Link::where('id', '=', $link->first()->id)->update(array(
				'hits' => $hits + 1,
			));

			// Logging
			$audit_action = Audit::create(array(
				'event' => 'link_open',
				'type' => 'get',
				'ip' => $request->ip(),
				'new_value' => $link->first()->url,
				'user_agent' => $request->server('HTTP_USER_AGENT'),
			));
			$audit_action->save();

			return Redirect::to($link->first()->url);
		}

		$audit_action = Audit::create(array(
				'event' => 'link_open_error',
				'type' => 'get',
				'ip' => $request->ip(),
				'new_value' => $code,
				'user_agent' => $request->server('HTTP_USER_AGENT'),
			));
		$audit_action->save();

		return Redirect::action('HomeController@index');
	}

	// REST API

	// show one link
	public function show($id) {
		$link = Link::find($id);

		if ($link) {
			return response()->json($link, 200);
		} else {
			return response()->json(['message' => 'Ссылка не существует'], 404);
		}
	}

	// show all links
	public function show_all() {
		$links = Link::all();

		if ($links) {
			return response(Link::all(), 200);
		} else {
			return response()->json(['message' => 'Ссылок не существует'], 404);
		}
	}

	// delete
	public function delete($id) {	
		$link = Link::where('id', '=', $id);

		if ($link->count() > 0) {
			$link->delete();
			return response()->json(['message' => 'Ссылка удалена'], 200);
		} else {
			return response()->json(['message' => 'Ссылка не существует'], 404);
		}
    }

    // update
    public function update(Request $request, $id) {

    	$link = Link::find($id);

    	if ($link) {
    		$link->update($request->all());
        	return response()->json($link, 200);
    	} else {
    		return response()->json(['message' => 'Ссылка не существует'], 404);
    	}
        
    }

    // create
	public function store(Request $request) {
		$created = null;
		$validator = Validator::make(Input::all(), array(
			'url' => 'required|url|max:255',
		));

		if ($validator->fails()) {
			$audit_action = Audit::create(array(
				'event' => 'link_add_error',
				'type' => 'get',
				'ip' => $request->ip(),
				'new_value' => Input::get('url'),
				'user_agent' => $request->server('HTTP_USER_AGENT'),
			));
			$audit_action->save();

		} else {
			$url = Input::get('url');
			$code = null;

			$exists = Link::where('url', '=', $url);

			if ($exists->count() === 1) {
				echo $code = $exists->first()->code;
				return response()->json(['message' => 'Ссылка уже существует'], 202);
			} else {
				$created = Link::create(array(
					'url' => $url,					
				));
				if ($created) {
					$code = base_convert($created->id, 10, 36);

					Link::where('id', '=', $created->id)->update(array(
						'code' => $code,
					));
				}

				$audit_action = Audit::create(array(
					'event' => 'link_add',
					'type' => 'post',
					'new_value' => $url,
					'ip' => $request->ip(),
					'user_agent' => $request->server('HTTP_USER_AGENT'),
				));
				$audit_action->save();

			}

			return response()->json($created, 200);
		}
	}

}

?>