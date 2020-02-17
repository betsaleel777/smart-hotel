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

Route::get('/', 'WelcomeController@dashboard')->name('dashboard') ;

Route::prefix('parametre')->group(function () {
  Route::prefix('/type')->group(function(){
    Route::get('/', 'TypesController@index')->name('type_index') ;
    Route::get('/add', 'TypesController@add')->name('type_add') ;
    Route::post('/store', 'TypesController@store')->name('type_store') ;
    Route::get('/edit/{id}', 'TypesController@edit')->name('type_edit') ;
    Route::post('/update/{id}', 'TypesController@update')->name('type_update') ;
    Route::get('/delete/{id}', 'TypesController@delete')->name('type_delete') ;
  }) ;

  Route::prefix('/batiment')->group(function(){
    Route::get('/', 'BatimentsController@index')->name('batiment_index') ;
    Route::get('/add', 'BatimentsController@add')->name('batiment_add') ;
    Route::post('/store', 'BatimentsController@store')->name('batiment_store') ;
    Route::get('/edit/{id}', 'BatimentsController@edit')->name('batiment_edit') ;
    Route::get('/show/{id}', 'BatimentsController@show')->name('batiment_show') ;
    Route::post('/update/{id}', 'BatimentsController@update')->name('batiment_update') ;
    Route::get('/delete/{id}', 'BatimentsController@delete')->name('batiment_delete') ;
  }) ;

  Route::prefix('/chambre')->group(function(){
    Route::get('/', 'ChambresController@index')->name('chambre_index') ;
    Route::get('/add', 'ChambresController@add')->name('chambre_add') ;
    Route::post('/store', 'ChambresController@store')->name('chambre_store') ;
    Route::get('/edit/{id}', 'ChambresController@edit')->name('chambre_edit') ;
    Route::post('/update/{id}', 'ChambresController@update')->name('chambre_update') ;
    Route::get('/delete/{id}', 'ChambresController@delete')->name('chambre_delete') ;
  });

  Route::prefix('/famille')->group(function(){
    Route::get('/', 'FamillesController@index')->name('famille_index') ;
    Route::get('/add', 'FamillesController@add')->name('famille_add') ;
    Route::post('/store', 'FamillesController@store')->name('famille_store') ;
    Route::get('/edit/{id}', 'FamillesController@edit')->name('famille_edit') ;
    Route::post('/update/{id}', 'FamillesController@update')->name('famille_update') ;
    Route::get('/delete/{id}', 'FamillesController@delete')->name('famille_delete') ;
    Route::get('/show/{id}', 'FamillesController@show')->name('famille_show') ;
  }) ;

  Route::prefix('/accessoire')->group(function(){
     Route::get('/','ProduitsController@accessoires')->name('accessoire_index') ;
     Route::get('/add', 'ProduitsController@accessoireAdd')->name('accessoire_add') ;
     Route::post('/store','ProduitsController@accessoireStore')->name('accessoire_store') ;
     Route::get('/edit/{id}', 'ProduitsController@accessoireEdit')->name('accessoire_edit') ;
     Route::post('/update/{id}', 'ProduitsController@accessoireUpdate')->name('accessoire_update') ;
     Route::get('/delete/{id}', 'ProduitsController@accessoireDelete')->name('accessoire_delete') ;
  }) ;

  Route::prefix('/sous_famille')->group(function(){
    Route::get('/', 'SousFamillesController@index')->name('sous_famille_index') ;
    Route::get('/add', 'SousFamillesController@add')->name('sous_famille_add') ;
    Route::post('/store', 'SousFamillesController@store')->name('sous_famille_store') ;
    Route::get('/edit/{id}', 'SousFamillesController@edit')->name('sous_famille_edit') ;
    Route::post('/update/{id}', 'SousFamillesController@update')->name('sous_famille_update') ;
    Route::get('/delete/{id}', 'SousFamillesController@delete')->name('sous_famille_delete') ;
    Route::get('/show/{id}', 'SousFamillesController@show')->name('sous_famille_show') ;
    Route::get('/associer/{id}', 'SousFamillesController@associer')->name('sous_famille_associer') ;
    Route::post('/plug', 'SousFamillesController@plug')->name('sous_famille_plug') ;
  });

 Route::prefix('/produit')->group(function(){
   Route::get('/', 'ProduitsController@index')->name('produit_index') ;
   Route::get('/add', 'ProduitsController@add')->name('produit_add') ;
   Route::post('/store', 'ProduitsController@store')->name('produit_store') ;
   Route::get('/associer/{id}', 'ProduitsController@associer')->name('produit_associer') ;
   Route::post('/plug', 'ProduitsController@plug')->name('produit_plug') ;
   Route::get('/edit/{id}', 'ProduitsController@edit')->name('produit_edit') ;
   Route::post('/update/{id}', 'ProduitsController@update')->name('produit_update') ;
   Route::get('/delete/{id}', 'ProduitsController@delete')->name('produit_delete') ;
 });
});

