<?php

namespace App\Http\Controllers;

use App\Question;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Auth;

class QuestionFollowController extends Controller
{
    protected $question;
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth')->except(['index']);
        $this->question = $question;
    }


    public function follow($question)
    {
        Auth::user()->followThis($question);
        return back();
    }

    public function follower(Request $request)
    {
        $followed = user('api')->followed($request->get('question'));
        if ($followed)
        {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function followThisQuestion(Request $request)
    {
        $question = $this->question->byId(request('question'));
        $followed = user('api')->followThis($question->id);
        if (count($followed['detached'])>0)
        {
            $question->decrement('followers_count');
            return response()->json(['followed' => false]);
        }
        $question->increment('followers_count');
        return response()->json(['followed' => true]);
    }
}
