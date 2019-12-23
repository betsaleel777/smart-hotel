@extends('layouts.default')
@section('breadcrumb')
{{-- {{Breadcrumbs::render('chambre_add')}} --}}
@endsection
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ajouter Une Sous Famille</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('sous_famille_update',$sous_famille)}}">
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Libelle:</label>
                    <input value="{{$sous_famille->libelle}}" name="libelle" class="form-control" id="exampleInputEmail1">
                </div>
                {!!$errors->first('libelle','<p style="color:#a94442">:message</p>')!!}


                <div class="form-group">
                    <label>Categorie:</label>
                    <div class="select2-purple">
                        <select name="famille" class="form-control">
                            <option selected value="{{$sous_famille->familleLinked->id}}">{{$sous_famille->familleLinked->libelle}}</option>
                            @foreach ($familles as $id => $libelle)
                            <option value="{{$id}}">{{$libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {!!$errors->first('famille','<p style="color:#a94442">:message</p>')!!}
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
