<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CommentController;

// auth:sanctum artinya harus login
Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/logout', [AuthenticateController::class, 'logout']);
    Route::get('/userprofile', [AuthenticateController::class, 'userprofile']);

    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware('user-post');
    Route::delete('/posts/{id}', [PostController::class, 'delete'])->middleware('user-post');

    // cara mengambil id bisa memakai /comment/{id}, dan bisa juga pakai inputan (bisa dilihat di comment controller $request->post_id), tergantung dari kalian mau memakai cara apa
    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('user-comment');
    Route::delete('/comment/{id}', [CommentController::class, 'delete'])->middleware('user-comment');
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'showAuthor']);

Route::post('/login', [AuthenticateController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
