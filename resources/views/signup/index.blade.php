@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ env("APP_NAME") }}</div>

                    <div class="panel-body">
                        @if ( isset($message))
                            <div class="alert alert-success">
                                {{ $message }}
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
                        <h2>Server signup</h2>
                        <p>
                            This is the form to sign up as a server. If you're trying to create an account to make
                            a ban appeal click <a href="appeal">here</a>.
                        </p>
                        <p>
                            Signing up a server to join the project doesn't require anything. Simply fill in the form
                            below and you're good to go.
                        </p><br>
                        <form action = "{{ route("signup.submit") }}" method = "POST">
                            {{ csrf_field() }}
                            <label>Server name</label><input class = "form-control" type = "text" name="name" />
                            <label>Email</label><input class = "form-control" type = "text" name="email" />
                            <label>Password</label><input class = "form-control" type = "password" name="password" /><br>
                            <input class = "btn btn-lg pull-right" type = "submit" value = "Sign up"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
