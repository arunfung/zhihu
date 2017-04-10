<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    protected $apiUser;
    protected $answerRepository;
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
        $this->apiUser = Auth::guard('api')->user();
    }

    public function users($id)
    {
        if ($this->apiUser->hasVotedFor($id))
        {
            return response()->json(['voted'=>true]);
        }
        return response()->json(['voted'=>false]);
    }

    public function vote()
    {
        $answer = $this->answerRepository->byId(request('answer'));
        $voted = $this->apiUser->voteFor(request('answer'));
        if (count($voted['attached'])>0)
        {

            $answer->increment('votes_count');
            return response()->json(['voted'=> true]);
        }
        $answer->decrement('votes_count');
        return response()->json(['voted'=> false]);
    }
}
