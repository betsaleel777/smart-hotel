@extends('layouts.default')
@section('breadcrumb')
  {{Breadcrumbs::render('sous_famille_associer',$famille)}}
@endsection
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Associer Sous Famille à {{$famille->libelle}}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('sous_famille_plug')}}">
            <div class="card-body">
              @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Libelle:</label>
                    <input name="libelle" class="form-control" id="exampleInputEmail1">
                </div>
                {!!$errors->first('libelle','<p  style="color:#a94442">:message</p>')!!}
                <input hidden type="text" name="famille" value="{{$famille->id}}">
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </form>
    </div>
</div>
<div class="col-md-1"></div>
@endsection
