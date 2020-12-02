@extends('layouts.default')
{{-- @section('breadcrumb')
{{ Breadcrumbs::render('batiments') }}
@endsection --}}
@section('link')
   <!-- Ionicons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- DataTables -->
   <link rel="stylesheet" href=" {{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }} ">
   <link rel="stylesheet" href=" {{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }} ">
@endsection
@section('meta')
   <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
   <div class="col-lg-12">
      <div class="card">
         <div class="card-header">
            <h5 class="m-0">Approvisionnements</h5>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-10">
                  <h6 class="card-title"></h6>
               </div>
               <div class="col-md-2">
                  {{-- si la session n'est pas admin afficher lien vers la vue
                  appro_secondaire_add_session --}}
                  <a style="width:100%" href="{{ route('appro_secondaire_add') }}" class="btn btn-outline-primary"><i
                        class="fas fa-plus"></i> ajouter</a>
               </div>
            </div>
            <p class="card-text">
            <table id="appro" class="table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Produit</th>
                     <th>Quantite</th>
                     <th>Seuil</th>
                     <th>Département</th>
                     <th>Option</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($appros as $key => $appro)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $appro->produitLinked->libelle }}</td>
                        <td>{{ $appro->quantite }}</td>
                        <td>{{ $appro->produitLinked->seuil }}</td>
                        <td>{{ $appro->departementLinked->nom }}</td>
                        <td>
                           <modal-button-appro :id="'{{ (int) $appro->id }}'" :valeur="'{{ (int) $appro->quantite }}'"
                              :produit="'{{ str_replace("'", ' ', $appro->produitLinked->libelle) }}'">
                           </modal-button-appro>
                           {{-- <a href="{{ route('appro_edit', $appro) }}"
                              class="btn btn-outline-success"><i class="fas fa-edit"></i>modifier</a>
                           <a href="{{ route('appro_delete', $appro) }}" class="btn btn-outline-danger"><i
                                 class="fas fa-trash"></i>supprimer</a> --}}
                           {{-- <a href="{{ route('appro_show', $appro) }}"
                              class="btn btn-outline-warning"><i class="fas fa-eye"></i>voir</a>
                           --}}
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
            </p>
         </div>
      </div>
   </div>
@endsection
@section('script')
   <!-- DataTables -->
   <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
   <script src=" {{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
   <script src=" {{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }} "></script>
   <script src=" {{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }} "></script>
   <script src=" {{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }} "></script>
   <script>
      $(function() {
         $('#appro').DataTable();
      });

   </script>
@endsection
