<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CV extends Model
{
    use HasFactory;
    protected $table = 'cvs';
    protected $guarded = [];

    public const UNVERIFIED = 'unverified';
    public const APPROVED = 'approved';
    public const REFUSED = 'refused';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

}
