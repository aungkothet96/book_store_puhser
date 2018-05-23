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

Route::get('author/all','AuthorController@api_author_get_all');
Route::get('genre/all','GenreController@api_genre_get_all');
Route::get('publisher/all','PublisherController@api_publisher_get_all');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
