<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BanAppeal extends Model
{

    public function ban(){
        return $this->hasOne('App\Ban','id','ban_id');
    }

    public function server(){
        return $this->hasOne('App\User','id','server_id');
    }

    public function state(){
        return $this->hasOne('App\AppealState','id','state_id');
    }
}
