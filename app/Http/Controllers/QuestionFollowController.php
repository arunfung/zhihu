<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class QuestionFollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }


    public function follow($question)
    {
        Auth::user()->followThis($question);
        return back();
    }
}
