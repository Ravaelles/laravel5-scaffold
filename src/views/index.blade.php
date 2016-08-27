@extends('laravel5-scaffold::layout.rscaffold')

@section('htmlheader_title')
Scaffold - SkillsTemplates
@endsection

@section('main-content')
<div class="page-header clearfix">
    <h1>
        <i class="glyphicon glyphicon-align-justify"></i> SkillsTemplates
        <a class="btn btn-success pull-right" href="/skills_templates/create"><i class="glyphicon glyphicon-plus"></i> Create</a>
    </h1>
</div>

@foreach ($objects as $object)
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>ID</th>

                    <th class="text-right">OPTIONS</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>57c17ee3bffebc20048b4567</td>

                    <td class="text-right">

                        <a class="btn btn-xs btn-primary" 
                           href="{{ url()->route('scaffold.view', ['object' => $object->getId())]) }}">
                            <i class="glyphicon glyphicon-eye-open"></i> View
                        </a>

                        <a class="btn btn-xs btn-warning" 
                           href="{{ url()->route('scaffold.edit', ['object' => $object->getId())]) }}">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>

                        <form action="{{ url()->route('scaffold.delete', ['object' => $object->getId())]) }}" method="POST" 
                              style="display: inline;" onsubmit="if (confirm('Delete? Are you sure?')) {
                                    return true
                                } else {
                                    return false
                                }
                                ;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>


    </div>
</div>
@endforeach

{{ $objects->links() }}
@endsection