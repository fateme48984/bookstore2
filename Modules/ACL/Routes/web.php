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

Route::prefix('acl')->group(function() {
    Route::get('/', 'ACLController@index');
});
Route::prefix('permission')->group(function() {
    Route::get('/', 'PermissionController@index')->name('permission.list');
    Route::get('/create', 'PermissionController@create')->name('permission.create');
    Route::post('/', 'PermissionController@store')->name('permission.store');
    Route::get('/show/{id}', 'PermissionController@show')->name('permission.show');
    Route::get('/{id}/edit', 'PermissionController@edit')->name('permission.edit');
    Route::put('/show/{id}', 'PermissionController@update')->name('permission.update');
    Route::delete('/delete/{id}','PermissionController@destroy')->name('permission.destroy');
});
Route::prefix('role')->group(function() {
    Route::get('/', 'RoleController@index')->name('role.list');
    Route::get('/create', 'RoleController@create')->name('role.create');
    Route::post('/', 'RoleController@store')->name('role.store');
    Route::get('/show/{id}', 'RoleController@show')->name('role.show');
    Route::get('/{id}/edit', 'RoleController@edit')->name('role.edit');
    Route::put('/show/{id}', 'RoleController@update')->name('role.update');
    Route::delete('/delete/{id}','RoleController@destroy')->name('role.destroy');
});
