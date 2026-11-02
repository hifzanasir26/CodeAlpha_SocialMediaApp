<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::post('/like/{post}', [LikeController::class, 'like'])->name('post.like');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

Route::post('/follow/{user}', [FollowController::class, 'follow'])
    ->name('user.follow');
});
