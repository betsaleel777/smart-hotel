@extends('layouts.default')
{{-- @section('breadcrumb')
{{ Breadcrumbs::render('type_add') }}
@endsection --}}
@section('content')
   <div class="col-md-1"></div>
   <div class="col-md-10">
      <!-- general form elements -->
      <div class="card card-primary">
         <div class="card-header">
            <h3 class="card-title">Ajouter Table</h3>
         </div>
         <!-- /.card-header -->
         <!-- form start -->
         <form role="form" method="post" action="{{ route('table_store') }}">
            <div class="card-body">
               @csrf
               <div class="form-group">
                  <label for="exampleInputEmail1">Numero:</label>
                  <input name="numero" class="form-control" id="exampleInputEmail1">
               </div>
               {!! $errors->first('numero', '<p style="color:#a94442">:message</p>') !!}

               <div class="form-group">
                  <label for="exampleInputEmail2">Nombre maximum de personnes:</label>
                  <input name="nombre_max" class="form-control" id="exampleInputEmail2">
               </div>
               {!! $errors->first('nombre_max', '<p style="color:#a94442">:message</p>') !!}

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
