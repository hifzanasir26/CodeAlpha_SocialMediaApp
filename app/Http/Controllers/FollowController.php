<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;

class FollowController extends Controller
{
    public function follow($userId)
    {
        // khud ko follow na kare
        if (auth()->id() == $userId) {
            return redirect()->back();
        }

        $follow = Follower::where('follower_id', auth()->id())
            ->where('following_id', $userId)
            ->first();

        if ($follow) {
            $follow->delete(); // unfollow
        } else {
            Follower::create([
                'follower_id' => auth()->id(),
                'following_id' => $userId,
            ]);
        }

        return redirect()->back();
    }
}
