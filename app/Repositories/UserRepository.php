<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 05/04/2017
 * Time: 8:08 PM
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function byId($id)
    {
        return $this->user->find($id);
    }

}