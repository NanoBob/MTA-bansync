@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ban Appeal</div>

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

                        <form method = "POST" action = "{{ route("appeal.store", [ "id" => $ban->id ]) }}">
                            {{ csrf_field() }}
                            <input type = "hidden" name = "appeal_code" value = "{{ $appeal_code }}"/>
                            <div class = "form-group">
                                <label>Banning server</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $ban->server->name }}" />
                                <label>Banning admin</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $ban->banner->name }}" />
                                <label>Ban reason</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $ban->reason->reason }}" />
                                <label>Unban at</label>
                                <input name = "unbanDateTime" readonly class = "form-control" type = "datetime-local" value = "{{ date_format(new DateTime($ban->banned_until), 'Y-m-d\TH:i') }}" />
                                <label>Ban detail</label>
                                <textarea class = "form-control" readonly>{{ $ban->details }}</textarea>
                            </div>
                            <div class = "form-group">
                                <label>Why should you be unbanned?</label>
                                <textarea class = "form-control" name = "content">

                                </textarea>
                            </div>
                            <input type = "submit" value = "Appeal ban" class = "btn btn-lg btn-default pull-right"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
