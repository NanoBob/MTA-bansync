<?php

namespace App\Http\Controllers;

use App\VerificationRequest;
use App\VerificationVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Carbon\Carbon;
use App\User;

class VerificationController extends Controller
{
    public function index(){
        return view("management.verification.index", [ "requests" => VerificationRequest::all()->sortBy("state")]);
    }

    public function store(Request $request){
        $user = Auth::user();
        $server = $user->server;
        if ($server->verified){
            return redirect()->back()->withErrors([ "You server is already verified. There is no need for you to do this again "]);
        }
        $openRequest = $server->getOpenVerificationRequest();
        if ($openRequest){
            return view("management.verification.view",[ "id" => $openRequest->id ]);
        }
        $latest = $server->getLatestVerificationRequest();
        if ($latest){
            $latestCreated = new Carbon($latest->created_at);
            if (Carbon::now()->diffInDays($latestCreated) < 60){
                return redirect()->back()->withErrors([ "You can not create a new request within 60 days of your previous request "]);
            }
        }

        $verificationRequest = new VerificationRequest();
        $verificationRequest->server_id = Auth::user()->id;
        $verificationRequest->name = Auth::user()->name;
        $verificationRequest->content = $request->input("content");
        $verificationRequest->save();
        return view("management.verification.view",[ "id" => $verificationRequest->id ]);
    }

    public function view($id){
        $verificationRequest = VerificationRequest::find($id);
        $server = Auth::user()->server;
        if ($server->verified || $server == $verificationRequest->server){
            return view("management.verification.view",["request" => $verificationRequest ]);
        }
        return redirect(route("/"));
    }

    public function approve($id){
        $verificationRequest = VerificationRequest::find($id);
        if ($verificationRequest->state != "open"){
            return view("management.verification.view",["request" => $verificationRequest ]);
        }
        $server = Auth::user()->server;
        if ($server->verified || $server == $verificationRequest->server){
            foreach($verificationRequest->votes as $vote){
                if ($vote->server == Auth::user()){
                    $vote->vote = true;
                    $vote->reason = "changed";
                    $vote->save();
                    $this->handleVote($verificationRequest);
                    return view("management.verification.view",["request" => $verificationRequest ]);
                }
            }
            $vote = new VerificationVote();
            $vote->voter_id = Auth::user()->id;
            $vote->vote = true;
            $vote->reason = "added";
            $vote->request_id = $id;
            $vote->save();
            $this->handleVote($verificationRequest);
            return view("management.verification.view",["request" => $verificationRequest ]);
        }
        return redirect(route("/"));
    }

    public function decline($id){
        $verificationRequest = VerificationRequest::find($id);
        if ($verificationRequest->state != "open"){
            return view("management.verification.view",["request" => $verificationRequest ]);
        }
        $server = Auth::user()->server;
        if ($server->verified || $server == $verificationRequest->server){
            foreach($verificationRequest->votes as $vote){
                if ($vote->server == Auth::user()){
                    $vote->vote = false;
                    $vote->reason = "changed";
                    $vote->save();
                    $this->handleVote($verificationRequest);
                    return view("management.verification.view",["request" => $verificationRequest ]);
                }
            }
            $vote = new VerificationVote();
            $vote->voter_id = Auth::user()->id;
            $vote->vote = false;
            $vote->reason = "added";
            $vote->request_id = $id;
            $vote->save();
            $this->handleVote($verificationRequest);
            return view("management.verification.view",["request" => $verificationRequest ]);
        }
        return redirect(route("/"));
    }

    public function handleVote($request){
        if ($request->trueVoteCount() > User::where("verified",1)->count() * 0.5){
            $request->accept();
        }
    }
}
