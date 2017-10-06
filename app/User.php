<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        return $this->hasMany('App\ban','banner_id','id');
    }
}
