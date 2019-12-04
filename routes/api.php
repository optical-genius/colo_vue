<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Route for POSTS
 */
Route::post('posts', 'PostController@store');

Route::get('posts', 'PostController@get');

Route::delete('posts/{id}', 'PostController@delete');

Route::delete('ips/{id}', 'IpController@delete');

//Search route
Route::get('search', 'IpController@search');


/*
 * Route for PORTS
 */



/*
 * Route for HOSTS
 */

Route::delete('hosts/{id}', 'HostController@delete');
