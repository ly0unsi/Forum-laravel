<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'App\Http\Controllers\ForumController@index');
Route::resource('topics', 'App\Http\Controllers\ForumController')->except('index');
Route::post('/comments/{tid}', [App\Http\Controllers\CommentController::class, 'store']);
Route::get('/showFromNotification/{topic}/{notification}', [App\Http\Controllers\ForumController::class, 'showFrom']);
Route::post('/upload', [App\Http\Controllers\ForumController::class, 'upload']);
Route::get('/profile/{user}', [App\Http\Controllers\ForumController::class, 'showProfile']);
Route::patch('/editProfile/{user}', [App\Http\Controllers\ForumController::class, 'editProfile']);
Route::get('/search', [App\Http\Controllers\ForumController::class, 'search']);;
Route::post('/reply/{comment}', [App\Http\Controllers\CommentController::class, 'reply']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
