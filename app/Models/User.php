<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }
    public function allFavourites()
    {
        return $this->belongsToMany(Post::class, 'favourites', 'user_id', 'post_id')->withTimestamps()->withPivot(['deleted_at']);
    }
    public function favourites()
    {
        return $this->allFavourites()->where('favourites.deleted_at', null)->orderByDesc('favourites.created_at')->take(9);
    }
    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'author_id', 'user_id');
    }
    public function allSubscriptions()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'user_id', 'author_id')->withTimestamps()->withPivot(['deleted_at']);
    }
    public function subscriptions()
    {
        return $this->allSubscriptions()->where('subscriptions.deleted_at', null);
    }
    public function cv()
    {
        return $this->hasOne(CV::class, 'user_id');
    }
    public function isSubscribed($user) : bool
    {
        if($user == null) {
            return false;
        }
        $subscription = $user->allSubscriptions()->where('author_id', $this->id)->first();
        if($subscription == null) {
            return false;
        }
        if($subscription->pivot->deleted_at !== null) {
            return false;
        } else {
            return true;
        }
    }
    public function hasCV() : bool
    {
        $cv = CV::where('user_id', $this->id)->first();
        if($cv == null) {
            return false;
        }
        return true;
    }
    public function authorStatus()
    {
        return $this->cv->status;
    }
    public function isBanned() : bool
    {
        return boolval($this->is_banned);
    }
    public function isNotBanned() : bool
    {
        return  !$this->isBanned();
    }
}
