@extends('layouts.default')
@section('breadcrumb')
  {{Breadcrumbs::render('batiment_show',$batiment)}}
@endsection
@section('content')
@php
$badge = ['inoccupée' => 'badge badge-success' ,
          'occupée' => 'badge badge-danger',
          'reservée' => 'badge badge-primary']
@endphp
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">LISTE</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h6 class="card-title">Chambres: {{$batiment->libelle}}</h6>
                </div>
            </div>
            <p class="card-text">
                <table style="width:80%" id="chambre" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Libelle</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batiment->chambres as $key => $chambre)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$chambre->libelle}}</td>
                            <td><h5><span class="{{$badge[$chambre->statut]}}">{{$chambre->statut}}</span></h5></td>
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
    $(function() {
        $('#chambre').DataTable();
    });
</script>
@endsection
