<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Post $post)
    {
        $userId = auth()->id();

        $bookmark = Bookmark::where('post_id', $post->id)->where('user_id', $userId)->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
        } else {
            Bookmark::create(['post_id' => $post->id, 'user_id' => $userId]);
            $bookmarked = true;
        }

        return response()->json([
            'bookmarked' => $bookmarked,
            'count' => $post->bookmarks()->count(),
        ]);
    }

    public function index()
    {
        $bookmarks = Bookmark::with('post.user', 'post.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(9);

        return view('bookmarks.index', compact('bookmarks'));
    }
}