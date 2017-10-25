@extends('management/layouts.app')

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
                        <a href = "{{ route("manage.bans.create") }}" class = "btn btn-default">Add new ban</a>

                        <h2>Bans:</h2>
                        <div class = 'row'>
                            <div class = 'col-xs-3'>
                                <strong>Player</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>IP</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Serial</strong>
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
                                    {{ $ban->ip }}
                                </div>
                                <div class = 'col-xs-3 serial'>
                                    {{ $ban->serial }}
                                </div>
                                <div class = 'col-xs-3'>
                                    <a href = "{{ route("manage.bans.edit",[ "id" => $ban->id ]) }}">edit</a>
                                    <form action = "{{ route("manage.bans.destroy",[ "id" => $ban->id ]) }}" method = "POST" id = "deleteBan{{$ban->id}}">
                                        {{ csrf_field() }}
                                        {{ method_field("DELETE") }}
                                        <a onclick = "event.preventDefault(); document.getElementById('deleteBan{{$ban->id}}').submit()" href = "">Lift</a>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        {!! $bans->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
