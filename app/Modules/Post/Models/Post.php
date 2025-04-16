<?php
namespace App\Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Models\User;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'author_id'];

    protected static function booted()
    {
        static::saved(function ($post) {
            Cache::forget('posts');
        });
    }

    public function user() {
        return $this->belongsTo(User::class, 'author_id');
    }
}