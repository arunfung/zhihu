<?php

namespace App\Http\Controllers;

use Hash;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;

/**
 * Class PasswordController
 * @package App\Http\Controllers
 */
class PasswordController extends Controller
{
    /**
     * PasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password(){
        return view('users.password');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ChangePasswordRequest $request)
    {
        if (Hash::check(request('old_password'),user()->password)){
            user()->password = bcrypt(request('password'));
            user()->save();
            flash('更改成功','success');
            return back();
        }
        flash('密码修改失败','danger');
        return back();
    }
}
