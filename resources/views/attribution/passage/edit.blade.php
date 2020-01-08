@extends('layouts.default')
@section('breadcrumb')
{{-- {{Breadcrumbs::render('attributions_pass_add')}} --}}
@endsection
@section('content')
<div class="col-md-1"></div>
<div class="col-md-10">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ajouter Batiment</h3>
        </div>
        <form role="form" method="post" action="{{route('attributions_pass_update',$attribution)}}">
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="heure">Nombre d'Heures:</label>
                    <input value="{{$attribution->passageLinked->heure}}" name="heure" class="form-control" id="heure">
                </div>
                {!!$errors->first('heure','<p style="color:#a94442">:message</p>')!!}
                <label for="passage">Passage</label>
                @if ($attribution->passageLinked->passage)
                <input checked type="radio" name="type" value="passage">
                @else
                <input type="radio" name="type" value="passage">
                @endif
                <label for="sejour">Repos</label>
                @if ($attribution->passageLinked->repos)
                <input checked type="radio" name="type" value="repos">
                @else
                <input type="radio" name="type" value="repos">
                @endif
                {!!$errors->first('type','<p style="color:#a94442">:message</p>')!!}
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
