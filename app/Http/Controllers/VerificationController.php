<?php

namespace App\Http\Controllers;

use App\VerificationRequest;
use App\VerificationVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use App\User;

class VerificationController extends Controller
{
    public function index(){
        return view("verification.index", [ "requests" => VerificationRequest::all()]);
    }

    public function store(Request $request){
        $verificationRequest = new VerificationRequest();
        $verificationRequest->server_id = Auth::user()->id;
        $verificationRequest->name = Auth::user()->name;
        $verificationRequest->content = $request->input("content");
        $verificationRequest->save();
        return view("verification.view",[ "id" => $verificationRequest->id ]);
    }

    public function view($id){
        $verificationRequest = VerificationRequest::find($id);
        $server = Auth::user()->server;
        if ($server->verified || $server == $verificationRequest->server){
            return view("verification.view",["request" => $verificationRequest ]);
        }
        return redirect(route("/"));
    }

    public function approve($id){
        $verificationRequest = VerificationRequest::find($id);
        $server = Auth::user()->server;
        if ($server->verified || $server == $verificationRequest->server){
            foreach($verificationRequest->votes as $vote){
                if ($vote->server == Auth::user()){
                    $vote->vote = true;
                    $vote->reason = "changed";
                    $vote->save();
                    $this->handleVote($verificationRequest);
                    return view("verification.view",["request" => $verificationRequest ]);
                }
            }
            $vote = new VerificationVote();
            $vote->voter_id = Auth::user()->id;
            $vote->vote = true;
            $vote->reason = "added";
            $vote->request_id = $id;
            $vote->save();
            $this->handleVote($verificationRequest);
            return view("verification.view",["request" => $verificationRequest ]);
        }
        return redirect(route("/"));
    }

    public function decline($id){
        $verificationRequest = VerificationRequest::find($id);
        $server = Auth::user()->server;
        if ($server->verified || $server == $verificationRequest->server){
            foreach($verificationRequest->votes as $vote){
                if ($vote->server == Auth::user()){
                    $vote->vote = false;
                    $vote->reason = "changed";
                    $vote->save();
                    $this->handleVote($verificationRequest);
                    return view("verification.view",["request" => $verificationRequest ]);
                }
            }
            $vote = new VerificationVote();
            $vote->voter_id = Auth::user()->id;
            $vote->vote = false;
            $vote->reason = "added";
            $vote->request_id = $id;
            $vote->save();
            $this->handleVote($verificationRequest);
            return view("verification.view",["request" => $verificationRequest ]);
        }
        return redirect(route("/"));
    }

    public function handleVote($request){
        if ($request->trueVoteCount() > User::where("verified",1)->count() * 0.5){
            $request->accept();
        }
    }
}
