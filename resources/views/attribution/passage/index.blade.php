@extends('layouts.default')
@section('content')
@php
$badge = ['inoccupée' => 'badge badge-success' ,
          'occupée' => 'badge badge-danger',
          'réservée' => 'badge badge-primary']
@endphp
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">ATTRIBUTIONS</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h6 class="card-title">Liste chambres déjà attribuées</h6>
                </div>
                <div class="col-md-2">
                    <a style="width:100%" href="{{route('attributions_pass_add')}}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> ajouter</a>
                </div>
            </div>
            <p class="card-text">
                <table id="attr" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Chambre</th>
                            <th>Type</th>
                            <th>Coût(Fcfa)</th>
                            <th>Heures(H)</th>
                            <th>Progression</th>
                            <th>Statut</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attributions as $key => $attribution)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$attribution->passageLinked->chambreLinked->libelle}}</td>
                            <td>{{$attribution->passageLinked->chambreLinked->typeLinked->libelle}}</td>
                            <td>{{$attribution->passageLinked->chambreLinked->typeLinked->cout_passage}}</td>
                            <td>{{$attribution->passageLinked->heure}}</td>
                            <td>
                                <div class="progress progress-sm active">
                                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                     style="width: {{number_format(($attribution->created_at->diffInHours(Carbon\Carbon::now())/$attribution->passageLinked->heure)*100,2)}}%">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5><span class="{{$badge[$attribution->passageLinked->chambreLinked->statut]}}">{{$attribution->passageLinked->chambreLinked->statut}}</span></h5>
                            </td>
                            <td>
                                <a href="{{route('attributions_pass_edit',$attribution)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i>modifier</a>
                                <a href="{{route('attributions_pass_delete',$attribution)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i>supprimer</a>
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
        $('#attr').DataTable();
    });
</script>
@endsection
