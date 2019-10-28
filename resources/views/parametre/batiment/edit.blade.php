@extends('layouts.default')
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ajouter Batiment</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('batiment_update',$batiment)}}">
            <div class="card-body">
              @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Libelle:</label>
                    <input value="{{$batiment->libelle}}" name="libelle" class="form-control" id="exampleInputEmail1">
                </div>
                {!!$errors->first('libelle','<p  style="color:#a94442">:message</p>')!!}
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
