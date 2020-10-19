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

Route::get('/', 'WelcomeController@dashboard')->name('dashboard');

Route::prefix('parametre')->group(
    function () {
        Route::prefix('/type')->group(
            function () {
                Route::get('/', 'TypesController@index')->name('type_index');
                Route::get('/add', 'TypesController@add')->name('type_add');
                Route::post('/store', 'TypesController@store')->name('type_store');
                Route::get('/edit/{id}', 'TypesController@edit')->name('type_edit');
                Route::post('/update/{id}', 'TypesController@update')->name('type_update');
                Route::get('/delete/{id}', 'TypesController@delete')->name('type_delete');
            }
        );

        Route::prefix('/batiment')->group(
            function () {
                Route::get('/', 'BatimentsController@index')->name('batiment_index');
                Route::get('/add', 'BatimentsController@add')->name('batiment_add');
                Route::post('/store', 'BatimentsController@store')->name('batiment_store');
                Route::get('/edit/{id}', 'BatimentsController@edit')->name('batiment_edit');
                Route::get('/show/{id}', 'BatimentsController@show')->name('batiment_show');
                Route::post('/update/{id}', 'BatimentsController@update')->name('batiment_update');
                Route::get('/delete/{id}', 'BatimentsController@delete')->name('batiment_delete');
            }
        );

        Route::prefix('/chambre')->group(
            function () {
                Route::get('/', 'ChambresController@index')->name('chambre_index');
                Route::get('/add', 'ChambresController@add')->name('chambre_add');
                Route::post('/store', 'ChambresController@store')->name('chambre_store');
                Route::get('/edit/{id}', 'ChambresController@edit')->name('chambre_edit');
                Route::post('/update/{id}', 'ChambresController@update')->name('chambre_update');
                Route::get('/delete/{id}', 'ChambresController@delete')->name('chambre_delete');
            }
        );

        Route::prefix('/famille')->group(
            function () {
                Route::get('/', 'FamillesController@index')->name('famille_index');
                Route::get('/add', 'FamillesController@add')->name('famille_add');
                Route::post('/store', 'FamillesController@store')->name('famille_store');
                Route::get('/edit/{id}', 'FamillesController@edit')->name('famille_edit');
                Route::post('/update/{id}', 'FamillesController@update')->name('famille_update');
                Route::get('/delete/{id}', 'FamillesController@delete')->name('famille_delete');
                Route::get('/show/{id}', 'FamillesController@show')->name('famille_show');
                Route::get('/ajax/all', 'FamillesController@getFamilles')->name('famille_all');
            }
        );

        Route::prefix('/accessoire')->group(
            function () {
                Route::get('/', 'ProduitsController@accessoires')->name('accessoire_index');
                Route::get('/add', 'ProduitsController@accessoireAdd')->name('accessoire_add');
                Route::post('/store', 'ProduitsController@accessoireStore')->name('accessoire_store');
                Route::get('/edit/{id}', 'ProduitsController@accessoireEdit')->name('accessoire_edit');
                Route::post('/update/{id}', 'ProduitsController@accessoireUpdate')->name('accessoire_update');
                Route::get('/delete/{id}', 'ProduitsController@accessoireDelete')->name('accessoire_delete');
            }
        );

        Route::prefix('/consommable')->group(
            function () {
                Route::get('/', 'ProduitsController@consommables')->name('consommable_index');
                Route::get('/add', 'ProduitsController@consommableAdd')->name('consommable_add');
                Route::post('/store', 'ProduitsController@consommableStore')->name('consommable_store');
                Route::get('/edit/{id}', 'ProduitsController@consommableEdit')->name('consommable_edit');
                Route::post('/update/{id}', 'ProduitsController@consommableUpdate')->name('consommable_update');
                Route::get('/delete/{id}', 'ProduitsController@consommableDelete')->name('consommable_delete');
            }
        );

        Route::prefix('/sous_famille')->group(
            function () {
                Route::get('/', 'SousFamillesController@index')->name('sous_famille_index');
                Route::get('/add', 'SousFamillesController@add')->name('sous_famille_add');
                Route::post('/store', 'SousFamillesController@store')->name('sous_famille_store');
                Route::get('/edit/{id}', 'SousFamillesController@edit')->name('sous_famille_edit');
                Route::post('/update/{id}', 'SousFamillesController@update')->name('sous_famille_update');
                Route::get('/delete/{id}', 'SousFamillesController@delete')->name('sous_famille_delete');
                Route::get('/show/{id}', 'SousFamillesController@show')->name('sous_famille_show');
                Route::get('/associer/{id}', 'SousFamillesController@associer')->name('sous_famille_associer');
                Route::get('/ajax/{famille}', 'SousFamillesController@getSousFamilles')->name('sous_famille_concerned');
                Route::post('/plug', 'SousFamillesController@plug')->name('sous_famille_plug');
            }
        );

        Route::prefix('/produit')->group(
            function () {
                Route::get('/', 'ProduitsController@index')->name('produit_index');
                Route::get('/add', 'ProduitsController@add')->name('produit_add');
                Route::post('/store', 'ProduitsController@store')->name('produit_store');
                Route::get('/associer/{id}', 'ProduitsController@associer')->name('produit_associer');
                Route::post('/plug', 'ProduitsController@plug')->name('produit_plug');
                Route::get('/edit/{id}', 'ProduitsController@edit')->name('produit_edit');
                Route::post('/update/{id}', 'ProduitsController@update')->name('produit_update');
                Route::get('/delete/{id}', 'ProduitsController@delete')->name('produit_delete');
            }
        );
    }
);

