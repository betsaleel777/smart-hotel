@extends('layouts.default')
@section('breadcrumb')
{{Breadcrumbs::render('restauration_passage_add',$attribution)}}
@endsection
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Restauration</h3>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-6">
               <input-product></input-product>
            </div>
            <div class="col-md-6">
               <synthese-product :passage="true" :attribution="'{{$attribution->id}}'"></synthese-product>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/app.js')}}"></script>
@endsection
