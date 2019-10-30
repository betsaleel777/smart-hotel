@extends('layouts.default')
@section('content')
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">BATIMENTS</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-10">
            <h6 class="card-title">Liste des batiments</h6>
          </div>
          <div class="col-md-2">
           <a style="width:100%" href="{{route('batiment_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
          </div>
        </div>
        <p class="card-text">
          <table style="width:75%" id="batiment" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Libelle</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($batiments as $key => $batiment)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$batiment->libelle}}</td>
                <td>
                  <a href="{{route('batiment_edit',$batiment)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i>modifier</a>
                  <a href="{{route('batiment_delete',$batiment)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i>supprimer</a>
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
      $('#batiment').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
      });
    });
  </script>
@endsection
