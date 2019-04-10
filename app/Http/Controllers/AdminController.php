<?php

namespace App\Http\Controllers;

use App\BookParty;
use App\UserAdmin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showAdmin(){

        $admins = UserAdmin::select('name','username')
            ->orderby('id')
            ->get();
        return RJM(0,
            ['admins' => $admins]);
    }


}
