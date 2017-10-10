<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
    public function index(){
        return view("signup.index");
    }

    public function submit(Request $request){
        $user = new User();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);


        $user->name = $request->get("name");
        $user->email = $request->get("email");
        $user->password = bcrypt($request->get("password"));
        $user->type = "server";
        $user->api_key = strtoupper(str_random(64));
        $user->verified = false;

        $user->save();

        Auth::login($user);

        return view("signup.index", ["message" => "You have successfully registered your account"]);
    }
}
