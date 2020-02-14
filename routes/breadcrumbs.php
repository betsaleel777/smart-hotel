<?php
//----------------- Acceuil --------------------------
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Tableau de bord', route('dashboard'));
});
//Acceuil > Batiments
Breadcrumbs::for('batiments', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Batiments', route('batiment_index'));
});
//Acceuil > Batiments > ajouter batiment
Breadcrumbs::for('batiment_add', function ($trail) {
    $trail->parent('batiments');
    $trail->push('Ajouter Batiment', route('batiment_add'));
});
//Acceuil > batiments > modifier batiment
Breadcrumbs::for('batiment_edit', function ($trail,$batiment) {
    $trail->parent('batiments');
    $trail->push('Modifier '.$batiment->libelle, route('batiment_edit',$batiment));
});
//Acceuil > batiments > Detail {libelle}
Breadcrumbs::for('batiment_show', function ($trail,$batiment) {
    $trail->parent('batiments');
    $trail->push('Détails '.$batiment->libelle, route('batiment_show',$batiment));
});

//Acceuil > Type
Breadcrumbs::for('types', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Type de Chambre', route('type_index'));
});
//Acceuil > Type > ajouter type
Breadcrumbs::for('type_add', function ($trail) {
    $trail->parent('types');
    $trail->push('Ajouter Type', route('type_add'));
});
//Acceuil > types > modifier type
Breadcrumbs::for('type_edit', function ($trail,$type) {
    $trail->parent('types');
    $trail->push('Modifier '.$type->libelle, route('type_edit',$type));
});

//Acceuil > Chambres
Breadcrumbs::for('chambres', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Chambres', route('type_index'));
});

//Acceuil > Chambres > ajouter chambre
Breadcrumbs::for('chambre_add', function ($trail) {
    $trail->parent('chambres');
    $trail->push('Ajouter Chambre', route('chambre_add'));
});
//Acceuil > chambre > modifier chambre
Breadcrumbs::for('chambre_edit', function ($trail,$chambre) {
    $trail->parent('chambres');
    $trail->push('Modifier '.$chambre->libelle, route('chambre_edit',$chambre));
});

//Acceuil > attributions
Breadcrumbs::for('attributions', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Attributions', route('attributions_pass_index'));
});

Breadcrumbs::for('attributions_pass_add', function ($trail) {
    $trail->parent('attributions');
    $trail->push('Attributions', route('attributions_pass_add'));
});
//---------------------------------

//Acceuil > type de pièce
Breadcrumbs::for('pieces', function ($trail) {
  $trail->parent('dashboard');
  $trail->push('Pièces', route('type_piece_index'));
});

//Acceuil > Type de pièce > ajouter
Breadcrumbs::for('type_piece_add', function ($trail) {
    $trail->parent('pieces');
    $trail->push('Créer', route('type_piece_add'));
});

//Acceuil > type de chambre > modifier chambre
Breadcrumbs::for('type_piece_edit', function ($trail,$piece) {
    $trail->parent('pieces');
    $trail->push('Modifier '.$piece->libelle, route('type_piece_edit',$piece));
});

//Acceuil > clients
Breadcrumbs::for('clients',function($trail){
  $trail->parent('dashboard') ;
  $trail->push('Clients',route('client_index')) ;
});
//Acceuil > clients > ajouter
Breadcrumbs::for('client_add',function($trail){
  $trail->parent('clients') ;
  $trail->push('Ajouter Client',route('client_add')) ;
});
//Acceuil > client > edit
Breadcrumbs::for('client_edit',function($trail,$client){
  $trail->parent('clients') ;
  $trail->push('Modifier '.$client->nom,route('client_edit',$client)) ;
});

//Acceuil > familles
Breadcrumbs::for('familles',function($trail){
  $trail->parent('dashboard') ;
  $trail->push('Familles',route('famille_index')) ;
});
//Acceuil > familles > ajouter
Breadcrumbs::for('famille_add',function($trail){
  $trail->parent('familles') ;
  $trail->push('Ajouter Familles',route('famille_add')) ;
});
//Acceuil > familles > edit
Breadcrumbs::for('famille_edit',function($trail,$famille){
  $trail->parent('familles') ;
  $trail->push('Modifier '.$famille->libelle,route('famille_edit',$famille)) ;
});
//Acceuil > familles > show
Breadcrumbs::for('famille_show',function($trail,$famille){
  $trail->parent('familles') ;
  $trail->push('Détails '.$famille->libelle,route('famille_show',$famille)) ;
});
//Acceuil > famille > show >  associer sous famille
Breadcrumbs::for('sous_famille_associer',function($trail,$famille){
  $trail->parent('famille_show',$famille) ;
  $trail->push('Ajouter dans '.$famille->libelle,route('sous_famille_associer',$famille)) ;
});


//Acceuil > sous_familles
Breadcrumbs::for('sous_familles',function($trail){
  $trail->parent('dashboard') ;
  $trail->push('Sous familles',route('sous_famille_index')) ;
});
//Acceuil > sous_familles > add
Breadcrumbs::for('sous_famille_add',function($trail){
  $trail->parent('sous_familles') ;
  $trail->push('Sous familles',route('sous_famille_add')) ;
});
//Acceuil > sous_familles > edit
Breadcrumbs::for('sous_famille_edit',function($trail,$sous_famille){
  $trail->parent('sous_familles') ;
  $trail->push('Modifier '.$sous_famille->libelle,route('sous_famille_edit',$sous_famille)) ;
});

//Acceuil > produits
Breadcrumbs::for('produits',function($trail){
  $trail->parent('dashboard') ;
  $trail->push('Produits',route('produit_index')) ;
});
//Acceuil > produits > add
Breadcrumbs::for('produit_add',function($trail){
  $trail->parent('produits') ;
  $trail->push('Ajouter Produit',route('produit_add')) ;
});
//Acceuil > produits > edit
Breadcrumbs::for('produit_edit',function($trail,$produit){
  $trail->parent('produits') ;
  $trail->push('Modifier '.$produit->libelle,route('produit_edit',$produit)) ;
});

//Acceuil > sejours
Breadcrumbs::for('sejours',function($trail){
  $trail->parent('dashboard') ;
  $trail->push('Sejours & reservation',route('attributions_sejour_index')) ;
});

//Acceuil > restauration
Breadcrumbs::for('restauration_add',function($trail,$attribution){
  $trail->parent('sejours') ;
  $trail->push('Plats & boissons',route('resto_add',$attribution)) ;
});
Breadcrumbs::for('restauration_passage_add',function($trail,$attribution){
  $trail->parent('attributions') ;
  $trail->push('Plats & boissons',route('resto_add',$attribution)) ;
});


?>
