<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingDetail extends Model
{

    public function reason(){
        return $this->hasOne('App\BanReason','id','reason_id');
    }
}
