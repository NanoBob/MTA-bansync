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

                        <form action = "{{ route("settings.update", [ "id" => $setting->id ]) }}" method = "POST">
                            {{ csrf_field() }}
                            <input name = "server-id" type = "hidden" value = {{ $settingServer->id }} />
                            <label>Server</label>
                            {{ method_field("PATCH") }}
                            <input class = "form-control" type = "text" readonly value = "{{ $settingServer->name }}"/>
                            <div class = "form-group">
                                @foreach(App\BanReason::all() as $banReason)

                                    <label class = "form-control">
                                        <input type = "checkbox" name = "reason{{ $banReason->id }}"
                                        @foreach($setting->detail as $detail)
                                            @if($detail->reason == $banReason)
                                                checked
                                            @endif
                                        @endforeach
                                        />
                                        {{ $banReason->reason }}
                                    </label>
                                @endforeach

                            </div>
                            <input class = "btn btn-lg pull-right" type = "submit" value = "Save"/>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
