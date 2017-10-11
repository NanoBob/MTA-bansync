<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppealReply extends Model
{
    protected $table = "appeal_reply";

    public function author(){
        return $this->hasOne('App\User','id','author_id');
    }

    public function appeal(){
        return $this->hasOne('App\BanAppeal','id','appeal_id');
    }
}
