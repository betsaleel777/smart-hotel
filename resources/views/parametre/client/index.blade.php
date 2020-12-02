@extends('layouts.default')
@section('breadcrumb')
   {{ Breadcrumbs::render('clients') }}
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
            <h5 class="m-0">CLIENTS</h5>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-10">
                  <h6 class="card-title">Liste des clients qui ont déjà séjournés</h6>
               </div>
            </div>
            <p class="card-text">
            <table id="client" class="table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Nom</th>
                     <th>Prenom</th>
                     <th>Contact</th>
                     <th>Type de Pièce</th>
                     <th>N°Pièce</th>
                     <th>Option</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($clients as $key => $client)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $client->nom }}</td>
                        <td>{{ $client->prenom }}</td>
                        <td>{{ $client->contact }}</td>
                        <td>{{ $client->pieceLinked->libelle }}</td>
                        <td>{{ $client->numero_piece }}</td>
                        <td>
                           <a href="{{ route('client_edit', $client) }}" class="btn btn-outline-success"><i
                                 class="fas fa-edit"></i> modifier</a>
                           <a href="{{ route('client_delete', $client) }}" class="btn btn-outline-danger"><i
                                 class="fas fa-trash"></i> supprimer</a>
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
         $('#client').DataTable();
      });

   </script>
@endsection
