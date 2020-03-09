<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/batiments/all/', 'BatimentsController@allBatiments')->name('all_batiment') ;
Route::get('/chambres/all/{batiment}', 'ApiPassageController@allRooms')->name('all_chambre') ;
Route::get('/chambres/empty/{batiment}', 'ApiPassageController@emptyRooms')->name('empty_chambre') ;
Route::get('/chambre/details/{chambre}', 'ChambresController@details')->name('chambre_details') ;
Route::get('/chambres/used/{batiment}', 'ApiPassageController@usedRooms')->name('used_chambre') ;
Route::post('/attribution/passage', 'ApiPassageController@attribuer')->name('attribution_passage') ;
Route::post('/liberation/passage', 'ApiPassageController@liberer')->name('liberation_passage') ;

Route::post('/sejour/add', 'AttributionsSejoursController@add')->name('attributions_sejour_add') ;
Route::get('/sejour/infos/{attribution}', 'AttributionsSejoursController@infos')->name('attributions_sejour_infos') ;
Route::get('/sejour/all', 'AttributionsSejoursController@getAll')->name('attributions_sejour_all') ;
Route::post('/sejour/update', 'AttributionsSejoursController@update')->name('attributions_sejour_update') ;
Route::post('/sejour/liberer', 'AttributionsSejoursController@liberer')->name('attributions_sejour_liberation') ;
Route::post('/sejour/supprimer', 'AttributionsSejoursController@delete')->name('attributions_sejour_delete') ;

Route::get('/typePiece/all', 'TypesPiecesController@pieces')->name('all_pieces') ;

Route::get('/produit/all', 'ProduitsController@getAll')->name('all_produit') ;
Route::get('/produit/consommables/all', 'ProduitsController@getConsommables')->name('all_consommables') ;
Route::get('/produit/accessoire/all', 'ProduitsController@getAccessoires')->name('all_accessoire') ;
Route::post('/produit/show', 'ProduitsController@getDetails')->name('show_produit') ;


Route::post('/restauration/proformas', 'RestaurationsController@getProformas')->name('resto_proformas') ;
Route::post('/restauration/passage/proformas', 'RestaurationsController@getPassageProformas')->name('resto_passage_proformas') ;
Route::post('/restauration/save', 'RestaurationsController@saveProformas')->name('save_proformas') ;
Route::post('/restauration/passage/save', 'RestaurationsController@savePassageProformas')->name('save_passage_proformas') ;
Route::post('/restauration/solder', 'RestaurationsController@solder')->name('solde_proforma') ;
Route::post('/restauration/passage/solder', 'RestaurationsController@passageSolder')->name('solde_passage_proforma') ;
Route::post('/restauration/delete', 'RestaurationsController@delete')->name('delete_proformas') ;
Route::post('/restauration/passage/delete', 'RestaurationsController@passageDelete')->name('delete_passage_proforma') ;

Route::post('/destockage/save', 'DestockagesController@save')->name('destockage_save') ;
Route::get('/destockage/sejour/saved/{id}', 'DestockagesController@sejourSaved')->name('produit_sejour_saved') ;
Route::get('/destockage/passage/saved/{id}', 'DestockagesController@passageSaved')->name('produit_passage_saved') ;

Route::post('/approvisionnement/save','ApprovisionnementsController@save')->name('appro_save') ;
