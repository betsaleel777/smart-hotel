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

Route::get('/', 'WelcomeController@dashboard')->name('dashboard') ;

Route::prefix('parametre')->group(function () {
  Route::get('/type', 'TypesController@index')->name('type_index') ;
  Route::get('/type/add', 'TypesController@add')->name('type_add') ;
  Route::post('/type/store', 'TypesController@store')->name('type_store') ;
  Route::get('/type/edit/{id}', 'TypesController@edit')->name('type_edit') ;
  Route::post('/type/update/{id}', 'TypesController@update')->name('type_update') ;
  Route::get('/type/delete/{id}', 'TypesController@delete')->name('type_delete') ;

  Route::get('/batiment', 'BatimentsController@index')->name('batiment_index') ;
  Route::get('/batiment/add', 'BatimentsController@add')->name('batiment_add') ;
  Route::post('/batiment/store', 'BatimentsController@store')->name('batiment_store') ;
  Route::get('/batiment/edit/{id}', 'BatimentsController@edit')->name('batiment_edit') ;
  Route::get('/batiment/show/{id}', 'BatimentsController@show')->name('batiment_show') ;
  Route::post('/batiment/update/{id}', 'BatimentsController@update')->name('batiment_update') ;
  Route::get('/batiment/delete/{id}', 'BatimentsController@delete')->name('batiment_delete') ;

  Route::get('/chambres', 'ChambresController@index')->name('chambre_index') ;
  Route::get('/chambre/add', 'ChambresController@add')->name('chambre_add') ;
  Route::post('/chambre/store', 'ChambresController@store')->name('chambre_store') ;
  Route::get('/chambre/edit/{id}', 'ChambresController@edit')->name('chambre_edit') ;
  Route::post('/chambre/update/{id}', 'ChambresController@update')->name('chambre_update') ;
  Route::get('/chambre/delete/{id}', 'ChambresController@delete')->name('chambre_delete') ;

  Route::get('/familles', 'FamillesController@index')->name('famille_index') ;
  Route::get('/famille/add', 'FamillesController@add')->name('famille_add') ;
  Route::post('/famille/store', 'FamillesController@store')->name('famille_store') ;
  Route::get('/famille/edit/{id}', 'FamillesController@edit')->name('famille_edit') ;
  Route::post('/famille/update/{id}', 'FamillesController@update')->name('famille_update') ;
  Route::get('/famille/delete/{id}', 'FamillesController@delete')->name('famille_delete') ;

  Route::get('/sous_familles', 'SousFamillesController@index')->name('sous_famille_index') ;
  Route::get('/sous_famille/add', 'SousFamillesController@add')->name('sous_famille_add') ;
  Route::post('/sous_famille/store', 'SousFamillesController@store')->name('sous_famille_store') ;
  Route::get('/sous_famille/edit/{id}', 'SousFamillesController@edit')->name('sous_famille_edit') ;
  Route::post('/sous_famille/update/{id}', 'SousFamillesController@update')->name('sous_famille_update') ;
  Route::get('/sous_famille/delete/{id}', 'SousFamillesController@delete')->name('sous_famille_delete') ;

  Route::get('/produits', 'ProduitsController@index')->name('produit_index') ;
  Route::get('/produit/add', 'ProduitsController@add')->name('produit_add') ;
  Route::post('/produit/store', 'ProduitsController@store')->name('produit_store') ;
  Route::get('/produit/edit/{id}', 'ProduitsController@edit')->name('produit_edit') ;
  Route::post('/produit/update/{id}', 'ProduitsController@update')->name('produit_update') ;
  Route::get('/produit/delete/{id}', 'ProduitsController@delete')->name('produit_delete') ;

});


Route::prefix('home')->group(function () {
  Route::get('/attributions', 'AttributionsPassagesController@index')->name('attributions_pass_index') ;
  Route::get('/attributions/add', 'AttributionsPassagesController@add')->name('attributions_pass_add') ;
  Route::post('/attributions/store', 'AttributionsPassagesController@store')->name('attributions_pass_store') ;
  Route::get('/attributions/edit/{id}', 'AttributionsPassagesController@edit')->name('attributions_pass_edit') ;
  Route::post('/attributions/update/{id}', 'AttributionsPassagesController@update')->name('attributions_pass_update') ;
  Route::get('/attributions/delete/{id}', 'AttributionsPassagesController@delete')->name('attributions_pass_delete') ;
  Route::get('/attributions/liberer/{id}', 'AttributionsPassagesController@liberer')->name('attributions_pass_liberer') ;

  Route::get('/sejour', 'AttributionsSejoursController@index')->name('attributions_sejour_index') ;

  Route::get('/pieces', 'TypesPiecesController@index')->name('type_piece_index') ;
  Route::get('/pieces/add', 'TypesPiecesController@add')->name('type_piece_add') ;
  Route::post('/pieces/store', 'TypesPiecesController@store')->name('type_piece_store') ;
  Route::get('/pieces/edit/{id}', 'TypesPiecesController@edit')->name('type_piece_edit') ;
  Route::post('/pieces/update/{id}', 'TypesPiecesController@update')->name('type_piece_update') ;

  Route::get('/client/index', 'ClientsController@index')->name('client_index') ;
  Route::get('/client/edit/{id}', 'ClientsController@edit')->name('client_edit') ;
  Route::post('/client/update/{id}', 'ClientsController@update')->name('client_update') ;
});
