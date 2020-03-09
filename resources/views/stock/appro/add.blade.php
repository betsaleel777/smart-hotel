@extends('layouts.default')
{{-- @section('breadcrumb')
  {{Breadcrumbs::render('sejours')}}
@endsection --}}
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
  <div class="col-md-12">
      <div class="card card-primary">
          <div class="card-header">
              <h3 class="card-title">Approvisionnements de produits</h3>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                 <input-choice :usingby="'appro'"></input-choice>
              </div>
              <div class="col-md-6">
                 <synthese-choice :usingby="'appro'"></synthese-choice>
              </div>
            </div>
          </div>
      </div>
  </div>
@endsection
@section('script')
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
@endsection
