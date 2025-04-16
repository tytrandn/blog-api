<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email'];
    protected $hidden = ['email'];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}