@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ env("APP_NAME") }}</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h2>Bans matching that key:</h2>
                        <div class = 'row'>
                            <div class = 'col-xs-3'>
                                <strong>Player</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Banning server</strong>
                            </div>
                            <div class = 'col-xs-3'>

                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Actions</strong>
                            </div>
                        </div>
                        @foreach($bans as $ban)
                            <div class = 'row server-row'>
                                <div class = 'col-xs-3'>
                                    {{ $ban->name }}
                                </div>
                                <div class = 'col-xs-3'>
                                    {{ $ban->server->name }}
                                </div>
                                <div class = 'col-xs-3'>

                                </div>
                                <div class = 'col-xs-3'>
                                    @if( $ban->openAppeals()->first() )
                                        <a href = "{{ route("appeal.view",[ "id" => $ban->openAppeals()->first()->id ]) }}">view appeal</a>
                                    @else
                                        <a href = "{{ route("appeal.create",[ "appeal_code" => $appeal_code , "id" => $ban->id ]) }}">appeal</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
