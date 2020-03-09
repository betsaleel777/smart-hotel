@extends('layouts.default')
{{-- @section('breadcrumb')
  {{ Breadcrumbs::render('batiments') }}
@endsection --}}
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
          <div class="col-md-2">
           <a style="width:100%" href="{{route('facture_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
          </div>
        </div>
        <p class="card-text">
          <table style="width:80%" id="facture" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Code</th>
              <th>Client</th>
              <th>Service</th>
              <th>Date</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($factures as $key => $facture)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$facture->code}}</td>
                <td>{{$facture->client}}</td>
                <td>{{$facture->service}}</td>
                <td>{{$facture->date}}</td>
                <td>
                  <a href="{{route('facture_edit',$facture)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i> modifier</a>
                  <a href="{{route('facture_delete',$facture)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i> supprimer</a>
                  <a href="{{route('facture_show',$facture)}}" class="btn btn-outline-warning"><i class="fas fa-eye"></i>voir</a>
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
      $('#facture').DataTable();
    });
  </script>
@endsection
