@extends('layouts.default')
@section('breadcrumb')
  {{Breadcrumbs::render('attributions_pass_add')}}
@endsection
@section('meta')
 <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Attribuer Chambre</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
            <div class="card-body">
                <attribution-add-select :batiments="{{$batiments}}" ></attribution-add-select>
                {!!$errors->first('batiment','<p  style="color:#a94442">:message</p>')!!}
            </div>
            <!-- /.card-body -->
            <attribution-add-table></attribution-add-table>
            {{-- <div class="card-footer">
                <button type="button" class="btn btn-primary">Envoyer</button>
            </div> --}}
    </div>
</div>
@endsection
@section('script')
 <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
@endsection
