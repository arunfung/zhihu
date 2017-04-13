<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 05/04/2017
 * Time: 8:08 PM
 */

namespace App\Repositories;


use App\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return $this->user->find($id);
    }

}