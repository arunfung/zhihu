<?php
namespace App\Services;

use App\Mail\ActivateEmail;

use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function SendActivateEmail($user)
    {
        Mail::to($user->email)->send(new Welcome($user));
    }
}