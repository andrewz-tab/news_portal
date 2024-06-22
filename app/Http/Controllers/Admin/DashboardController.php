<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CV;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $postsCount = Post::count();
        $usersCount = User::count();
        $commentsCount = Comment::count();
        $cvsCount = CV::count();
        return view('admin_panel.dashboard', compact('postsCount', 'commentsCount', 'usersCount', 'cvsCount'));
    }
}
