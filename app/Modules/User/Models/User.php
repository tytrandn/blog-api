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
        static::saved(function ($post) {
            Cache::forget('users');
        });
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
}