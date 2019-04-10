<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignUp extends Model
{
    protected $table = 'book_party_signup';

    protected $fillable = [
        'uid', 'book_party_id'
    ];

    protected $hidden = [
//
    ];
}
