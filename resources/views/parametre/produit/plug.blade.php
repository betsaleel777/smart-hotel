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
            <h3 class="card-title">Associer Produit à {{$sous_famille->libelle}}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('produit_plug')}}" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Libelle:</label>
                    <input name="libelle" class="form-control" id="exampleInputEmail1">
                </div>
                {!!$errors->first('libelle','<p style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                    <label for="prix">Prix:</label>
                    <input name="prix" class="form-control" id="prix">
                </div>
                {!!$errors->first('prix','<p style="color:#a94442">:message</p>')!!}
                <div class="form-group">
                    <label for="seuil">Seuil:</label>
                    <input name="seuil" class="form-control" id="seuil">
                </div>
                {!!$errors->first('seuil','<p style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" name="image" id="image">
                </div>
                {!!$errors->first('image','<p style="color:#a94442">:message</p>')!!}
                <input hidden type="text" name="sous_famille" value="{{$sous_famille->id}}">
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
