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

                        <h2>Enabled servers:</h2>
                        <div class = 'row'>
                            <div class = 'col-xs-3'>
                                <strong>Server</strong>
                            </div>
                            <div class = 'col-xs-6'>
                                <strong>Enabled reasons</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Actions</strong>
                            </div>
                        </div>
                        @foreach($settings as $setting)
                            <div class = 'row server-row'>
                                <div class = 'col-xs-3'>
                                    @if($setting->subject->verified)<i class="fa fa-check-circle-o" style="color:green" aria-hidden="true"></i>@endif{{ $setting->subject->name }}
                                </div>
                                <div class = 'col-xs-6'>
                                    @foreach($setting->detail as $detail)
                                        {{ $detail->reason->reason }}<br>
                                    @endforeach
                                </div>
                                <div class = 'col-xs-3'>
                                    <a href = "{{ route("manage.settings.edit",[ "id" => $setting->id ]) }}">edit</a>

                                    <form action = "{{ route("manage.settings.destroy",[ "id" => $setting->id ]) }}" method = "POST" id = "deleteSetting{{$setting->id}}">
                                        {{ csrf_field() }}
                                        {{ method_field("DELETE") }}
                                        <a onclick = "event.preventDefault(); document.getElementById('deleteSetting{{$setting->id}}').submit()" href = "">disable</a>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <h2>Other servers:</h2>
                        <div class = 'row'>
                            <div class = 'col-xs-3'>
                                <strong>Server</strong>
                            </div>
                            <div class = 'col-xs-6'>

                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Actions</strong>
                            </div>
                        </div>
                        @foreach($servers as $server)
                            <div class = 'row server-row'>
                                <div class = 'col-xs-3'>
                                    @if($server->verified)<i class="fa fa-check-circle-o" style="color:green" aria-hidden="true"></i>@endif {{ $server->name }}
                                </div>
                                <div class = 'col-xs-6'>

                                </div>
                                <div class = 'col-xs-3'>
                                    <form id = "createSettingsForm{{$server->id}}" method = "GET" action = "{{ route("manage.settings.create") }}">
                                        <input type = "hidden" name = "server-id" value = "{{ $server->id }}"/>
                                    </form>
                                    <a href="" onclick = "event.preventDefault(); document.getElementById('createSettingsForm{{$server->id}}').submit()">enable</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
