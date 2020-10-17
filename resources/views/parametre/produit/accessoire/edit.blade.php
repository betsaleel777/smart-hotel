@extends('layouts.default')
{{-- @section('breadcrumb')
{{Breadcrumbs::render('produit_edit',$produit)}}
@endsection --}}
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Modifier Accessoire</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('accessoire_update',$produit)}}" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Libelle:</label>
                    <input value="{{$produit->libelle}}" name="libelle" class="form-control" id="exampleInputEmail1">
                </div>
                {!!$errors->first('libelle','<p style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                    <label for="prix">Prix:</label>
                    <input value="{{$produit->prix}}" name="prix" class="form-control" id="prix">
                </div>
                {!!$errors->first('prix','<p style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                    <label for="seuil">Seuil:</label>
                    <input value="{{$produit->seuil}}" name="seuil" class="form-control" id="seuil">
                </div>
                {!!$errors->first('seuil','<p style="color:#a94442">:message</p>')!!}

                @if (!empty($produit->image))
                <img width="400px" height="280px" src="{{asset('images').'/'.$produit->image}}" alt="{{$produit->image}}">
                @endif
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input value="{{$produit->image}}" type="file" name="image" id="image">
                </div>
                {!!$errors->first('image','<p style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                    <label>Catégorie:</label>
                    <div class="select2-purple">
                        <select name="sous_famille" class="form-control">
                            <option value="{{$produit->sous_familleLinked->id}}">{{$produit->sous_familleLinked->libelle}}</option>
                            @foreach ($sous_familles as $id => $libelle)
                            <option value="{{$id}}">{{$libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {!!$errors->first('sous_famille','<p style="color:#a94442">:message</p>')!!}
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
