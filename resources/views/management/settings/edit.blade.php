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

                        <form action = "{{ route("manage.settings.update", [ "id" => $setting->id ]) }}" method = "POST">
                            <div class = "form-group">
                                {{ csrf_field() }}
                                <input name = "server-id" type = "hidden" value = {{ $setting->subject->id }} />
                                <label>Server</label>
                                {{ method_field("PATCH") }}
                                <input class = "form-control" type = "text" readonly value = "{{ $setting->subject->name }}"/>
                            </div>
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
                            <div class = "form-group">
                                @if($setting->subject->verified)
                                    <label class = "form-control"><input type = "checkbox" name = "applyToVerified">Apply to all verified servers</label>
                                @endif
                            </div>
                            <input class = "btn btn-lg btn-default pull-right" type = "submit" value = "Save"/>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
