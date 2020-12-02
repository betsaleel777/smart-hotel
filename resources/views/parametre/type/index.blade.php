@extends('layouts.default')
@section('breadcrumb')
   {{ Breadcrumbs::render('types') }}
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
            <h5 class="m-0">TYPES DE CHAMBRE</h5>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-10">
                  <h6 class="card-title">Liste des différents types de chambre.</h6>
               </div>
               <div class="col-md-2">
                  <a style="width:100%" href="{{ route('type_add') }}" class="btn btn-outline-primary"><i
                        class="fas fa-plus"></i> ajouter</a>
               </div>
            </div>
            <p class="card-text">
            <table id="typeChambre" class="table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Libelle</th>
                     <th>Repos(Fcfa/h)</th>
                     <th>Passage(Fcfa/h)</th>
                     <th>Réservation (Fcfa/j)</th>
                     <th>Option</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($types as $key => $type)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $type->libelle }}</td>
                        <td>{{ $type->cout_repos }}</td>
                        <td>{{ $type->cout_passage }}</td>
                        <td>{{ $type->cout_reservation }}</td>
                        <td>
                           <a href="{{ route('type_edit', $type) }}" class="btn btn-outline-success"><i
                                 class="fas fa-edit"></i>modifier</a>
                           <a href="{{ route('type_delete', $type) }}" class="btn btn-outline-danger"><i
                                 class="fas fa-trash"></i>supprimer</a>
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
         $('#typeChambre').DataTable({
            "paging": true,
            "searching": true,
            "lengthChange": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
         });
      });

   </script>
@endsection
