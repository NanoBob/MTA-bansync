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

                            </div>
                        @endif
                        <p>
                            Implementing Bansync is extremely easy.
                        </p>
                        <h2>But how?</h2>
                        <p>
                            Bansync can be implemented by adding some of several code snippets to a script on your server
                            which has access to the the kick function (function.kick) through the ACL. These code snippets
                            are available to you once you have signed up for a server account which you can do <a href = "{{ route("signup.index") }}">here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>hljs.initHighlightingOnLoad();</script>
@endsection
