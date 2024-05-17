<?php

use App\Http\Controllers\Admin\GroupController;
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

Route::get('/', function () {
    return Inertia::render('Admin/home');
})->name('index');
//Route::middleware('adminAuth')->group(function () {
//    Route::resource('roles', RoleController::class)->except(['show'])->names('roles');
//});

Route::resource('posts', PostsController::class)->except(['show'])->names('posts');
Route::resource('users', UsersController::class)->except(['show'])->names('users');
Route::post('/group/create', [GroupController::class, 'createGroup'])->name('group.createGroup');