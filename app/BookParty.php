<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookParty extends Model
{
    protected $table = 'book_party';

    protected $fillable = [
        'title', 'start_time', 'place', 'speaker', 'max_user', 'summary', 'checkin_code'
    ];

    protected $hidden = [
        'checkin_code'
    ];
}
