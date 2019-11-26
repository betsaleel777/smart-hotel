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

//Acceuil > Attributions > ajouter
Breadcrumbs::for('attributions_pass_add', function ($trail) {
    $trail->parent('attributions');
    $trail->push('Créer', route('attributions_pass_add'));
});





?>
