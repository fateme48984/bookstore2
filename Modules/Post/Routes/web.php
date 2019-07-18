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

Route::prefix('post')->group(function() {
    Route::get('/', 'PostController@index')->name('post.list');
    Route::get('/create', 'PostController@create')->name('post.create');
    Route::post('/', 'PostController@store')->name('post.store');
    Route::get('/show/{id}', 'PostController@show')->name('post.show');
    Route::get('/{id}/edit', 'PostController@edit')->name('post.edit');
    Route::put('/show/{id}', 'PostController@update')->name('post.update');
    Route::delete('/delete/{id}','PostController@destroy')->name('post.destroy');

});
