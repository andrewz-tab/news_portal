<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        $author = auth()->user();
        return view('author_panel.index', compact('author'));
    }
    public function news()
    {
        $user = auth()->user();
        $posts = Post::where('author_id', $user->id)->orderByDesc('created_at')->paginate(10);
        return view('author_panel.post.index', compact('posts'));
    }
}
