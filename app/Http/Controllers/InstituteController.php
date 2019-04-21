<?php

namespace App\Http\Controllers;

use App\Institute;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function list() {
        return RJM(0, Institute::get());
    }

}
