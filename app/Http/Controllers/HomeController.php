<?php

/**
* 
*/
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input as Input;
use View;

class HomeController extends BaseController {
	
	public function index() {
		return view::make('home');
	}
}

?>