<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{

    protected $hidden = [
        'updated_at', 'ban_reason_id', 'banner_id', 'server_id',
    ];

    public function banner(){
        return $this->hasOne('App\User','id','banner_id');
    }

    public function reason(){
        return $this->hasOne('App\BanReason','id','ban_reason_id');
    }

    public function appeals(){
        return $this->hasMany('App\BanAppeal','ban_id','id');
    }

    public function openAppeals(){
        return $this->appeals()->where("state_id",1);
    }

    public function getServerAttribute(){
        return $this->banner->server;
    }
}
