<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    public function banner(){
        return $this->hasOne('App\User','id','banner_id');
    }

    public function reason(){
        return $this->hasOne('App\BanReason','id','ban_reason_id');
    }

    public function getServerAttribute(){
        return $this->banner->server;
    }
}
