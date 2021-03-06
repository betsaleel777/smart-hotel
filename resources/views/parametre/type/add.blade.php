@extends('layouts.default')
@section('breadcrumb')
  {{Breadcrumbs::render('type_add')}}
@endsection
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ajouter Type de Chambre</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('type_store')}}">
            <div class="card-body">
              @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Libelle:</label>
                    <input name="libelle" class="form-control" id="exampleInputEmail1">
                </div>
                {!!$errors->first('libelle','<p  style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                    <label for="exampleInputEmail2">Coût de repos en (Fcfa/h):</label>
                    <input name="cout_repos" class="form-control" id="exampleInputEmail2">
                </div>
                {!!$errors->first('cout_repos','<p  style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                    <label for="exampleInputEmail3">Coût de Passage en (Fcfa/h):</label>
                    <input name="cout_passage" class="form-control" id="exampleInputEmail3">
                </div>
                {!!$errors->first('cout_passage','<p  style="color:#a94442">:message</p>')!!}

                <div class="form-group">
                    <label for="exampleInputEmail4">Coût de Réservation (Fcfa/j):</label>
                    <input name="cout_reservation" class="form-control" id="exampleInputEmail4">
                </div>
                {!!$errors->first('cout_reservation','<p  style="color:#a94442">:message</p>')!!}
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
