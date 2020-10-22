@extends('layouts.default')
{{-- @section('breadcrumb')
  {{ Breadcrumbs::render('clients') }}
@endsection --}}
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">COMPTES D'UTILISATEURS</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h6 class="card-title">Liste des comptes des utilisateurs</h6>
                </div>
                <div class="col-md-2">
                    <a style="width:100%" href="{{route('compte_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
                </div>
            </div>
            <p class="card-text">
            <table id="compte" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Couriel</th>
                        <th>Département</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comptes as $key => $compte)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$compte->name}}</td>
                        <td>{{$compte->email}}</td>
                        <td>
                            @empty ($compte->departement)
                            {{'AUCUN'}}
                            @else
                            {{$compte->departementLinked->nom}}
                            @endempty
                        </td>
                        <td>
                            <a href="{{route('compte_edit',$compte)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i> modifier</a>
                            <a href="{{route('compte_delete',$compte)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i> supprimer</a>
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
    $(function() {
        $('#compte').DataTable();
    });
</script>
@endsection
