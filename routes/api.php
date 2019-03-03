<?php

use Illuminate\Http\Request;
use App\Link as Link;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('links', 'LinkController@show_all'); // show all
Route::get('links/{link}', 'LinkController@show'); // show one 
Route::post('links/add','LinkController@store'); // add
Route::delete('links/delete/{link}', 'LinkController@delete'); // delete
Route::put('links/update/{link}', 'LinkController@update'); // update