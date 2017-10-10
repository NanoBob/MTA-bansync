<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\User;

class ManagementController extends Controller
{
    public function index(){

        return view("management.index",["server" => Auth::user()->server]);
    }

    public function developers(){

        return view("management.developers",["server" => Auth::user()->server]);
    }

    public function bans(){

        return view("management.bans",["server" => Auth::user()->server]);
    }

    public function appeals(){

        return view("management.appeals",["server" => Auth::user()->server]);
    }
}
