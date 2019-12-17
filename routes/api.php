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


Route::get('/typePiece/all', 'TypesPiecesController@pieces')->name('all_pieces') ;
