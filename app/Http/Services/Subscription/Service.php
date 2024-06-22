<?php

namespace App\Http\Services\Subscription;

use App\Models\Subscription;
use App\Models\User;

class Service
{
    public function store($user, User $author)
    {
        if ($user != null) {
            $uid = $user->id;
            $aid = $author->id;
            $data['user_id'] = $uid;
            $data['author_id'] = $aid;

            $subscription = Subscription::withTrashed()->firstOrCreate(
                [
                'user_id' => $uid,
                'author_id' => $aid,
                ], $data
            );
            if ($subscription->wasRecentlyCreated) {
                $subscription->save();
                return;
            }
            if($subscription->trashed()) {
                $subscription->restore();
            } else {
                $subscription->delete();
            }

            $subscription->save();
        }

    }
}
