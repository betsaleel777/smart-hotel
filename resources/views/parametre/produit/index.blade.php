@extends('layouts.default')
@section('breadcrumb')
  {{-- {{ Breadcrumbs::render('batiments') }} --}}
@endsection
@section('content')
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Familles</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-10">
            <h6 class="card-title">Liste des produits</h6>
          </div>
          <div class="col-md-2">
           <a style="width:100%" href="{{route('produit_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
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
            @foreach ($produits as $key => $produit)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$produit->reference}}</td>
                <td>{{$produit->libelle}}</td>
                <td>{{$produit->sous_familleLinked->libelle}}</td>
                <td>{{$produit->prix}}</td>
                <td>{{$produit->seuil}}</td>
                <td>
                  @if (empty($produit->image))
                    {{'VIDE'}}
                  @else
                    <img src="{{asset('images').'/'.$produit->image}}" width="60px" height="50px" alt="{{$produit->image}}">
                  @endif
                </td>
                <td>
                  <a href="{{route('produit_edit',$produit)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i> modifier</a>
                  <a href="{{route('produit_delete',$produit)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i> supprimer</a>
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
