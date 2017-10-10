<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SettingDetail;

class ServerSetting extends Model
{
    public function detail(){
        return $this->hasMany('App\SettingDetail','setting_id','id');
    }

    public function server(){
        return $this->hasOne('App\User','id','server_id');
    }

    public function subject(){
        return $this->hasOne('App\User','id','subject_id');
    }

    public function getReasonsAttribute(){
        $reasons = [];
        foreach($this->detail as $detail){
            $reasons[$detail->reason] = true;
        }
        return $reasons;
    }

    public function enable($reason){
        foreach($this->detail as $detail){
            if ($detail->reason == $reason){
                return false;
            }
        }
        $detail = new SettingDetail();
        $detail->setting_id = $this->id;
        $detail->reason_id = $reason->id;
        $detail->value = true;
        $detail->save();
        return true;
    }

    public function disable($reason){
        foreach($this->detail as $detail){
            if ($detail->reason == $reason){
                $detail->delete();
                return true;
            }
        }
        return false;
    }

    public function isEnabled($reason){
        foreach($this->detail as $detail){
            if ($detail->reason == $reason){
                return true;
            }
        }
        return false;
    }
}
