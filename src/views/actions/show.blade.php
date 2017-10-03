@extends('rscaffold::layout.rscaffold')

@section('header')
<div class="page-header">
    <h1>Showing {{ $modelName }}</h1>
    <form action="{{ route('rscaffold.destroy', $object->getId()) }}?model={{ $modelName }}" 
          method="POST" style="display: inline;" onsubmit="if (confirm('Delete? Are you sure?')) {
                return true
            } else {
                return false
            }
            ;">

        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="object-actions btn-group pull-right" role="group" aria-label="...">
            <a class="btn btn-warning btn-group" role="group" href="{{ route('rscaffold.edit', $object->getId()) }}?model={{ $modelName }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
            <button type="submit" class="btn btn-danger">Delete <i class="glyphicon glyphicon-trash"></i></button>
        </div>

    </form>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="#">

            @include('rscaffold::partials.object', ['mode' => 'show', 'disabled' => true])

        </form>

        <a class="btn btn-link" href="{{ route('rscaffold.index') }}?model={{ $modelName }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>

    </div>
</div>
@endsection