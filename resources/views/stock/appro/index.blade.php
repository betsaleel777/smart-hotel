@extends('layouts.default')
{{-- @section('breadcrumb')
  {{ Breadcrumbs::render('batiments') }}
@endsection --}}
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
          <div class="col-md-6">
            <h6 class="card-title"></h6>
          </div>
          <div class="col-md-2">
           <a style="width:100%" href="{{route('appro_accessioire_index')}}" class="btn btn-outline-primary"><i class="fas fa-box"></i> Accéssoire</a>
          </div>
          <div class="col-md-2">
           <a style="width:100%" href="{{route('appro_consommable_index')}}" class="btn btn-outline-primary"><i class="fas fa-shopping-bag"></i> Consommable</a>
          </div>
          <div class="col-md-2">
           <a style="width:100%" href="{{route('appro_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
          </div>
        </div>
        <p class="card-text">
          <table style="width:80%" id="appro" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Produit</th>
              <th>Quantite</th>
              <th>Seuil</th>
              {{-- <th>Session</th> --}}
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($appros as $key => $appro)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$appro->produitLinked->libelle}}</td>
                <td>{{$appro->quantite}}</td>
                <td>{{$appro->produitLinked->seuil}}</td>
                {{-- <td>{{$appro->userLinked->name}}</td> --}}
                <td>
                  <modal-button-appro :id="'{{$appro->id}}'" :valeur="{{$appro->quantite}}" :produit="'{{$appro->produitLinked->libelle}}'"></modal-button-appro>
                  {{-- <a href="{{route('appro_edit',$appro)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i>modifier</a>
                  <a href="{{route('appro_delete',$appro)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i>supprimer</a> --}}
                  {{-- <a href="{{route('appro_show',$appro)}}" class="btn btn-outline-warning"><i class="fas fa-eye"></i>voir</a> --}}
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
  <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/plugins/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
  <script>
    $(function () {
      $('#appro').DataTable();
    });
  </script>
@endsection
