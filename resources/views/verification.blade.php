@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verification request</div>

                    <div class="panel-body">
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
                            This page is used to request for your server to receive the 'verified' state.
                            Being a verified server means people can include your server in mass specifying settings.
                            This means that it is more likely for other servers to be following your server's bans.
                        </p>
                        <p>
                            The verification request will be reviewed and approved (or denied) by other already verified servers.
                            Once sufficient of them have votes in favor of you you will be verified.
                        </p>
                        <p>
                            In order to increase your chances of being accepted you can include any details about your server in the field below.
                            Try to add as much relevant information about your server, such as average player count, how long you've been around, etc.
                        </p>
                        <div class = "form-group">
                            <form action = "{{ route("verification.store") }}" method = "POST">
                                {{ csrf_field() }}
                                <textarea name = "content"></textarea>
                                <input type = "submit" class = "btn btn-default btn-large pull-right" value="Submit"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>hljs.initHighlightingOnLoad();</script>
@endsection
