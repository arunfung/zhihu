<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 10/04/2017
 * Time: 3:40 PM
 */

namespace App\Repositories;


use App\Message;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * MessageRepository constructor.
     * @param $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @param array $attributes
     * @return
     */
    public function create(array $attributes)
    {
        return $this->message->create($attributes);
    }

    /**
     * @return mixed
     */
    public function getAllMessage()
    {
        return $this->message->where('to_user_id',user()->id)
            ->orWhere('from_user_id',user()->id)
            ->with([
                'fromUser' => function($query){return $query->select(['id','name','avatar']);},
                'toUser' => function($query){return $query->select(['id','name','avatar']);},
            ])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getDialogMessageBy($dialogId)
    {
        return $this->message->where('dialog_id',$dialogId)->with([
            'fromUser' => function($query){return $query->select(['id','name','avatar']);},
            'toUser' => function($query){return $query->select(['id','name','avatar']);},
        ])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getSingleMessageBy($dialogId)
    {
        return $this->message->where('dialog_id',$dialogId)->first();
    }
}