@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Contributors</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">

                            </div>
                        @endif
                        <h2>Contributors</h2>
                        <p>
                            The list below contains all servers that contribute to the bansync database.
                        </p>
                        <h3>Verified servers</h3>
                        <ul>
                            @foreach($verified as $server)
                                <li><span style = "background-color:rgb(0,200,0); border-radius:50%; padding:3px;" class = "glyphicon-check"></span> {{$server->name}}</li>
                            @endforeach
                        </ul>
                        <h3>Other servers</h3>
                        <ul>
                            @foreach($remaining as $server)
                                <li>{{$server->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
