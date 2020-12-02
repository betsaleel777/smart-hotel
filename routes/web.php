<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
Route::get('/deconnexion', 'Auth\LoginController@logout')->name('deconnexion');

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

        Route::prefix('/compte')->group(
            function () {
                Route::get('/', 'ComptesController@index')->name('compte_index');
                Route::get('/add', 'ComptesController@add')->name('compte_add');
                Route::post('/store', 'ComptesController@store')->name('compte_store');
                Route::get('/edit/{id}', 'ComptesController@edit')->name('compte_edit');
                Route::post('/update/{id}', 'ComptesController@update')->name('compte_update');
                Route::get('/delete/{id}', 'ComptesController@delete')->name('compte_delete');
                Route::get('/show/{id}', 'ComptesController@show')->name('compte_show');
                // Route::get('/associer/{id}', 'SousFamillesController@associer')->name('sous_famille_associer');
                // Route::get('/ajax/{famille}', 'SousFamillesController@getSousFamilles')->name('sous_famille_concerned');
                // Route::post('/plug', 'SousFamillesController@plug')->name('sous_famille_plug');
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

        Route::prefix('/table')->group(function () {
            Route::get('/', 'TablesController@index')->name('table_index');
            Route::get('/add', 'TablesController@add')->name('table_add');
            Route::post('/store', 'TablesController@store')->name('table_store');
            Route::get('/edit/{id}', 'TablesController@edit')->name('table_edit');
            Route::post('/update/{id}', 'TablesController@update')->name('table_update');
            Route::get('/delete/{id}', 'TablesController@delete')->name('table_delete');
        });
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
                Route::get('/index', 'ClientsController@index')->name('client_index');
                Route::get('/edit/{id}', 'ClientsController@edit')->name('client_edit');
                Route::post('/update/{id}', 'ClientsController@update')->name('client_update');
                Route::get('/delete/{id}', 'ClientsController@delete')->name('client_delete');
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

        Route::prefix('/destockage')->group(
            function () {
                Route::get('/add/sejour/{id}', 'DestockagesController@addFromSejour')->name('destockage_sejour_add');
                Route::get('/add/passage/{id}', 'DestockagesController@addFromPassage')->name('destockage_passage_add');
            }
        );

        Route::prefix('/departement')->group(
            function () {
                Route::get('/index', 'DepartementsController@index')->name('departement_index');
                Route::post('/store', 'DepartementsController@store')->name('departement_store');
                Route::get('/edit/{id}', 'DepartementsController@edit')->name('departement_edit');
                Route::post('/update/{id}', 'DepartementsController@update')->name('departement_update');
            }
        );

        Route::prefix('/secondaire')->group(
            function () {
                Route::get('/index', 'SecondairesController@index')->name('appro_secondaire_index');
                Route::get('/add/default', 'SecondairesController@add')->name('appro_secondaire_add');
                Route::get('/add/session', 'SecondairesController@addSession')->name('appro_secondaire_add_session');
            }
        );

        Route::prefix('/vente')->group(
            function () {
                Route::get('/index', 'ServiceVentesController@index')->name('service_vente_index');
                Route::get('/add', 'ServiceVentesController@add')->name('service_vente_add');
                Route::get('/edit/{code}', 'ServiceVentesController@edit')->name('service_vente_edit');
                Route::get('/show/{code}', 'ServiceVentesController@show')->name('service_vente_show');
                Route::get('/ticket/{code}', 'ServiceVentesController@recu')->name('service_vente_ticket');
            }
        );

    }
);

