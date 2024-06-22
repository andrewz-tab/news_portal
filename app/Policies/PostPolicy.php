<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('post.view.*');
    }
    public function view(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('post.view.' . $post->id);
    }
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('post.create');
    }
    public function update(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('post.update.' . $post->id);
    }
    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('post.delete.' . $post->id);
    }
    public function restore(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('post.restore.' . $post->id);
    }
    public function forceDelete(User $user, Post $post): bool
    {
        //
    }
}
