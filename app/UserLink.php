<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLink extends Model
{
    protected $fillable = [
        'uid', 'type', 'openid'
    ];
}
