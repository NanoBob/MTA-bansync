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

    public function replies(){
        return $this->hasMany('App\AppealReply','appeal_id','id');
    }

    public function banned(){
        return $this->hasOne('App\User','id','banned_id');
    }

    public function reply($author, $content){
        $reply = new AppealReply();
        $reply->author_id = $author->id;
        $reply->content = $content;
        $reply->appeal_id = $this->id;
        $reply->save();
        $this->touch();
    }
}
