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

                        <form action = "{{ route("manage.settings.store") }}" method = "POST">
                            {{ csrf_field() }}
                            <input name = "server-id" type = "hidden" value = {{ $settingServer->id }} />
                            <label>Server</label>
                            <input class = "form-control" type = "text" readonly value = "{{ $settingServer->name }}"/>
                            <div class = "form-group">
                                @foreach(App\BanReason::all() as $banReason)
                                    <label class = "form-control">
                                        <input type = "checkbox" name = "reason{{ $banReason->id }}"/>
                                        {{ $banReason->reason }}
                                    </label>
                                @endforeach
                            </div>
                            @if($settingServer->verified)
                                <div class = "form-group">
                                    <label class = "form-control"><input type = "checkbox" name = "applyToVerified">Apply to all verified servers</label>
                                </div>
                            @endif
                            <input class = "btn btn-lg btn-default pull-right" type = "submit" value = "Save"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
