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
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action = "{{ route("manage.admins.update", [ "id"  => $admin->id ]) }}" method = "POST">
                            {{ csrf_field() }}
                            {{ method_field("PATCH") }}
                            <div class = "form-group">
                                <label>Name</label>
                                <input name = "name" class = "form-control" type = "text" value = "{{ $admin->name }}" />
                                <label>Email</label>
                                <input name = "email" class = "form-control" type = "text" value = "{{ $admin->email }}" />
                                <label>Password</label>
                                <input name = "password" class = "form-control" type = "password" />
                            </div>
                            <input class = "btn btn-default btn-lg pull-right" type = "submit" value = "Save"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
