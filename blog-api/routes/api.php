<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\AdminPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);


Route::get('/admin/posts', [AdminPostController::class, 'index']);
Route::post('/admin/posts', [AdminPostController::class, 'store']);
Route::get('/admin/posts/{post:slug}/edit', [AdminPostController::class, 'show']);
Route::patch('/admin/posts/{post:uuid}', [AdminPostController::class, 'update']);
