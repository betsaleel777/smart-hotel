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

Route::get('/parametre/type','TypesController@index')->name('type_index') ;
Route::get('/parametre/type/add','TypesController@add')->name('type_add') ;
Route::post('/parametre/type/store','TypesController@store')->name('type_store') ;
Route::get('/parametre/type/edit/{id}','TypesController@edit')->name('type_edit') ;
Route::post('/parametre/type/update/{id}','TypesController@update')->name('type_update') ;
Route::get('/parametre/type/delete/{id}','TypesController@delete')->name('type_delete') ;


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


Route::get('/home/attributions','AttributionsPassagesController@index')->name('attributions_pass_index') ;
Route::get('/home/attributions/add','AttributionsPassagesController@add')->name('attributions_pass_add') ;
Route::post('/home/attributions/store','AttributionsPassagesController@store')->name('attributions_pass_store') ;
Route::get('/home/attributions/edit/{id}','AttributionsPassagesController@edit')->name('attributions_pass_edit') ;
Route::post('/home/attributions/update/{id}','AttributionsPassagesController@update')->name('attributions_pass_update') ;
Route::get('/home/attributions/delete/{id}','AttributionsPassagesController@delete')->name('attributions_pass_delete') ;

// api ajax vue route
Route::get('/api/chambres/all/{batiment}','ApiController@allRooms')->name('all_chambre') ;
Route::get('/api/chambres/empty/{batiment}','ApiController@emptyRooms')->name('empty_chambre') ;
Route::get('/api/chambres/used/{batiment}','ApiController@usedRooms')->name('used_chambre') ;
Route::post('/api/attribution/passage','ApiController@attribuer')->name('attribution_passage') ;
