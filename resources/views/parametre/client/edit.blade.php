@extends('layouts.default')
@section('breadcrumb')
{{-- {{Breadcrumbs::render('chambre_edit',$chambre)}} --}}
@endsection
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Modifier Client</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('client_update',$client)}}">
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input value="{{$client->nom}}" name="nom" class="form-control" id="nom">
                </div>
                {!!$errors->first('nom','<p style="color:#a94442">:message</p>')!!}
                <div class="form-group">
                    <label for="prenom">Prenom:</label>
                    <input value="{{$client->prenom}}" name="prenom" class="form-control" id="prenom">
                </div>
                {!!$errors->first('prenom','<p style="color:#a94442">:message</p>')!!}
                <div class="form-group">
                    <label for="contact">Contact:</label>
                    <input value="{{$client->contact}}" name="contact" class="form-control" id="contact">
                </div>
                {!!$errors->first('contact','<p style="color:#a94442">:message</p>')!!}
                <div class="form-group">
                    <label>Type de Pièce:</label>
                    <div class="select2-purple">
                        <select name="piece" class="form-control">
                            <option selected value="{{$client->pieceLinked->id}}">{{$client->pieceLinked->libelle}}</option>
                            @foreach ($pieces as $id => $libelle)
                            <option value="{{$id}}">{{$libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {!!$errors->first('piece','<p style="color:#a94442">:message</p>')!!}
                <div class="form-group">
                    <label for="numero">Numéro de Pièce:</label>
                    <input value="{{$client->numero_piece}}" name="numero_piece" class="form-control" id="numero">
                </div>
                {!!$errors->first('numero_piece','<p style="color:#a94442">:message</p>')!!}
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
