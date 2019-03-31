<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BookParty extends Model
{
    protected $table = 'book_party';

    protected $fillable = [
        'title', 'start_time', 'place', 'speaker', 'max_user', 'summary', 'checkin_code'
    ];

    protected $hidden = [
        'checkin_code'
    ];

    static public function getBookPartyWhenLogin($id, $uid) {
        if (!$id) {
            return null;
        }
        $bookParty = BookParty::where('id', '=', $id)->where('status', '=', '0')->first();
        if (!$bookParty) {
            return null;
        }
        if ($uid) {
            if (BookPartySignup::where('uid', $uid)->where('book_party_id', $id)->first()) {
                $bookParty->isSignup = true;
            }
            if (BookPartyCheckin::where('uid', $uid)->where('book_party_id', $id)->first()) {
                $bookParty->isCheckin = true;
            }
        }
        $bookParty->isSignup = !!$bookParty->isSignup;
        $bookParty->isCheckin = !!$bookParty->isCheckin;
        return $bookParty;
    }
}
