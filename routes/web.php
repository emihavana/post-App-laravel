<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = auth()->check()
        ? auth()->user()->posts()->latest()->get()
        : collect();

    return view('welcome', ['posts' => $posts]);
});

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/login', [UserController::class, 'login'])->name('login');

// blog related routes
Route::post('/createPost', [PostController::class, 'CreatePost'])->name('createPost');
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{post}', [PostController::class, 'updatePost'])->name('updatePost');
Route::get('/delete-post/{post}', [PostController::class, 'deletePost'])->name('deletePost');
