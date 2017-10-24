@extends('management.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verification request</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h2>Verification requests:</h2>
                        <div class = 'row'>
                            <div class = 'col-xs-3'>
                                <strong>Server</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>State</strong>
                            </div>
                            <div class = 'col-xs-3'>

                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Actions</strong>
                            </div>
                        </div>
                        @foreach($requests as $request)
                            <div class = 'row server-row'>
                                <div class = 'col-xs-3'>
                                    {{ $request->server->name }}
                                </div>
                                <div class = 'col-xs-3'>
                                    {{ $request->state }}
                                </div>
                                <div class = 'col-xs-3'>

                                </div>
                                <div class = 'col-xs-3'>
                                    <a href = "{{ route("verification.view",[ "id" => $request->id ]) }}">view</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
