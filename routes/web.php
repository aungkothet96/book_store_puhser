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

Route::get('/', function () {
    return view('welcome');
});
/* For Author */
Route::get('/author/all','AuthorController@index');
Route::get('/author/create','AuthorController@create');
Route::post('author/store','AuthorController@store');
Route::get('/author/edit/{author}','AuthorController@edit');
Route::post('/author/update/{author}','AuthorController@update');
Route::get('/author/delete/{author}','AuthorController@destroy');

/* For Genre*/
Route::get('/genre/all','GenreController@index');
Route::get('/genre/create','GenreController@create');
Route::post('genre/store','GenreController@store');
Route::get('/genre/edit/{genre}','GenreController@edit');
Route::post('/genre/update/{genre}','GenreController@update');
Route::get('/genre/delete/{genre}','GenreController@destroy');

/* For Publisher*/
Route::get('/publisher/all','PublisherController@index');
Route::get('/publisher/create','PublisherController@create');
Route::post('publisher/store','PublisherController@store');
Route::get('/publisher/edit/{publisher}','PublisherController@edit');
Route::post('/publisher/update/{publisher}','PublisherController@update');
Route::get('/publisher/delete/{publisher}','PublisherController@destroy');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
