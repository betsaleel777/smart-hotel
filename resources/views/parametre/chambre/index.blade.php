@extends('layouts.default')
@section('content')
  @php
    $badge = ['inoccupée'  => 'badge badge-success' ,
              'occupée'  => 'badge badge-danger',
              'réservée'  => 'badge badge-primary']
  @endphp
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">CHAMBRES</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-10">
            <h6 class="card-title">Liste des Chambres</h6>
          </div>
          <div class="col-md-2">
           <a style="width:100%" href="{{route('chambre_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
          </div>
        </div>
        <div class="card-text">
          <table id="chambre" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Libelle</th>
              <th>Batiment</th>
              <th>Type</th>
              <th>Status</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($chambres as $key => $chambre)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$chambre->libelle}}</td>
                <td>{{$chambre->batimentLinked->libelle}}</td>
                <td>{{$chambre->typeLinked->libelle}}</td>
                <td><h3><span class="{{$badge[$chambre->statut]}}">{{$chambre->statut}}</span></h3></td>
                <td>
                  <a href="{{route('chambre_edit',$chambre)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i>modifier</a>
                  <a href="{{route('chambre_delete',$chambre)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i>supprimer</a>
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
  <script src="{{asset('admin/plugins/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
  <script>
    $(function () {
      $('#chambre').DataTable({
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
