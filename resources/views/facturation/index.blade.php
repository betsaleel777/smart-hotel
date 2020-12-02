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
@php
$badge = ['facturer' => 'badge badge-success' ,
'libérer' => 'badge badge-primary',
'libéré' => 'badge badge-primary']
@endphp
@section('content')
   <div class="col-lg-12">
      <div class="card">
         <div class="card-header">
            <h5 class="m-0">Factures</h5>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-10">
                  <h6 class="card-title">Liste des factures</h6>
               </div>
               {{-- <div class="col-md-2">
                  <a style="width:100%" href="{{ route('facture_add') }}" class="btn btn-outline-primary"><i
                        class="fas fa-plus"></i> ajouter</a>
               </div> --}}
            </div>
            <p class="card-text">
            <table id="facture" class="table table-bordered table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Code</th>
                     <th>Client</th>
                     <th>Service</th>
                     <th>Délais</th>
                     <th>Statut</th>
                     <th>Date</th>
                     <th>Option</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($factures as $key => $facture)
                     @php
                     $etat = null ;
                     if($facture->sejourLinked){
                     $etat = $facture->sejourLinked->etat ;
                     }else{
                     $etat = $facture->passageLinked->etat ;
                     }
                     @endphp
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $facture->reference }}</td>
                        @if ($facture->clientLinked)
                           <td>{{ $facture->clientLinked->nom }}</td>
                        @else
                           <td>{{ 'Aucun' }}</td>
                        @endif
                        @if ($facture->passage_nature)
                           <td>{{ $facture->passage_nature }}</td>
                        @else
                           <td>{{ 'sejour' }}</td>
                        @endif
                        @if ($facture->passage_nature === 'repos' or $facture->passage_nature === 'passage')
                           <td>{{ $facture->quantite . ' Heures' }}</td>
                        @else
                           <td>{{ $facture->quantite . ' Jours' }}</td>
                        @endif
                        @if ($etat)
                           <td>
                              <h5><span class="{{ $badge[$etat] }}">{{ $etat }}</span></h5>
                           </td>
                        @else
                           <td>
                              <h5><span class="badge badge-danger">{{ 'IMPAYER' }}</span></h5>
                           </td>
                        @endif
                        <td>{{ $facture->created_at }}</td>
                        <td>
                           <a href="{{ route('facture_show', $facture) }}" class="btn btn-outline-warning"><i
                                 class="fas fa-eye"></i>voir</a>
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
         $('#facture').DataTable();
      });

   </script>
@endsection
