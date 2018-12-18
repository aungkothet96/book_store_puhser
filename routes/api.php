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
Route::get('author/take_5','AuthorController@api_auhtor_take_5');
Route::get('genre/all','GenreController@api_genre_get_all');
Route::get('genre/take_5','GenreController@api_genre_take_5');
Route::get('publisher/all','PublisherController@api_publisher_get_all');
Route::post('author/store','AuthorController@store');
Route::post('genre/store','GenreController@store');
Route::post('publisher/store','PublisherController@store');
Route::get('book/all','BookController@api_book_get_all');
Route::get('book/latest','BookController@api_book_get_latest');
Route::get('author/get_trash','AuthorController@get_trash_authors');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
