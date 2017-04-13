<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function avatar()
    {
        return view('users.avatar');
    }
}
