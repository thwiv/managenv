@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Environments</div>

                <div class="panel-body">
                    <div class="col-md-8 col-md-push-2">
                        <ul class="tree">
                            @include('partials.env-branch', ['environments'=> $environments])
                            <li>
                                <div class="input-group">
                                    <input type="text" placeholder="Add an Environment" class="form-control env-name" />
                                    <span class="input-group-btn">
                                        <button data-parent="0" class="btn btn-primary add-env">Add</button>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
