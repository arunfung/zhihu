<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 10/04/2017
 * Time: 3:40 PM
 */

namespace App\Repositories;


use App\Message;

class MessageRepository
{
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }
}