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



Route::prefix('book')->group(function() {
    Route::get('/', 'BookController@index')->name('book.list');
    Route::get('/create', 'BookController@create')->name('book.create');
    Route::post('/', 'BookController@store')->name('book.store');
    Route::get('/show/{id}', 'BookController@show')->name('book.show');
    Route::get('/{id}/edit', 'BookController@edit')->name('book.edit');
    Route::get('/{id}/images', 'BookController@images')->name('book.images');
    Route::put('/show/{id}', 'BookController@update')->name('book.update');
    Route::delete('/delete/{id}','BookController@destroy')->name('book.destroy');
    Route::delete('/deleteImage/{id}/{file}/{image}','BookController@deleteImage')->name('book.deleteImage');

});

Route::prefix('author')->group(function() {
    Route::get('/', 'AuthorController@index')->name('author.list');
   /* Route::get('/', function () {
        return Modules\Books\Entities\Author::paginate(4);
    })->name('author.list');*/
    Route::get('/create', 'AuthorController@create')->name('author.create');
    Route::post('/', 'AuthorController@store')->name('author.store');
    Route::get('/show/{id}', 'AuthorController@show')->name('author.show');
    Route::get('/{id}/edit', 'AuthorController@edit')->name('author.edit');
    Route::put('/show/{id}', 'AuthorController@update')->name('author.update');
    Route::delete('/delete/{id}','AuthorController@destroy')->name('author.destroy');

});

Route::prefix('slider')->group(function() {
    Route::get('/', 'SliderController@index')->name('slider.list');
    Route::get('/create', 'SliderController@create')->name('slider.create');
    Route::post('/', 'SliderController@store')->name('slider.store');
    Route::get('/show/{id}', 'SliderController@show')->name('slider.show');
    Route::get('/{id}/edit', 'SliderController@edit')->name('slider.edit');
    Route::put('/show/{id}', 'SliderController@update')->name('slider.update');
    Route::delete('/delete/{id}','SliderController@destroy')->name('slider.destroy');

});

Route::prefix('setting')->group(function() {
    Route::get('/{id}/edit', 'SettingController@edit')->name('setting.edit');
    Route::put('/show/{id}', 'SettingController@update')->name('setting.update');

});

Route::prefix('category')->group(function() {
    Route::get('/', 'CategoryController@index')->name('category.list');
    Route::get('/create', 'CategoryController@create')->name('category.create');
    Route::post('/', 'CategoryController@store')->name('category.store');
    Route::get('/show/{id}', 'CategoryController@show')->name('category.show');
    Route::get('/{id}/edit', 'CategoryController@edit')->name('category.edit');
    Route::put('/show/{id}', 'CategoryController@update')->name('category.update');
    Route::delete('/delete/{id}','CategoryController@destroy')->name('category.destroy');

});

Route::prefix('publisher')->group(function() {
    Route::get('/', 'PublisherController@index')->name('publisher.list');
    Route::get('/create', 'PublisherController@create')->name('publisher.create');
    Route::post('/', 'PublisherController@store')->name('publisher.store');
    Route::get('/show/{id}', 'PublisherController@show')->name('publisher.show');
    Route::get('/{id}/edit', 'PublisherController@edit')->name('publisher.edit');
    Route::put('/show/{id}', 'PublisherController@update')->name('publisher.update');
    Route::delete('/delete/{id}','PublisherController@destroy')->name('publisher.destroy');

});

Route::prefix('translator')->group(function() {
    Route::get('/', 'TranslatorController@index')->name('translator.list');
    Route::get('/create', 'TranslatorController@create')->name('translator.create');
    Route::post('/', 'TranslatorController@store')->name('translator.store');
    Route::get('/show/{id}', 'TranslatorController@show')->name('translator.show');
    Route::get('/{id}/edit', 'TranslatorController@edit')->name('translator.edit');
    Route::put('/show/{id}', 'TranslatorController@update')->name('translator.update');
    Route::delete('/delete/{id}','TranslatorController@destroy')->name('translator.destroy');

});



Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
    // list all lfm routes here...


