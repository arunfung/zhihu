<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function avatar()
    {
        return view('users.avatar');
    }

    public function changeAvatar(Request $request)
    {
        $file = $request->file('img');
        $filename = md5(time().user()->id).'.'.$file->getClientOriginalExtension();
        $saveUrl = DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "avatars" . DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR;
        $file->move(public_path($saveUrl),$filename);

        user()->avatar = $saveUrl.$filename;
        user()->save();
        return ['url' => user()->avatar];
    }
}
