<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $server = $user->server;
        $admins = $server->children()->paginate(15);

        return view("management.admins.index", [ "server" => $server,  "admins" => $admins ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view("management.admins.create", [  ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "string",
            "email" => "string",
            "password" => "string"
        ]);

        $admin = new User();
        $admin->type = "admin";
        $admin->name = $request->get("name");
        $admin->password = bcrypt($request->get("password"));
        $admin->parent_id = Auth::user()->server->id;
        $admin->email = $request->get("email");
        $admin->verified = 0;

        $admin->save();
        return redirect(route("manage.admins.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id = -1)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = User::find($id);
        return view("management.admins.edit",[ "admin" => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "string",
            "email" => "string",
            "password" => "string|nullable"
        ]);

        $user = User::find($id);
        if ($request->has("password")){
            $user->password = bcrypt($request->get("password"));
        }
        $user->name = $request->get("name");
        $user->email = $request->get("email");
        $user->save();

        return redirect(route("manage.admins.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $admin = User::find($id);
        $admin->delete();
        return redirect(route("manage.admins.index"));
    }
}
