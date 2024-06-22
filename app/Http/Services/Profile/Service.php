<?php

namespace App\Http\Services\Profile;
use App\Http\Filters\PostFilter;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Service
{
    public function getSubscription(User $user)
    {
        $subscriptions = $user->subscriptions()->orderByDesc('subscriptions.created_at')->paginate(10);
        return $subscriptions;
    }

    public function getFavourites(User $user)
    {
        $posts = $user->favourites()->orderByDesc('favourites.created_at')->paginate(10);
        return $posts;
    }
    public function getPosts($search, User $user)
    {
        $filter = app()->make(PostFilter::class, ['queryParams' => array_filter($search)]);
        $user = auth()->user();
        $subscriptions = $user->subscriptions;
        return Post::filter($filter)->whereIn('author_id', $subscriptions->pluck('id'))->orderByDesc('created_at')->paginate(9);
        
    }
    public function updateGeneral($data, User $user)
    {
        User::whereId($user->id)->update($data);
    }
    public function updatePassword($data, User $user)
    {
        // Match The Old Password
        if(!Hash::check($data['old_password'], $user->password)) {
            return ["error", "Введенный пароль не совпадает с текущим!"];
        }
        // Update the new Password
        User::whereId($user->id)->update([
                'password' => Hash::make($data['new_password']),
            ]
        );
        return ["status", "Пароль успешно изменен!"];
    }
}
