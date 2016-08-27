@extends('laravel5-scaffold::layout.rscaffold')

@section('htmlheader_title')
Choose model to scaffold
@endsection

@section('content')
<div class="page-header clearfix">
    <h1>
        <i class="glyphicon glyphicon-align-justify"></i> Showing existing models
        <a class="btn btn-success pull-right" href="{{ url()->route('laravel5-scaffold.generate-model') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
    </h1>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Model</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($models as $file => $modelName)
                <tr>
                    <td>
                        <a class="btn btn-primary btn-app-blue"
                           href="{{ route('laravel5-scaffold.index') }}?model={{ $modelName }}"
                           >{{ $modelName }}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection