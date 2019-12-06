@extends('layouts.default')
@section('breadcrumb')
  {{ Breadcrumbs::render('pieces') }}
@endsection
@section('content')
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">TYPES DE PIECE</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-10">
            <h6 class="card-title">Liste des types de pièces</h6>
          </div>
          <div class="col-md-2">
           <a style="width:100%" href="{{route('type_piece_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
          </div>
        </div>
        <p class="card-text">
          <table style="width:80%" id="piece" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Libelle</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pieces as $key => $piece)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$piece->libelle}}</td>
                <td>
                  <a href="{{route('type_piece_edit',$piece)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i> modifier</a>
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
      $('#piece').DataTable();
    });
  </script>
@endsection
