<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookPartyCheckin extends Model
{
    protected $table = 'book_party_checkin';

    protected $fillable = [
        'uid', 'book_party_id'
    ];
}
