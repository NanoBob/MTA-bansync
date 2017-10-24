<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function verification(){
        $user = Auth::user();
        $server = $user->server;
        if ($server->verified){
            return redirect()->back()->withErrors([ "You server is already verified. There is no need for you to do this again "]);
        }
        $request = $server->getOpenVerificationRequest();
        if ($request){
            return redirect(route("verification.view",[ "id" => $request->id]));
        }
        $latest = $server->getLatestVerificationRequest();
        if ($latest){
            $latestCreated = new Carbon($latest->created_at);
            if (Carbon::now()->diffInDays($latestCreated) < 60){
                return redirect()->back()->withErrors([ "You can not create a new request within 60 days of your previous request "]);
            }
        }
        return view('verification');
    }
}
