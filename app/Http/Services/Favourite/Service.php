<?php

namespace App\Http\Services\Favourite;


use App\Models\Favourite;
use App\Models\Post;

class Service
{
    public function store($user, Post $post)
    {
        if ($user != null) {
            $uid = $user->id;
            $pid = $post->id;

            $data['user_id'] = $uid;
            $data['post_id'] = $pid;

            $favourite = Favourite::withTrashed()->firstOrCreate(
                [
                'user_id' => $uid,
                'post_id' => $pid,
                ], $data
            );
            if ($favourite->wasRecentlyCreated) {
                $favourite->save();
                return;
            }
            if ($favourite->trashed()) {
                $favourite->restore();
            } else {
                $favourite->delete();
            }

            $favourite->save();
        }

    }
}
