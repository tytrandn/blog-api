<?php
namespace App\Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'author_id'];

    protected static function booted()
    {
        static::saved(function ($post) {
            Cache::forget('posts.all');
            Cache::forget("post_{$post->id}");
        });
    
        static::deleted(function ($post) {
            Cache::forget('posts.all');
            Cache::forget("post_{$post->id}");
        });
    }

    public function user() {
        return $this->belongsTo(User::class, 'author_id');
    }
}