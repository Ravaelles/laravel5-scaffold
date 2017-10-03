@extends('rscaffold::layout.rscaffold')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection

@section('header')
<div class="page-header">
    <h1><i class="glyphicon glyphicon-plus"></i> Create {{ $modelName }} </h1>
</div>
@endsection

@section('content')
@include('rscaffold::partials.error')

<div class="row">
    <div class="col-md-12">
        <form action="{{ route('rscaffold.store') }}?model={{ $modelName }}" method="POST">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('rscaffold::partials.object', ['mode' => 'create'])

            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Create</button>
                <a class="btn btn-link pull-right" href="{{ route('rscaffold.index') }}?model={{ $modelName }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
<script>
$('.date-picker').datepicker({
});
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.form-control').get(0).focus();
    });
</script>
@endpush
