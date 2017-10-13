@extends('management/layouts.app')

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

                        <form method = "POST" action = "{{ route("manage.appeals.update", [ "id" => $appeal->id ]) }}">
                            {{ csrf_field() }}
                            {{ method_field("PATCH") }}
                            <div class = "form-group">
                                <label>Banning server</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->server->name }}" />
                                <label>Banning admin</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->ban->banner->name }}" />
                                <label>Ban reason</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->ban->reason->reason }}" />
                                <label>Ban lifts at</label>
                                <input class = "form-control" type = "text" readonly value = "{{ $appeal->ban->banned_until }}" />
                                <label>Ban detail</label>
                                <textarea class = "form-control" readonly>{{ $appeal->ban->details }}</textarea>
                            </div>
                            <div class = "form-group">
                                <label>Why should you be unbanned?</label>
                                <textarea class = "form-control" name = "content" readonly>{{ $appeal->content }}</textarea>
                            </div>
                            <div class = "form-group">
                                <select name = "new_state" class = "form-control">
                                    @foreach( App\AppealState::all() as $state)
                                        <option @if($state->id == $appeal->state_id) selected @endif value = {{ $state->id }}>{{ $state->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type = "submit" value = "Change appeal status" class = "btn btn-lg btn-default pull-right"/>
                        </form>
                    </div>
                </div>
                @foreach($appeal->replies as $reply)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @if($reply->author->type == "server")
                                {{ $reply->author->name }}
                            @else
                                {{$reply->author->server->name}} | {{ $reply->author->name }}
                            @endif
                        </div>
                        <div class="panel-body">
                            <div class = "form-group">
                                {{ $reply->content }}
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="panel panel-default">
                    <form method = "POST" action = "{{ route("appeal.reply", [ "id" => $appeal->id ]) }}">
                        {{ csrf_field() }}
                        <div class="panel-heading">Ban Appeal</div>
                        <div class="panel-body">
                            <div class = "form-group">
                                <textarea style = "resize:vertical;" class = "form-control" name = "content"></textarea>
                            </div>
                            <input class = "btn btn-default btn-lg pull-right" type = "submit" value = "Reply"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
