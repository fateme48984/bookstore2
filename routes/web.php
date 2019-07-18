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
Route::get('/','SiteController@index')->name('site.home');
Route::get('/site/{id}/author','SiteController@author')->name('site.author');
Route::get('/site/{id}/book','SiteController@book')->name('site.book');
Route::get('/site/authors','SiteController@authors')->name('site.authors');

Route::get('/site/about','SiteController@about')->name('site.about');
Route::get('/site/contact','SiteController@contact')->name('site.contact');



/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/about' , function () {
   return 'you are special';
});

Route::resource('test', 'TestController');


/*Route::get('/', 'PostController@index')->name('home');*/



