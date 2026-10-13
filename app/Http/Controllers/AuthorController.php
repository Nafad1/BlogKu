<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;

class AuthorController extends Controller
{
    public function show(User $user)
    {
        $posts = Post::where('user_id', $user->id)
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        $totalPosts = Post::where('user_id', $user->id)
            ->where('status', 'published')
            ->count();

        $totalViews = Post::where('user_id', $user->id)
            ->sum('views');

        return view('authors.show', compact('user', 'posts', 'totalPosts', 'totalViews'));
    }
}