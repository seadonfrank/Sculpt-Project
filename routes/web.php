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

Route::get('/phpinfo', function () {
    echo phpinfo();
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/test', 'HomeController@test');

Route::get('/', function () {
    return view('home');
});

Route::get('/search', 'SearchController@search');


//Route::get('/tap/database/database_name', 'Tap/DatabaseController@database_name');
Route::get('/tap/database/mongodb', 'Tap\DatabaseController@mongodb');

//Route::get('/tap/api/api_name', 'Tap/ApiController@api_name');
Route::get('/tap/api/crunchbase', 'Tap\ApiController@crunchbase');
Route::get('/tap/api/angelco', 'Tap\ApiController@angelco');
Route::get('/tap/api/ivc', 'Tap\ApiController@ivc');
Route::get('/tap/api/cbinsights', 'Tap\ApiController@cbinsights');

//Route::get('/tap/file/file_name', 'Tap/FileController@file_name');