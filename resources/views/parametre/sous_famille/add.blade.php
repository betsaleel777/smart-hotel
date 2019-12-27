@extends('layouts.default')
@section('breadcrumb')
  {{Breadcrumbs::render('sous_famille_add')}}
@endsection
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ajouter Sous Famille</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('sous_famille_store')}}">
            <div class="card-body">
              @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Libelle:</label>
                    <input name="libelle" class="form-control" id="exampleInputEmail1">
                </div>
                {!!$errors->first('libelle','<p  style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                  <label>Catégorie:</label>
                  <div class="select2-purple">
                    <select name="famille" class="form-control" >
                      <option disabled selected>choix de la catégorie ...</option>
                      @foreach ($familles as $id => $libelle)
                        <option value="{{$id}}">{{$libelle}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                {!!$errors->first('sous_famille','<p  style="color:#a94442">:message</p>')!!}
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
