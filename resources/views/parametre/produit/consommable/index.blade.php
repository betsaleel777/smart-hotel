@extends('layouts.default')
{{-- @section('breadcrumb')
  {{ Breadcrumbs::render('produits') }}
@endsection --}}
@section('content')
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Consommables</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-10">
            <h6 class="card-title">Liste des Consommables</h6>
          </div>
          <div class="col-md-2">
           <a style="width:100%" href="{{route('consommable_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
          </div>
        </div>
        <p class="card-text">
          <table id="produit" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Reférence</th>
              <th>Libelle</th>
              <th>Sous Famille</th>
              <th>Prix</th>
              <th>Seuil</th>
              <th>Image</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($consommables as $key => $consommable)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$consommable->reference}}</td>
                <td>{{$consommable->libelle}}</td>
                <td>{{$consommable->sous_familleLinked->libelle}}</td>
                <td>{{$consommable->prix}}</td>
                <td>{{$consommable->seuil}}</td>
                <td>
                  @if (empty($consommable->image))
                    {{'VIDE'}}
                  @else
                    <img src="{{asset('images').'/'.$consommable->image}}" width="60px" height="50px" alt="{{$consommable->image}}">
                  @endif
                </td>
                <td>
                  <a href="{{route('consommable_edit',$consommable)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i> modifier</a>
                  <a href="{{route('consommable_delete',$consommable)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i> supprimer</a>
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
  <script src="{{asset('admin/plugins/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
  <script>
    $(function () {
      $('#produit').DataTable();
    });
  </script>
@endsection
