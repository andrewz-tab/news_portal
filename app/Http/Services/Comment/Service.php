<?php

namespace App\Http\Services\Comment;

use App\Models\Comment;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class Service
{
    public function store($data, $post, User $user)
    {

        $data['user_id'] = $user->id;
        $data['post_id'] = $post->id;
        $comment = Comment::create($data);

        $user->givePermissionTo(Permission::create(['name' => 'comment.*.' . $comment->id]));
    }

    public function update($comment, $data)
    {
        $comment->update($data);
    }

    public function restore($comment)
    {
        if ($comment->deleted_at != null) {
            $comment->restore();
            return true;
        } else {
            return false;
        }
    }
}
