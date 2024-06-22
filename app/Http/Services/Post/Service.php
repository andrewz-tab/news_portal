<?php

namespace App\Http\Services\Post;

use App\Http\Filters\PostFilter;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class Service
{
    public function index($data)
    {
        $filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);
        $posts = Post::filter($filter)->with(['author'])->orderByDesc('created_at')->paginate(9);
        return $posts;
    }

    public function adminIndex($data)
    {
        $filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);
        return Post::filter($filter)->with(['author', 'users_favourite', 'users_commented'])->withTrashed()->orderByDesc('created_at')->paginate(10);
    }

    public function adminShow($postId)
    {
        $comments = Comment::where('post_id', $postId)->with(
            [
            'post.author',
            'post.users_favourite',
            'post.users_commented',
            'user',
            ]
        )->withTrashed()->orderByDesc('created_at')->paginate(5);
        if (!isset($comments->first()->post)) {
            $post = Post::with(['comments'])->find($postId);
            if(!isset($post)) {
                abort(404);
            }
            return $post;
        }
        $post = $comments->first()->post;
        $post->comments = $comments;
        return $post;
    }

    public function show($postId)
    {
        
        $comments = Comment::where('post_id', $postId)->with(
            [
            'post.author',
            'user',
            ]
        )->orderByDesc('created_at')->paginate(5);
        if (!isset($comments->first()->post)) {
            $post = Post::with(['comments'])->find($postId);
            if(!isset($post)) {
                abort(404);
            }
            return $post;
        }
        $post = $comments->first()->post;
        $post->comments = $comments;
        
        return $post;
    }

    public function store($data, $author)
    {
        $data['author_id'] = $author->id;
        if (isset($data['image'])) {
            $data['image'] = Storage::disk('public')->put('/images', $data['image']);
        }
        $post = Post::create($data);
        $author->givePermissionTo(Permission::create(['name' => 'post.*.' . $post->id]));
    }

    public function update($post, $data)
    {
        if (isset($data['image'])) {
            $data['image'] = Storage::disk('public')->put('/images', $data['image']);
        }
        $post->update($data);
    }

    public function resotore($post): bool
    {
        if ($post->deleted_at != null) {
            $post->restore();
            return true;
        } else {
            return false;
        }
    }
}
