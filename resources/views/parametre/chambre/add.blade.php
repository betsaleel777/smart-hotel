@extends('layouts.default')
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ajouter Chambre</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('chambre_store')}}">
            <div class="card-body">
              @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Libelle:</label>
                    <input name="libelle" class="form-control" id="exampleInputEmail1">
                </div>
                {!!$errors->first('libelle','<p  style="color:#a94442">:message</p>')!!}


                  <div class="form-group">
                    <label>Batiment:</label>
                    <div class="select2-purple">
                      <select name="batiment" class="form-control" >
                        @foreach ($batiments as $id => $libelle)
                          <option value="{{$id}}">{{$libelle}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  {!!$errors->first('batiment','<p  style="color:#a94442">:message</p>')!!}
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>Type de Chambre</label>
                    <div class="select2-purple">
                      <select name="type" class="form-control">
                        @foreach ($types as $id => $libelle)
                          <option value="{{$id}}">{{$libelle}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  {!!$errors->first('type','<p  style="color:#a94442">:message</p>')!!}
                  <!-- /.form-group -->
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
