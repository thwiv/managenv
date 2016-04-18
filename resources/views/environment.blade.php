@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Environment: {{ $env->name }}</div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Variable</th>
                            <th>Value</th>
                            <th><button class="btn btn-default" id="export">
                                    <span class="glyphicon glyphicon-floppy-save"></span>
                                </button></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vars as $name=>$var)
                            @include('partials.var-row', ['var'=>$var, 'show_delete'=>$var->environment_id == $env->id])
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>
                                <input type="text" id="add-env-name" class="form-control" />
                            </td>
                            <td>
                                <input type="text" id="add-env-value" class="form-control" />
                            </td>
                            <td>
                                <button class="btn btn-primary" id="add-env" data-id="{{ $env->id }}">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <a class="btn btn-default" href="/home" title="Go Back">Go Back</a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>

    </div>
@endsection