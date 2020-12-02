@extends('layouts.default')
@section('breadcrumb')
   {{ Breadcrumbs::render('sous_familles') }}
@endsection
@section('link')
   <!-- Ionicons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- DataTables -->
   <link rel="stylesheet" href=" {{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }} ">
   <link rel="stylesheet" href=" {{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }} ">
@endsection
@section('content')
   <div class="col-lg-12">
      <div class="card">
         <div class="card-header">
            <h5 class="m-0">Sous Familles</h5>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-10">
                  <h6 class="card-title">Liste des catégories associées</h6>
               </div>
               {{-- <div class="col-md-2">
                  <a style="width:100%" href="{{ route('sous_famille_index') }}" class="btn btn-outline-primary"><i
                        class="fas fa-cube"></i> Toutes</a>
               </div> --}}
               <div class="col-md-2">
                  <a style="width:100%" href="{{ route('sous_famille_add') }}" class="btn btn-outline-primary"><i
                        class="fas fa-plus"></i> ajouter</a>
               </div>
            </div>
            <p class="card-text">
            <table id="famille" class="table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Libelle</th>
                     <th>Famille</th>
                     <th>Option</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($sous_familles as $key => $sous_famille)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $sous_famille->libelle }}</td>
                        <td>{{ $sous_famille->familleLinked->libelle }}</td>
                        <td>
                           <a href="{{ route('sous_famille_edit', $sous_famille) }}" class="btn btn-outline-success"><i
                                 class="fas fa-edit"></i> modifier</a>
                           <a href="{{ route('sous_famille_delete', $sous_famille) }}" class="btn btn-outline-danger"><i
                                 class="fas fa-trash"></i> supprimer</a>
                           <a href="{{ route('sous_famille_show', $sous_famille) }}" class="btn btn-outline-warning"><i
                                 class="fas fa-eye"></i> voir</a>
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
   <script src=" {{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
   <script src=" {{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }} "></script>
   <script src=" {{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }} "></script>
   <script src=" {{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }} "></script>
   <script>
      $(function() {
         $('#famille').DataTable();
      });

   </script>
@endsection
