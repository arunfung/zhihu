<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 12/04/2017
 * Time: 6:13 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Collection;

class MessageCollection extends Collection
{
    public function markAsRead()
    {
        $this->each(function($message){
            if ($message->to_user_id == user()->id)
            {
                $message->markAsRead();
            }
        });
    }

}