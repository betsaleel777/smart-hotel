@extends('layouts.default')
{{-- @section('breadcrumb')
{{ Breadcrumbs::render('pieces') }}
@endsection --}}
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
            <h5 class="m-0">Services en cours</h5>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-10">
                  <h6 class="card-title">Liste des services</h6>
               </div>
               <div class="col-md-2">
                  <a href="{{ route('service_vente_add') }}" class="btn btn-primary">ajouter</a>
               </div>
            </div>
            <div class="card-text">
               <table id="vente" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Table</th>
                        <th>Addition</th>
                        <th>departement</th>
                        <th>Etat</th>
                        <th>Option</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($ventes as $key => $vente)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td><b>{{ $vente->code }}</b></td>
                           <td>{{ 'table ' . $vente->tableLinked->numero }}</td>
                           <td>{{ $vente->addition }}</td>
                           <td>{{ $vente->departementLinked->nom }}</td>
                           <td>
                              @empty($vente->etat)
                                 <h5><span class="badge badge-pill badge-danger">impayer</span></h5>
                              @else
                                 <h5><span class="badge badge-pill badge-success">facturer</span></h5>
                              @endempty
                           </td>
                           <td>
                              @empty($vente->etat)
                                 <a href="{{ route('service_vente_edit', $vente->code) }}" class="btn btn-outline-primary"><i
                                       class="fas fa-edit"></i> modifier</a>
                              @else
                                 <a href="{{ route('service_vente_show', $vente->code) }}" class="btn btn-outline-warning"><i
                                       class="fas fa-dollar-sign"></i> facture</a>
                              @endempty
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
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
         $('#vente').DataTable();
      });

   </script>
@endsection
