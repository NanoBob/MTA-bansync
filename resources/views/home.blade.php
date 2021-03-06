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

                        <p>
                            MTA bansyc is a project to be able to synchronize bans between multiple servers.
                        </p>
                        <p>
                            The main goal of bansync is to create a community where servers can contribute to keeping
                            each other's servers clear of undesired players.
                        </p>
                        <h2>Signing up</h2>
                        <p>
                            In order to get started you can sign up for a server account <a href="{{route("signup.index")}}">here</a>.
                            After you create a server account you can instantly start contributing to the
                            database of banned players. You will also be able to keep the players in the bansync database
                            from playing on your server by implementing the bansync lua resource, or code snippet.<br>
                            More info on how to implement bansync can be found on the management dashboard after you have signed up.
                        </p>
                        <h2>Abuse prevention</h2>
                        <p>
                            In order to prevent abusive use of the system any server can specify which other server's bans
                            they also want to enforce on their server. So make sure you specify those you think can be trusted.<br>
                            You will also be able to specify for what types of bans you want to ban people, on a per server basis.<br>
                            Valid options are:
                        </p>
                        <ul>
                            @foreach( App\BanReason::all() as $reason)
                                <li>{{$reason->reason}}</li>
                            @endforeach
                        </ul>
                        <h2>Verified servers</h2>
                        <p>
                            As a server you can also apply to become a verified server. A verified server doesn't have
                            more power or abilities than regular servers. The only difference is that a server will be able
                            to mass specify what type of bans to follow for all verified servers.<br>
                            In order to become verified you must apply <a href="{{ route('verification') }}">here</a>.
                            Make sure to be logged in as a server account in order to request your verification.
                            Any currently verified server can contribute to the voting for server verification.
                        </p>
                        <h2>Help I'm banned!</h2>
                        <p>
                            For more information on what to do when you're banned please click <a href = "{{route("banned")}}">here</a>.
                        </p>
                        <h2>Can I trust this?</h2>
                        <p>
                            I understand it's difficult to trust some random website with banning players from your server.
                            Even though you control exactly what kind of bans, and from which servers do or don't get enforced
                            you would probably still want to know for certain that nothing shady is happening on the website here.
                            Instead of taking my word for it, you can check for yourself.
                            The source code for the website can thus be found on <a href = "https://github.com/NanoBob/MTA-bansync">github</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
