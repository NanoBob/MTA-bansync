<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VerificationRequest extends Model
{
    function server(){
        return $this->hasOne('App\User','id','server_id');
    }

    function votes(){
        return $this->hasMany('App\VerificationVote','request_id','id');
    }

    function trueVotes(){
        return $this->votes()->where("vote",1);
    }

    function falseVotes(){
        return $this->votes()->where("vote",0);
    }

    function trueVoteCount(){
        return $this->trueVotes()->count();
    }

    function falseVoteCount(){
        return $this->falseVotes()->count();
    }

    function accept(){
        $this->server->verified = 1;
        $this->server->save();
    }

    function getStateAttribute(){
        if ($this->server->verified){
            return "accepted";
        }
        $createdAt = new Carbon($this->created_at);
        $now = Carbon::now();
        $diff = $createdAt->diffInDays($now);
        if ($diff > 30){
            return "declined";
        }    else {
            return "open";
        }
    }
}
