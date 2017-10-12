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

                        <form method = "POST" action = "{{ route("appeal.update", [ "id" => $appeal->id ]) }}">
                            {{ csrf_field() }}
                            <div class = "form-group">
                                <label>Banning server</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->ban->server->name }}" />
                                <label>Banning admin</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->ban->banner->name }}" />
                                <label>Ban reason</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->ban->reason->reason }}" />
                                <label>Unban at</label>
                                <input name = "unbanDateTime" readonly class = "form-control" type = "datetime-local" value = "{{ date_format(new DateTime($appeal->ban->banned_until), 'Y-m-d\TH:i') }}" />
                                <label>Ban detail</label>
                                <textarea style = "resize:vertical;" class = "form-control" readonly>{{ $appeal->ban->details }}</textarea>
                            </div>
                            <div class = "form-group">
                                <label>Why should you be unbanned?</label>
                                <textarea style = "resize:vertical;" class = "form-control" name = "content">{{ $appeal->content }}</textarea>
                            </div>
                            @if($appeal->banned == Auth::user() && $appeal->state->state == "Open" ) )
                                <input type = "submit" value = "Edit appeal" class = "btn btn-lg btn-default pull-right"/>
                            @endif
                        </form>
                    </div>
                </div>
                @foreach($appeal->replies as $reply)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $reply->author->name }}</div>
                        <div class="panel-body">
                            <div class = "form-group">
                                {{ $reply->content }}
                            </div>
                        </div>
                    </div>
                @endforeach
                @if( $appeal->state->state == "Open" )
                    <div class="panel panel-default">
                        <form method = "POST" action = "{{ route("appeal.reply", [ "id" => $appeal->id ]) }}">
                            {{ csrf_field() }}
                            <div class="panel-heading">Reply to Appeal</div>
                            <div class="panel-body">
                                <div class = "form-group">
                                    <textarea style = "resize:vertical;" class = "form-control" name = "content"></textarea>
                                </div>
                                <input class = "btn btn-default btn-lg pull-right" type = "submit" value = "Reply"/>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
