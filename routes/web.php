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

Route::get('/', 'PostController@index');

Route::get('ip', 'IpController@index');

Route::get('ip-clusterize', 'IpController@clusterize');

Route::get('ip-clusterize-table', 'IpController@clusterizeTable');

