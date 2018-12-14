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

Auth::routes();

Route::get('/', 'ActionController@index');

Route::get('/home', 'ActionController@index');

Route::get('/babies', 'BabyController@index');
Route::get('babies/create', 'BabyController@create')->name('babies.create');;  // criar registro
Route::get('babies/edit/{id}', 'BabyController@edit')->name('babies.edit');; // editar registro
Route::get('babies/view/{id}', 'BabyController@show')->name('babies.view');; // ver registro
Route::post('babies/store', 'BabyController@store')->name('babies.store');;   // salvar novo registro
Route::post('babies/update/{id}', 'BabyController@update')->name('babies.update');; // atualizar registro
Route::post('babies/destroy/{id}', 'BabyController@destroy')->name('babies.destroy'); // excluir registro

Route::get('/actions', 'ActionController@index');
Route::get('actions/create', 'ActionController@create')->name('actions.create');;  // criar registro
Route::get('actions/edit/{id}', 'ActionController@edit')->name('actions.edit');; // editar registro
Route::get('actions/view/{id}', 'ActionController@show')->name('actions.view');; // ver registro
Route::post('actions/store', 'ActionController@store')->name('actions.store');;   // salvar novo registro
Route::post('actions/update/{id}', 'ActionController@update')->name('actions.update');; // atualizar registro
Route::post('actions/destroy/{id}', 'ActionController@destroy')->name('actions.destroy'); // excluir registro
Route::post('actions/search', 'ActionController@search')->name('actions.search'); // pesquisar atividade por bebê