@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ env("APP_NAME") }}</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                Banned
                            </div>
                        @endif
                        <h1>Help I'm banned!</h1>
                        <p>
                            If you were sent to this page, you have most likely been banned by one of our contributing
                            servers. This means you are banned across multiple MTA servers for your actions on one of them.
                            In order to be unbanned you can appeal your ban on this website.
                        </p>
                        <p>
                            In order to appeal your ban you need to know your 'appeal code'. You can find this by
                            trying to connect to the server you are banned to. Enter the key in the input field below
                            and you can appeal your ban. When appealing, remember to be polite.
                        </p>
                        <form action = "{{route("appeal.list")}}" method = "GET">
                            <input type = "text" name = "appealCode" placeholder = "Appeal code" />
                            <input type = "submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