Route::prefix('/ajax')->group(
    function () {

        Route::get('/batiments/all/', 'BatimentsController@allBatiments');

        Route::get('/chambres/all/{batiment}', 'ApiPassageController@allRooms');
        Route::get('/chambres/empty/{batiment}', 'ApiPassageController@emptyRooms');
        Route::get('/chambre/details/{chambre}', 'ChambresController@details');
        Route::get('/chambres/used/{batiment}', 'ApiPassageController@usedRooms');

        Route::post('/attribution/passage', 'ApiPassageController@attribuer');
        Route::post('/liberation/passage', 'ApiPassageController@liberer');

        Route::post('/sejour/add', 'AttributionsSejoursController@add');
        Route::get('/sejour/infos/{attribution}', 'AttributionsSejoursController@infos');
        Route::get('/sejour/all', 'AttributionsSejoursController@getAll');
        Route::post('/sejour/update', 'AttributionsSejoursController@update');
        Route::post('/sejour/liberer', 'AttributionsSejoursController@liberer');
        Route::post('/sejour/supprimer', 'AttributionsSejoursController@delete');

        Route::get('/typePiece/all', 'TypesPiecesController@pieces');

        Route::get('/produit/all', 'ProduitsController@getAll');
        Route::get('/produit/consommables/all', 'ProduitsController@getConsommables');
        Route::get('/produit/consommables/departement/{id}', 'ProduitsController@getConsommablesByDep');
        Route::get('/produit/accessoire/all', 'ProduitsController@getAccessoires');
        Route::post('/produit/show', 'ProduitsController@getDetails');

        Route::post('/restauration/proformas', 'RestaurationsController@getProformas');
        Route::post('/restauration/passage/proformas', 'RestaurationsController@getPassageProformas');
        Route::post('/restauration/save', 'RestaurationsController@saveProformas');
        Route::post('/restauration/passage/save', 'RestaurationsController@savePassageProformas');
        Route::post('/restauration/solder', 'RestaurationsController@solder');
        Route::post('/restauration/passage/solder', 'RestaurationsController@passageSolder');
        Route::post('/restauration/delete', 'RestaurationsController@delete');
        Route::post('/restauration/passage/delete', 'RestaurationsController@passageDelete');
        Route::post('/restauration/check', 'RestaurationsController@check');
        Route::post('/restauration/departement/check', 'RestaurationsController@checkByDepartement');

        Route::post('/destockage/sejour/save', 'DestockagesController@sejourSave');
        Route::post('/destockage/passage/save', 'DestockagesController@passageSave');
        Route::post('/destockage/check', 'DestockagesController@check');
        Route::get('/destockage/sejour/saved/{id}', 'DestockagesController@sejourSaved');
        Route::get('/destockage/passage/saved/{id}', 'DestockagesController@passageSaved');
        Route::post('/destockage/update/saved', 'DestockagesController@updateSaved');
        Route::post('/destockage/delete/saved', 'DestockagesController@deleteSaved');

        Route::post('/approvisionnement/save', 'ApprovisionnementsController@save');
        Route::post('/approvisionnement/edit', 'ApprovisionnementsController@edit');

        //Route::post('/multicritere/one_date', 'InventairesController@searchByDate')->name('inventaire_date');
        //Route::post('/multicritere/interval_date', 'InventairesController@searchByDateInterval')->name('inventaire_date_interval');
        Route::post('/multicritere/default', 'InventairesController@searchDefault');
        Route::post('/multicritere/departement', 'InventairesController@searchByDepartement');
        Route::post('/multicritere/vente/one_date', 'PointVentesController@searchByDate');
        Route::post('/multicritere/vente/interval_date', 'PointVentesController@searchByDateInterval');
        Route::post('/multicritere/vente/default', 'PointVentesController@searchDefault');

        Route::get('/tables', 'TablesController@getAll');

        Route::post('/solder', 'FacturesController@solderTable');

        Route::post('/departement/store', 'DepartementsController@storejs');
        Route::get('/departements', 'DepartementsController@getDepartements');

        Route::post('/secondaire/store', 'SecondairesController@storejs');
        Route::get('/secondaires', 'SecondairesController@getList');

        Route::post('/ventes/store', 'ServiceVentesController@storejs');
        Route::post('/ventes/update', 'ServiceVentesController@updatejs');
        Route::post('/ventes/solder', 'ServiceVentesController@solderjs');
        Route::get('/ventes/old/{code}', 'ServiceVentesController@oldVentes');
        Route::post('/ventes/stats', 'ServiceVentesController@statjs');
    }
);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
