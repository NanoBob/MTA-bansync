<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', "type", 'verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getServerAttribute(){
        if ($this->type == "server"){
            return $this;
        }
        return $this->Parent;
    }

    public function parent(){
        return $this->hasOne('App\User','id','parent_id');
    }

    public function children(){
        return $this->hasMany('App\User','parent_id','id');
    }

    public function bans(){
        return $this->hasMany('App\Ban','banner_id','id');
    }

    public function serverBans(){
        return $this->hasMany('App\Ban','server_id','id');
    }

    public function appeals(){
        return $this->hasMany('App\BanAppeal','server_id','id');
    }

    public function clientAppeals(){
        return $this->hasMany('App\BanAppeal','banned_id','id');
    }

    public function settings(){
        return $this->hasMany('App\ServerSetting','server_id','id');
    }

    public function enforcedBans(){
        $bans = Ban::where("banned_until",">",Carbon::now())->get();

        $enforcingBans = [];
        $server = app()->server;
        $serverSettings = $server->settings;
        foreach($bans as $ban){
            foreach($serverSettings as $setting){
                if ($setting->server == $ban->server && $setting->reasons[$ban->reason]){
                    $enforcingBans[count($enforcingBans)] = $ban;
                    break;
                }
            }
        }
        return $enforcingBans;
    }


}
