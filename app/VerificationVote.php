<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationVote extends Model
{
    function server(){
        return $this->hasOne('App\User','id','voter_id');
    }
}
