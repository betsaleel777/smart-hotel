@extends('layouts.default')
@section('breadcrumb')
  {{Breadcrumbs::render('attributions')}}
@endsection
@section('meta')
 <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@php
$badge = ['inoccupée' => 'badge badge-success' ,
          'occupée' => 'badge badge-danger',
          'reservée' => 'badge badge-primary'
         ]
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
                <table id="passage" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width:5%">chambre</th>
                            <th>Type</th>
                            <th>Coût(Fcfa)</th>
                            <th style="width:5%">Heures(H)</th>
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
                              @if (Carbon::now()->greaterThan($attribution->created_at->add($attribution->passageLinked->heure,'hour')) and $attribution->passageLinked->chambreLinked->statut === 'occupée' )
                                <span style="color:red" >{{'doit libérer'}}</span>
                              @endif
                              <progression :end="'{{$attribution->created_at->add($attribution->passageLinked->heure,'hour')}}'" :chambre="'{{$attribution->passageLinked->chambreLinked->libelle}}'"></progression>
                            </td>
                            <td>
                                <h5><span class="{{$badge[$attribution->passageLinked->chambreLinked->statut]}}">{{$attribution->passageLinked->chambreLinked->statut}}</span></h5>
                            </td>
                            <td>
                                @if (!Carbon::now()->greaterThan($attribution->created_at->add($attribution->passageLinked->heure,'hour')) and $attribution->passageLinked->chambreLinked->statut === 'occupée' )
                                @if ($attribution->etat !== 'facturer')
                                  <a href="{{route('attributions_pass_edit',$attribution)}}" class="btn btn-outline-success"><i class="fas fa-edit"></i></a>
                                  <a href="{{route('resto_new',$attribution)}}" class="btn btn-outline-dark"><i class="fas fa-drumstick-bite"></i></a>
                                @endif
                                <a href="{{route('destockage_passage_add',$attribution)}}" class="btn btn-outline-dark"><i class="fas fa-box"></i></a>
                                @endif
                                <a href="{{route('attributions_pass_liberer',$attribution)}}" class="btn btn-outline-danger"><i class="fas fa-trash"></i>libérer</a>
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
        $('#passage').DataTable();
    });
</script>
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
@endsection