Route::prefix('home')->group(
    function () {

        Route::prefix('/attributions/passage')->group(
            function () {
                Route::get('/', 'AttributionsPassagesController@index')->name('attributions_pass_index');
                Route::get('/add', 'AttributionsPassagesController@add')->name('attributions_pass_add');
                Route::post('/store', 'AttributionsPassagesController@store')->name('attributions_pass_store');
                Route::get('/edit/{id}', 'AttributionsPassagesController@edit')->name('attributions_pass_edit');
                Route::post('/update/{id}', 'AttributionsPassagesController@update')->name('attributions_pass_update');
                Route::get('/delete/{id}', 'AttributionsPassagesController@delete')->name('attributions_pass_delete');
                Route::get('/liberer/{id}', 'AttributionsPassagesController@liberer')->name('attributions_pass_liberer');
            }
        );

        Route::get('/sejour', 'AttributionsSejoursController@index')->name('attributions_sejour_index');

        Route::prefix('/pieces')->group(
            function () {
                Route::get('/', 'TypesPiecesController@index')->name('type_piece_index');
                Route::get('/add', 'TypesPiecesController@add')->name('type_piece_add');
                Route::post('/store', 'TypesPiecesController@store')->name('type_piece_store');
                Route::get('/edit/{id}', 'TypesPiecesController@edit')->name('type_piece_edit');
                Route::get('/delete/{id}', 'TypesPiecesController@delete')->name('type_piece_delete');
                Route::post('/update/{id}', 'TypesPiecesController@update')->name('type_piece_update');
            }
        );

        Route::prefix('/client')->group(
            function () {
                Route::get('/client/index', 'ClientsController@index')->name('client_index');
                Route::get('/client/edit/{id}', 'ClientsController@edit')->name('client_edit');
                Route::post('/client/update/{id}', 'ClientsController@update')->name('client_update');
                Route::get('/client/delete/{id}', 'ClientsController@delete')->name('client_delete');
            }
        );

        Route::get('/restaurations', 'RestaurationsController@index')->name('resto_index');
        Route::get('/restauration/add/{attribution}', 'RestaurationsController@add')->name('resto_add');
        Route::get('/restauration/new/{attribution}', 'RestaurationsController@new')->name('resto_new');
        Route::get('/restauration/sejour/pdf/proforma/{attribution}', 'RestaurationsController@sejourProformaPdf')->name('resto_sejour_proforma_pdf');
        Route::get('/restauration/sejour/pdf/facture/{attribution}', 'RestaurationsController@sejourFacturePdf')->name('resto_sejour_facture_pdf');
        Route::get('/restauration/passage/pdf/proforma/{attribution}', 'RestaurationsController@passageProformaPdf')->name('resto_passage_proforma_pdf');
        Route::get('/restauration/passage/pdf/facture/{attribution}', 'RestaurationsController@passageFacturePdf')->name('resto_passage_facture_pdf');

        Route::prefix('/approvisionnement')->group(
            function () {
                Route::get('/', 'ApprovisionnementsController@index')->name('appro_index');
                Route::get('/accessoires', 'ApprovisionnementsController@accessoires')->name('appro_accessioire_index');
                Route::get('/consommables', 'ApprovisionnementsController@consommables')->name('appro_consommable_index');
                Route::get('/add', 'ApprovisionnementsController@add')->name('appro_add');
                Route::get('/edit/{id}', 'ApprovisionnementsController@edit')->name('appro_edit');
                Route::get('/update', 'ApprovisionnementsController@update')->name('appro_update');
            }
        );


        Route::prefix('/facture')->group(
            function () {
                Route::get('/', 'FacturesController@index')->name('facture_index');
                Route::get('/show/{id}', 'FacturesController@show')->name('facture_show');
                Route::get('/ticket/{id}', 'FacturesController@ticket')->name('facture_ticket');
                Route::get('/print/{id}', 'FacturesController@print')->name('facture_print');
                Route::get('/solder/{id}', 'FacturesController@solder')->name('facture_solder');
                // Route::get('/edit/{id}','FacturesController@edit')->name('facture_edit') ;
                // Route::get('/update/{id}','FacturesController@update')->name('facture_update') ;
            }
        );

        Route::prefix('/inventaire')->group(
            function () {
                Route::get('/', 'InventairesController@index')->name('inventaire_index');
            }
        );

        Route::prefix('/point')->group(
            function () {
                Route::get('/ventes', 'PointVentesController@index')->name('point_index');
            }
        );

        Route::get('/destockage/add/sejour/{id}', 'DestockagesController@addFromSejour')->name('destockage_sejour_add');
        Route::get('/destockage/add/passage/{id}', 'DestockagesController@addFromPassage')->name('destockage_passage_add');

    }
);

