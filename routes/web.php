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
Route::get('/tester',function ()
{
	$a = \App\Book::with('authors')->where('id',1)->get();
	return $a;
});
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

/* Change Theme */
Route::get('change-theme/{theme}','HomeController@changeTheme');
/* For Book*/
// Route::get('/book/show_all','BookController@index');
Route::get('/book/detail/{name}','BookController@show');
Route::post('/book/download/{id}','BookController@download');

/* For Author */
// Route::get('/author/all','AuthorController@index');
Route::get('/author/{name}','AuthorController@show');

/* For Genre*/
// Route::get('/genre/all','GenreController@index');
Route::get('/genre/{name}','GenreController@show');

/* For Publisher*/
// Route::get('/publisher/all','PublisherController@index');

Route::get('/search','BookController@search');
Route::get('/home', 'HomeController@index')->name('home');

/*for admin */
Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
	/*For Book*/
	Route::get('/book/create','BookController@create');
	Route::post('/book/store','BookController@store');
	Route::get('/book/all','BookController@index'); 
	Route::get('/book/edit/{book}','BookController@edit');
	Route::post('/book/update/{book}','BookController@update');
	Route::get('/book/delete/{book}','BookController@destroy');
	/*For Genre*/
	Route::get('/genre/edit/{genre}','GenreController@edit');
	Route::post('/genre/update/{genre}','GenreController@update');
	Route::get('/genre/delete/{genre}','GenreController@destroy');
	Route::get('/genre/all','GenreController@show_all');
	/*For Author*/
	Route::get('/author/edit/{author}','AuthorController@edit');
	Route::post('/author/update/{author}','AuthorController@update');
	Route::get('/author/delete/{author}','AuthorController@destroy');
	Route::get('/author/restore/{author}','AuthorController@restore');
	Route::get('/author/all','AuthorController@show_all');
	/*For Publisher*/
	Route::get('/publisher/edit/{publisher}','PublisherController@edit');
	Route::post('/publisher/update/{publisher}','PublisherController@update');
	Route::get('/publisher/delete/{publisher}','PublisherController@destroy');
	Route::get('/publisher/all','PublisherController@show_all');
});