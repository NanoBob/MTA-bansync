<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BanReason extends Model
{
    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
