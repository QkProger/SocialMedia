<?php

use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\GroupMessageController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UsersController;
use Inertia\Inertia;
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

Route::group(['middleware' => ['admin']], function () {
    Route::get('/', function () {
        return Inertia::render('Admin/home');
    })->name('index');

    Route::resource('posts', PostsController::class)->except(['show'])->names('posts');
    Route::resource('users', UsersController::class)->except(['show'])->names('users');
    Route::post('/group/create', [GroupController::class, 'createGroup'])->name('group.createGroup');

    Route::resource('messages', MessageController::class)->only(['index', 'destroy'])->names('message');
    Route::resource('group_messages', GroupMessageController::class)->only(['index', 'create', 'store', 'destroy'])->names('group_message');
    Route::get('/download', [GroupMessageController::class, 'downloadFile']);

    Route::resource('materials', MaterialController::class)->except(['show'])->names('material');
});
