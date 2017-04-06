<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    protected $userRepository;
    protected $apiUser;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->apiUser = Auth::guard('api')->user();
    }

    public function index($id)
    {
        $user = $this->userRepository->byId($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if (in_array($this->apiUser->id,$followers))
        {
            return response()->json(['followed'=> true]);
        }
        return response()->json(['followed'=> false]);

    }

    public function follow(Request $request)
    {
        $userToFollow = $this->userRepository->byId(request('user'));
        $followed = $this->apiUser->followThisUser($userToFollow->id);
        if (count($followed['attached'])>0)
        {
            $userToFollow->increment('followers_count');
            return response()->json(['followed'=> true]);
        }
        $userToFollow->decrement('followers_count');
        return response()->json(['followed'=> false]);
    }
}
