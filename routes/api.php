<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Modules\User\Controllers\UserController;
use App\Modules\Post\Controllers\PostController;

Route::apiResource('users', UserController::class);
Route::apiResource('posts', PostController::class);


