<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    protected $table = 'user_admins';

    protected $fillable = [
        'username', 'password','name',
    ];

    protected $hidden = [
//
    ];
    public function isAdmin(){
        return $this->is_admin ==='Y';
    }
}
