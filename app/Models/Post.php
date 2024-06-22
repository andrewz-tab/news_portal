<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $table = 'posts';
    protected $guarded = [];


    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')->orderByDesc('created_at');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function favourites_count(): int
    {
        return count($this->users_favourite);
    }

    public function comments_count(): int
    {
        return count($this->users_commented);
    }

    public function users_favourite()
    {
        return $this->belongsToMany(User::class, 'favourites', 'post_id', 'user_id');
    }

    public function users_commented()
    {
        return $this->belongsToMany(User::class, 'comments', 'post_id', 'user_id');
    }

    public function isFavourite($user): bool
    {
        if ($user == null) {
            return false;
        }
        $favouritePost = $user->allFavourites()->where('post_id', $this->id)->first();
        if ($favouritePost == null) {
            return false;
        }
        $favourite = $favouritePost->pivot;
        if ($favourite->deleted_at !== null) {
            return false;
        } else {
            return true;
        }
    }

    public function getImageURL(): string
    {
        if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $this->image)) {
            return url($this->image);
        } else {
            return url('storage/' . $this->image);
        }

    }
}
