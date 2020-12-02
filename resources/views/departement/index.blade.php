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
@section('meta')
   <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
   <div class="col-lg-12">
      <div class="card">
         <div class="card-header">
            <h5 class="m-0">DEPARTEMENTS</h5>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-10">
                  <h6 class="card-title">Liste des départements</h6>
               </div>
               <div class="col-md-2">
                  <modal-departement reload="true"></modal-departement>
               </div>
            </div>
            <div class="card-text">
               <table id="departement" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Libelle</th>
                        <th>Option</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($departements as $key => $departement)
                        <tr>
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $departement->nom }}</td>
                           <td>
                              <a href="{{ route('departement_edit', $departement) }}" class="btn btn-outline-success"><i
                                    class="fas fa-edit"></i> modifier</a>
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
   <script src="{{ asset('js/app.js') }}"></script>
   <script src=" {{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
   <script src=" {{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }} "></script>
   <script src=" {{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }} "></script>
   <script src=" {{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }} "></script>
   <script>
      $(function() {
         $('#departement').DataTable();
      });

   </script>
@endsection
