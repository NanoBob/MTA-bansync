<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class StaticPageController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function banned()
    {
        return view('banned');
    }

    public function developers()
    {
        return view('developers');
    }

    public function contributors(){
        $verified = User::where("verified",1)->get();
        $remaining = User::where("verified",0)->where("type","server")->get();
        return view('contributors', [ "verified" => $verified, "remaining" => $remaining]);
    }
}
