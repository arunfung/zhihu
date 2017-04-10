<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Auth;

class MessagesController extends Controller
{
    protected $message;
    protected $apiUser;

    /**
     * MessagesController constructor.
     * @param $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
        $this->apiUser = Auth::guard('api')->user();
    }

    public function store()
    {
        $message = $this->message->create([
            'to_user_id' => request('user'),
            'from_user_id' => $this->apiUser->id,
            'body' => request('body')
        ]);

        if($message)
        {
            return response()->json(['status'=>true]);
        }
        else{
            return response()->json(['status'=>false]);
        }
    }
}
