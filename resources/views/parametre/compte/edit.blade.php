@extends('layouts.default')
{{-- @section('breadcrumb')
{{ Breadcrumbs::render('batiment_add') }}
@endsection --}}
@section('meta')
   <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
   <div class="col-md-1"></div>
   <div class="col-md-10">
      <!-- general form elements -->
      <div class="card card-primary">
         <div class="card-header">
            <h3 class="card-title">Ajouter Compte</h3>
         </div>
         <!-- /.card-header -->
         <!-- form start -->
         <form role="form" method="post" action="{{ route('compte_update', $compte) }}">
            <div class="card-body">
               @csrf
               <div class="form-group">
                  <label for="exampleInputEmail1">Nom:</label>
                  <input value="{{ $compte->name }}" name="name" class="form-control" id="exampleInputEmail1">
               </div>
               {!! $errors->first('name', '<p style="color:#a94442">:message</p>') !!}
               <div class="form-group">
                  <label for="exampleInputEmail">Email:</label>
                  <input value="{{ $compte->email }}" type="email" name="email" class="form-control"
                     id="exampleInputEmail">
               </div>
               {!! $errors->first('email', '<p style="color:#a94442">:message</p>') !!}
               <div class="form-group">
                  <label for="exampleIn">Ancien mot de passe:</label>
                  <input type="password" name="oldPassword" class="form-control" id="exampleIn">
               </div>
               {!! $errors->first('oldPassword', '<p style="color:#a94442">:message</p>') !!}
               <div class="form-group">
                  <label for="exampleInputEmail0">Nouveau mot de passe:</label>
                  <input type="password" name="password" class="form-control" id="exampleInputEmail0">
               </div>
               {!! $errors->first('password', '<p style="color:#a94442">:message</p>') !!}
               <div class="form-group">
                  <label for="example">Confirmer mot de passe:</label>
                  <input type="password" name="password_confirmation" class="form-control" id="example">
               </div>
               {!! $errors->first('password_confirmation', '<p style="color:#a94442">:message</p>') !!}
               <div class="form-group">
                  <label for="exampleInput">Département:</label>
                  <div class="row">
                     <div class="col-md-10">
                        <select-departement :list="{{ $departements }}" :selected="{{ $compte->departement }}">
                        </select-departement>
                     </div>
                     <div class="col-md-2">
                        <modal-departement></modal-departement>
                     </div>
                  </div>
               </div>
               {!! $errors->first('departement', '<p style="color:#a94442">:message</p>') !!}
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
@section('script')
   <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@endsection
