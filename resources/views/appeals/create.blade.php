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

                        <form method = "POST" action = "{{ route("") }}">

                            <div class = "form-group">
                                <label>Banning server</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->server->name }}" />
                                <label>Banning admin</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->ban->banner->name }}" />
                                <label>Ban reason</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->ban->reason->reason }}" />
                                <label>Ban detail</label>
                                <textarea class = "form-control" readonly>{{ $appeal->ban->details }}</textarea>
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
