@extends('layout')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

@section('header')
<div class="page-header">
    <h1><i class="glyphicon glyphicon-edit"></i> Edit {{ $modelName }}</h1>
</div>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-md-12">
        <form action="{{ route('laravel5-scaffold.update', $object->getId()) }}?model={{ $modelName }}" method="POST">

            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-link pull-right" href="{{ route('laravel5-scaffold.index') }}?model={{ $modelName }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
<script>
$('.date-picker').datepicker({
});
</script>
@endsection
