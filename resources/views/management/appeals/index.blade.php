@extends('management/layouts.app')

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

                        <h2>Appeals:</h2>
                        <div class = 'row'>
                            <div class = 'col-xs-3'>
                                <strong>Player</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Last update</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>State</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Actions</strong>
                            </div>
                        </div>
                        @foreach($appeals as $appeal)
                            <div class = 'row server-row'>
                                <div class = 'col-xs-3'>
                                    {{ $appeal->ban->name }}
                                </div>
                                <div class = 'col-xs-3'>
                                    {{ $appeal->updated_at }}
                                </div>
                                <div class = 'col-xs-3'>
                                    {{ $appeal->state->state }}
                                </div>
                                <div class = 'col-xs-3'>
                                    <a href = "{{ route("manage.appeals.show",[ "id" => $appeal->id ]) }}">view</a>
                                </div>
                            </div>
                        @endforeach
                        {!! $appeals->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
