@extends('management/layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Latest open appeals</div>

                    <div class="panel-body">
                        <div class = 'row'>
                            <div class = 'col-xs-3'>
                                <strong>Player</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Last update</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>State</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Actions</strong>
                            </div>
                        </div>
                        @foreach($server->appeals()->where("state_id","1")->limit(5)->get() as $appeal)
                            <div class = 'row server-row'>
                                <div class = 'col-xs-3'>
                                    {{ $appeal->ban->name }}
                                </div>
                                <div class = 'col-xs-3'>
                                    {{ $appeal->updated_at }}
                                </div>
                                <div class = 'col-xs-3'>
                                    {{ $appeal->state->state }}
                                </div>
                                <div class = 'col-xs-3'>
                                    <a href = "{{ route("manage.appeals.show",[ "id" => $appeal->id ]) }}">view</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Latest bans</div>

                    <div class="panel-body">
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
                        @foreach($server->bans()->limit(5)->get() as $ban)
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
                    </div>
                </div>
                @if( $server->verified)
                    <div class="panel panel-default">
                        <div class="panel-heading">New verification requests</div>

                        <div class="panel-body">
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
                            @foreach(\App\VerificationRequest::orderBy("created_at","DESC")->get()->where("state","open")->take(5) as $request)
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
                @endif
            </div>
        </div>
    </div>
@endsection
