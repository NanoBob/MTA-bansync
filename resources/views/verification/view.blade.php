@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verification request</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h1>{{ $request->server->name }}'s request</h1>
                        <p>
                            {{ $request->content }}
                        </p>
                        @if( Auth::user()->verified && Auth::user() != $request->server )
                            <form action = "{{ route("verification.decline",[ "id" => $request->id ]) }}" method = "POST">
                                {{csrf_field()}}
                                <input class = "btn btn-default pull-right" type = "submit" name = "decline" value = "Decline ({{ $request->falseVoteCount() }})">
                            </form>
                            <div class = "pull-right hSpacing"></div>
                            <form action = "{{ route("verification.approve",[ "id" => $request->id ]) }}" method = "POST">
                                {{csrf_field()}}
                                <input class = "btn btn-default pull-right" type = "submit" name = "approve" value = "Approve ({{ $request->trueVoteCount() }})">
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
