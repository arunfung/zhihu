<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use Auth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

/**
 * Class FollowersController
 * @package App\Http\Controllers
 */
class FollowersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * FollowersController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $user = $this->userRepository->byId($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if (in_array(user('api')->id,$followers))
        {
            return response()->json(['followed'=> true]);
        }
        return response()->json(['followed'=> false]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $userToFollow = $this->userRepository->byId(request('user'));
        $followed = user('api')->followThisUser($userToFollow->id);
        if (count($followed['attached'])>0)
        {
            $userToFollow->notify(new NewUserFollowNotification());
            $userToFollow->increment('followers_count');
            return response()->json(['followed'=> true]);
        }
        $userToFollow->decrement('followers_count');
        return response()->json(['followed'=> false]);
    }
}
