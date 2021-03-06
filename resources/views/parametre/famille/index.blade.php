@extends('layouts.default')
@section('breadcrumb')
   {{ Breadcrumbs::render('familles') }}
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
            <h5 class="m-0">Familles</h5>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-6">
                  <h6 class="card-title">Liste des grandes catégories de produits</h6>
               </div>
               <div class="col-md-2">
                  <a style="width:100%" href="{{ route('accessoire_index') }}" class="btn btn-outline-primary"><i
                        class="fas fa-box"></i> Accéssoires</a>
               </div>
               <div class="col-md-2">
                  <a style="width:100%" href="{{ route('consommable_index') }}" class="btn btn-outline-primary"><i
                        class="fas fa-shopping-bag"></i> Consommables</a>
               </div>
               <div class="col-md-2">
                  <a style="width:100%" href="{{ route('famille_add') }}" class="btn btn-outline-primary"><i
                        class="fas fa-plus"></i> ajouter</a>
               </div>
            </div>
            <p class="card-text">
            <table id="famille" class="table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Libelle</th>
                     <th>Option</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($familles as $key => $famille)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $famille->libelle }}</td>
                        <td>
                           <a href="{{ route('famille_edit', $famille) }}" class="btn btn-outline-success"><i
                                 class="fas fa-edit"></i> modifier</a>
                           <a href="{{ route('famille_delete', $famille) }}" class="btn btn-outline-danger"><i
                                 class="fas fa-trash"></i> supprimer</a>
                           <a href="{{ route('famille_show', $famille) }}" class="btn btn-outline-warning"><i
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
