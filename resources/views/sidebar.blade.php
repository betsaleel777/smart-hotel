<!-- Main Sidebar Container -->
@php
$departement = Auth::user()->departementLinked()->first() ;
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
         class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ mb_strtoupper($departement->nom) }}</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
            <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
         </div>
         <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
         </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item">
               <a href="{{ route('dashboard') }}" class="nav-link active">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                     Tableau de Bord
                  </p>
               </a>
            </li>
            @if ($departement->id === 1)
               <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                     <i class="nav-icon fas fa-home"></i>
                     <p>
                        Fichiers
                        <i class="right fas fa-angle-left"></i>
                     </p>
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="{{ route('attributions_sejour_index') }}" class="nav-link ">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Séjour</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('attributions_pass_index') }}" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Passage & repos</p>
                        </a>
                     </li>
                  </ul>
               </li>
               <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                     <i class="nav-icon fas fa-home"></i>
                     <p>
                        Stock
                        <i class="right fas fa-angle-left"></i>
                     </p>
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="{{ route('appro_index') }}" class="nav-link ">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Approvisionement</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('appro_secondaire_index') }}" class="nav-link ">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Stock département</p>
                        </a>
                     </li>
                  </ul>
               </li>
            @endif
            <li class="nav-item">
               <a href="{{ route('service_vente_index') }}" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                     Service de ventes
                     @if (!(session('ventes_en_attente') == 0))
                        <span class="right badge badge-danger">{{ session('ventes_en_attente') }}</span>
                     @endif
                  </p>
               </a>
            </li>
            @if ($departement->id === 1)
               <li class="nav-item">
                  <a href="{{ route('facture_index') }}" class="nav-link">
                     <i class="nav-icon fas fa-th"></i>
                     <p>
                        Factures
                     </p>
                  </a>
               </li>
               <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                     <i class="nav-icon fas fa-cogs"></i>
                     <p>
                        Parametres
                        <i class="right fas fa-angle-left"></i>
                     </p>
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="{{ route('batiment_index') }}" class="nav-link ">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Batiments</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('type_index') }}" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Types de Chambre</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('chambre_index') }}" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Chambres</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('type_piece_index') }}" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Type de pièce</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('client_index') }}" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Clients</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('famille_index') }}" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Familles</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('table_index') }}" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Tables</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('compte_index') }}" class="nav-link">
                           <i class="far fa-circle nav-icon"></i>
                           <p>Gestion des utilisateurs</p>
                        </a>
                     </li>
                  </ul>
               </li>
            @endif
            <li class="nav-item has-treeview">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-home"></i>
                  <p>
                     Etats
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="{{ route('inventaire_index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Inventaire</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('point_index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Point des Ventes</p>
                     </a>
                  </li>
               </ul>
            </li>
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
</aside>
