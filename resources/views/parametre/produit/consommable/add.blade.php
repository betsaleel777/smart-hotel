@extends('layouts.default')
{{-- @section('breadcrumb')
{{Breadcrumbs::render('produit_add')}}
@endsection --}}
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ajouter Consommable</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('consommable_store')}}" enctype="multipart/form-data">
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
                    <label for="achat">Prix d'achat:</label>
                    <input name="achat" class="form-control" id="achat">
                </div>
                {!!$errors->first('achat','<p style="color:#a94442">:message</p>')!!}
                
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

                <div class="form-group">
                    <label>Catégorie:</label>
                    <div class="select2-purple">
                        <select name="sous_famille" class="form-control">
                            <option disabled selected>choix de la catégorie ...</option>
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
