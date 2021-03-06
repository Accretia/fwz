<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get("/", ["uses" => "PropertyController@index", "as" => "buildings"]);
Route::get("get_buildings", ["uses" =>"PropertyController@getProperties", "as" => "get-buildings"]);
Route::get("get_properties", ["uses" =>"PropertyController@getPropertiesNew", "as" => "get-properties"]);
Route::get("/test", "PropertyController@testGrid");
