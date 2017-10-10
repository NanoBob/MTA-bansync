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

                        <form action = "{{ route("manage.bans.store") }}" method = "POST">
                            {{ csrf_field() }}
                            <div class = "form-group">
                                <label>Name</label>
                                <input name = "name" class = "form-control" type = "text" />
                                <label>IP</label>
                                <input name = "ip" class = "form-control" type = "text" />
                                <label>Serial</label>
                                <input name = "serial" class = "form-control" type = "text" />
                                <label>Unban at</label>
                                <input name = "unbanDateTime" class = "form-control" type = "datetime-local" />
                                <label>Ban reason</label>
                                <select name = "ban_reason_id" class = "form-control">
                                    @foreach( App\BanReason::all() as $reason)
                                        <option value = "{{ $reason->id }}">
                                            {{ $reason->reason }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Ban details</label>
                                <textarea name = "detail" class = "form-control" ></textarea>
                            </div>
                            <input class = "btn btn-lg pull-right" type = "submit" value = "Save"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
