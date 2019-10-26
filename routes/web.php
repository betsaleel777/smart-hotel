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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','WelcomeController@dashboard')->name('dashboard') ;

Route::get('/parametre/type','TypeController@index')->name('type_index') ;
Route::get('/parametre/type/add','TypeController@add')->name('type_add') ;
Route::post('/parametre/type/store','TypeController@store')->name('type_store') ;
Route::get('/parametre/type/edit/{id}','TypeController@edit')->name('type_edit') ;
Route::post('/parametre/type/update/{id}','TypeController@update')->name('type_update') ;
Route::get('/parametre/type/delete/{id}','TypeController@delete')->name('type_delete') ;

Route::get('/parametre/batiment','BatimentsController@index')->name('batiment_index') ;
Route::get('/parametre/batiment/add','BatimentsController@add')->name('batiment_add') ;
Route::post('/parametre/batiment/store','BatimentsController@store')->name('batiment_store') ;
Route::get('/parametre/batiment/edit/{id}','BatimentsController@edit')->name('batiment_edit') ;
Route::post('/parametre/batiment/update/{id}','BatimentsController@update')->name('batiment_update') ;
Route::get('/parametre/batiment/delete/{id}','BatimentsController@delete')->name('batiment_delete') ;

Route::get('/parametre/chambre','ChambresController@index')->name('chambre_index') ;
Route::get('/parametre/chambre/add','ChambresController@add')->name('chambre_add') ;
Route::post('/parametre/chambre/store','ChambresController@store')->name('chambre_store') ;
Route::get('/parametre/chambre/edit/{id}','ChambresController@edit')->name('chambre_edit') ;
Route::post('/parametre/chambre/update/{id}','ChambresController@update')->name('chambre_update') ;
Route::get('/parametre/chambre/delete/{id}','ChambresController@delete')->name('chambre_delete') ;
