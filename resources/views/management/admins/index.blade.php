@extends('management.layouts.app')

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
                        <a href = "{{ route("manage.admins.create") }}" class = "btn btn-default">Add new admin user</a>

                        <h2>Admins:</h2>
                        <div class = 'row'>
                            <div class = 'col-xs-9'>
                                <strong>Name</strong>
                            </div>
                            <div class = 'col-xs-3'>
                                <strong>Actions</strong>
                            </div>
                        </div>
                        @foreach($admins as $admin)
                            <div class = 'row server-row'>
                                <div class = 'col-xs-9'>
                                    {{ $admin->name }}
                                </div>
                                <div class = 'col-xs-3'>
                                    <a href = "{{ route("manage.admins.edit",[ "id" => $admin->id ]) }}">edit</a>
                                    <form action = "{{ route("manage.admins.destroy",[ "id" => $admin->id ]) }}" method = "POST" id = "deleteAdmin{{$admin->id}}">
                                        {{ csrf_field() }}
                                        {{ method_field("DELETE") }}
                                        <a onclick = "event.preventDefault(); document.getElementById('deleteAdmin{{$admin->id}}').submit()" href = "">Delete</a>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        {!! $admins->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
