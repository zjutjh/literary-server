<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institutes extends Model
{
    protected $table = 'institutes';

    protected $fillable = [
        'id', 'name', 'comment'
    ];

    protected $hidden = [
    //
    ];
}
