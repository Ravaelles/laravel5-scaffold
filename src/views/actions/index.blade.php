@extends('rscaffold::layout.rscaffold')

@section('htmlheader_title')
Scaffold - {{ $modelName }}
@endsection

@section('content')
<div class="page-header clearfix">
    <h1>
        <i class="glyphicon glyphicon-align-justify"></i> {{ $modelName }}s
        <a class="btn btn-success pull-right" href="{{ url()->route('rscaffold.create') }}?model={{ $modelName }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
    </h1>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-index">
            <thead>
                <tr>
                    @include('rscaffold::partials.list-fields')

                    <th class="text-right">ACTIONS</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($objects as $object)
                <tr>
                    @include('rscaffold::partials.list-object', ['mode' => 'index', 'disabled' => true])

                    <!-- ACTIONS -->
                    <td class="text-right">

                        <a class="btn btn-xs btn-primary" 
                           href="{{ url()->route('rscaffold.show', ['object' => $object->getId()]) }}?model={{ $modelName }}">
                            <i class="glyphicon glyphicon-eye-open"></i> View
                        </a>

                        <a class="btn btn-xs btn-warning" 
                           href="{{ url()->route('rscaffold.edit', ['object' => $object->getId()]) }}?model={{ $modelName }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>

                        <form action="{{ url()->route('rscaffold.destroy', ['object' => $object->getId()]) }}?model={{ $modelName }}" 
                              method="POST" style="display: inline;" onsubmit="if (confirm('Delete? Are you sure?')) {
                                    return true
                                } else {
                                    return false
                                };">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $objects->links() }}
@endsection