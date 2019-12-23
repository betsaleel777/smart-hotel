@extends('layouts.default')
@section('breadcrumb')
  {{-- {{ Breadcrumbs::render('batiments') }} --}}
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
          <div class="col-md-2">
           <a style="width:100%" href="{{route('sous_famille_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
          </div>
        </div>
        <p class="card-text">
          <table style="width:60%" id="famille" class="table table-bordered table-striped">
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
                <td>{{$key+1}}</td>
                <td>{{$sous_famille->libelle}}</td>
                <td>{{$sous_famille->familleLinked->libelle}}</td>
                <td>
                  <a href="{{route('sous_famille_edit',$sous_famille)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i> modifier</a>
                  {{-- <a href="{{route('batiment_delete',$sous_famille)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i> supprimer</a> --}}
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
      $('#famille').DataTable();
    });
  </script>
@endsection