Route::prefix('home')->group(function () {

  Route::prefix('/attributions')->group(function(){
    Route::get('/', 'AttributionsPassagesController@index')->name('attributions_pass_index') ;
    Route::get('/add', 'AttributionsPassagesController@add')->name('attributions_pass_add') ;
    Route::post('/store', 'AttributionsPassagesController@store')->name('attributions_pass_store') ;
    Route::get('/edit/{id}', 'AttributionsPassagesController@edit')->name('attributions_pass_edit') ;
    Route::post('/update/{id}', 'AttributionsPassagesController@update')->name('attributions_pass_update') ;
    Route::get('/delete/{id}', 'AttributionsPassagesController@delete')->name('attributions_pass_delete') ;
    Route::get('/liberer/{id}', 'AttributionsPassagesController@liberer')->name('attributions_pass_liberer') ;
  });

  Route::get('/sejour', 'AttributionsSejoursController@index')->name('attributions_sejour_index') ;

  Route::prefix('/pieces')->group(function(){
    Route::get('/', 'TypesPiecesController@index')->name('type_piece_index') ;
    Route::get('/add', 'TypesPiecesController@add')->name('type_piece_add') ;
    Route::post('/store', 'TypesPiecesController@store')->name('type_piece_store') ;
    Route::get('/edit/{id}', 'TypesPiecesController@edit')->name('type_piece_edit') ;
    Route::get('/delete/{id}', 'TypesPiecesController@delete')->name('type_piece_delete') ;
    Route::post('/update/{id}', 'TypesPiecesController@update')->name('type_piece_update') ;
  }) ;

  Route::prefix('/client')->group(function(){
    Route::get('/client/index', 'ClientsController@index')->name('client_index') ;
    Route::get('/client/edit/{id}', 'ClientsController@edit')->name('client_edit') ;
    Route::post('/client/update/{id}', 'ClientsController@update')->name('client_update') ;
    Route::get('/client/delete/{id}', 'ClientsController@delete')->name('client_delete') ;
  });

  Route::get('/restaurations','RestaurationsController@index')->name('resto_index') ;
  Route::get('/restauration/add/{attribution}','RestaurationsController@add')->name('resto_add') ;
  Route::get('/restauration/new/{attribution}','RestaurationsController@new')->name('resto_new') ;
  Route::get('/restauration/sejour/pdf/proforma/{attribution}','RestaurationsController@sejourProformaPdf')->name('resto_sejour_proforma_pdf') ;
  Route::get('/restauration/sejour/pdf/facture/{attribution}','RestaurationsController@sejourFacturePdf')->name('resto_sejour_facture_pdf') ;
  Route::get('/restauration/passage/pdf/proforma/{attribution}','RestaurationsController@passageProformaPdf')->name('resto_passage_proforma_pdf') ;
  Route::get('/restauration/passage/pdf/facture/{attribution}','RestaurationsController@passageFacturePdf')->name('resto_passage_facture_pdf') ;

  Route::get('/approvisionnement','ApprovisionnementsController@index')->name('approvisionnement_index') ;

  Route::prefix('/facture')->group(function(){
    Route::get('/','Facturescontroller@index')->name('facture_index') ;
    Route::get('/show/{id}','Facturescontroller@show')->name('facture_index') ;
    Route::get('/edit/{id}','Facturescontroller@edit')->name('facture_edit') ;
    Route::get('/update/{id}','Facturescontroller@update')->name('facture_update') ;
    Route::get('/pdf/{id}','Facturescontroller@pdf')->name('facture_pdf') ;
  });

  Route::get('/destockage/add/{id}','DestockagesController@add')->name('destockage_add') ;
  Route::post('/destockage/store', 'DestockagesController@store')->name('destockage_store') ;

});
