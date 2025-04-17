<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class User extends Model
{
    protected $fillable = ['name', 'email'];
    protected $hidden = ['email'];

    protected static function booted()
    {
        static::saved(function ($user) {
            Cache::forget('users.all');
            Cache::forget("user_{$user->id}");
        });
    
        static::deleted(function ($user) {
            Cache::forget('users.all');
            Cache::forget("user_{$user->id}");
        });
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
}