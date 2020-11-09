@extends('layouts.default')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Inventaire</h3>
            </div>
            <div class="container">
                <form-multicritere :userdep="{{ Auth::user()->departementLinked->id }}"></form-multicritere>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@endsection
