<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Modules\User\Controllers\UserController;
use App\Modules\Post\Controllers\PostController;

Route::middleware(['api', 'throttle:api'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);
});

// Test Rate Limiting
// Route::get('/posts', function () {
//     return response()->json(['message' => 'Rate limit test passed']);
// });