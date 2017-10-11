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
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action = "{{ route("manage.bans.update", [ "id" => $ban->id ]) }}" method = "POST">
                            {{ csrf_field() }}
                            {{ method_field("PATCH") }}
                            <div class = "form-group">
                                <label>Name</label>
                                <input name = "name" class = "form-control" type = "text" value = "{{ $ban->name }}" />
                                <label>IP</label>
                                <input name = "ip" class = "form-control" type = "text" value = "{{ $ban->ip }}" />
                                <label>Serial</label>
                                <input name = "serial" class = "form-control" type = "text" value = "{{ $ban->serial }}" />
                                <label>Unban at</label>
                                <input name = "unbanDateTime" class = "form-control" type = "datetime-local" value = "{{ date_format(new DateTime($ban->banned_until), 'Y-m-d\TH:i') }}" />
                                <label>Ban reason</label>
                                <select name = "ban_reason_id" class = "form-control">
                                    @foreach( App\BanReason::all() as $reason)
                                        <option @if($reason->id == $ban->ban_reason_id) selected @endif value = "{{ $reason->id }}">
                                            {{ $reason->reason }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Ban details</label>
                                <textarea name = "detail" class = "form-control" >{{ $ban->details }}</textarea>
                            </div>
                            <input class = "btn btn-lg btn-default pull-right" type = "submit" value = "Save"/>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
