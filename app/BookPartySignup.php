<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class BookPartySignup extends Model
{
    protected $table = 'book_party_signup';

    protected $fillable = [
        'uid', 'book_party_id'
    ];

}
