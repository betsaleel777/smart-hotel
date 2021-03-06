@extends('layouts.default')
@section('breadcrumb')
  {{Breadcrumbs::render('sejours')}}
@endsection
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="card card-primary">
    <div class="card-body p-0">
        <!-- THE CALENDAR -->
        <calendrier></calendrier>
    </div>
    <!-- /.card-body -->
</div>
@endsection
@section('script')
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
@endsection
