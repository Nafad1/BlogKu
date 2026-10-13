<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'Tidak bisa follow diri sendiri'], 422);
        }

        $existing = Follow::where('follower_id', auth()->id())
            ->where('following_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $followed = false;
        } else {
            Follow::create([
                'follower_id' => auth()->id(),
                'following_id' => $user->id,
            ]);
            $followed = true;
        }

        return response()->json([
            'followed' => $followed,
            'count' => $user->followers()->count(),
        ]);
    }
}