Route::prefix('/ajax')->group(
    function () {

        Route::get('/batiments/all/', 'BatimentsController@allBatiments')->name('all_batiment');
        Route::get('/chambres/all/{batiment}', 'ApiPassageController@allRooms')->name('all_chambre');
        Route::get('/chambres/empty/{batiment}', 'ApiPassageController@emptyRooms')->name('empty_chambre');
        Route::get('/chambre/details/{chambre}', 'ChambresController@details')->name('chambre_details');
        Route::get('/chambres/used/{batiment}', 'ApiPassageController@usedRooms')->name('used_chambre');
        Route::post('/attribution/passage', 'ApiPassageController@attribuer')->name('attribution_passage');
        Route::post('/liberation/passage', 'ApiPassageController@liberer')->name('liberation_passage');

        Route::post('/sejour/add', 'AttributionsSejoursController@add')->name('attributions_sejour_add');
        Route::get('/sejour/infos/{attribution}', 'AttributionsSejoursController@infos')->name('attributions_sejour_infos');
        Route::get('/sejour/all', 'AttributionsSejoursController@getAll')->name('attributions_sejour_all');
        Route::post('/sejour/update', 'AttributionsSejoursController@update')->name('attributions_sejour_update');
        Route::post('/sejour/liberer', 'AttributionsSejoursController@liberer')->name('attributions_sejour_liberation');
        Route::post('/sejour/supprimer', 'AttributionsSejoursController@delete')->name('attributions_sejour_delete');

        Route::get('/typePiece/all', 'TypesPiecesController@pieces')->name('all_pieces');

        Route::get('/produit/all', 'ProduitsController@getAll')->name('all_produit');
        Route::get('/produit/consommables/all', 'ProduitsController@getConsommables')->name('all_consommables');
        Route::get('/produit/accessoire/all', 'ProduitsController@getAccessoires')->name('all_accessoire');
        Route::post('/produit/show', 'ProduitsController@getDetails')->name('show_produit');


        Route::post('/restauration/proformas', 'RestaurationsController@getProformas')->name('resto_proformas');
        Route::post('/restauration/passage/proformas', 'RestaurationsController@getPassageProformas')->name('resto_passage_proformas');
        Route::post('/restauration/save', 'RestaurationsController@saveProformas')->name('save_proformas');
        Route::post('/restauration/passage/save', 'RestaurationsController@savePassageProformas')->name('save_passage_proformas');
        Route::post('/restauration/solder', 'RestaurationsController@solder')->name('solde_proforma');
        Route::post('/restauration/passage/solder', 'RestaurationsController@passageSolder')->name('solde_passage_proforma');
        Route::post('/restauration/delete', 'RestaurationsController@delete')->name('delete_proformas');
        Route::post('/restauration/passage/delete', 'RestaurationsController@passageDelete')->name('delete_passage_proforma');
        Route::post('/restauration/check', 'RestaurationsController@check')->name('product_check_quantity');

        Route::post('/destockage/sejour/save', 'DestockagesController@sejourSave')->name('destockage_sejour_save');
        Route::post('/destockage/passage/save', 'DestockagesController@passageSave')->name('destockage_passage_save');
        Route::post('/destockage/check', 'DestockagesController@check')->name('produit_stock_check');
        Route::get('/destockage/sejour/saved/{id}', 'DestockagesController@sejourSaved')->name('produit_sejour_saved');
        Route::get('/destockage/passage/saved/{id}', 'DestockagesController@passageSaved')->name('produit_passage_saved');
        Route::post('/destockage/update/saved', 'DestockagesController@updateSaved')->name('update_produit_saved');
        Route::post('/destockage/delete/saved', 'DestockagesController@deleteSaved')->name('delete_sejour_saved');

        Route::post('/approvisionnement/save', 'ApprovisionnementsController@save')->name('appro_save');
        Route::post('/approvisionnement/edit', 'ApprovisionnementsController@edit')->name('appro_edit');

        Route::post('/multicritere/one_date', 'InventairesController@searchByDate')->name('inventaire_date');
        Route::post('/multicritere/interval_date', 'InventairesController@searchByDateInterval')->name('inventaire_date_interval');
        Route::post('/multicritere/default', 'InventairesController@searchDefault')->name('inventaire_default');

        Route::post('/multicritere/vente/one_date', 'PointVentesController@searchByDate')->name('point_vente_date');
        Route::post('/multicritere/vente/interval_date', 'PointVentesController@searchByDateInterval')->name('point_vente_date_interval');
        Route::post('/multicritere/vente/default', 'PointVentesController@searchDefault')->name('point_vente_default');

        Route::post('/solder', 'FacturesController@solderTable')->name('facture_table_solder');
    }
);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
