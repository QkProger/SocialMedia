<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FullTestController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendSController;
use App\Http\Controllers\UserPostRelationshipController;
use App\Http\Controllers\GroupController;
use App\Models\FriendRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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
/*Посттар*/

Route::get('/', [PostController::class, 'index'])->name('post.index');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.delete');

    Route::post('/sendLike', [UserPostRelationshipController::class, 'like_send'])->name('like_send');
    Route::post('/savePost', [UserPostRelationshipController::class, 'post_save'])->name('post_save');

    /*Курстар*/
    Route::get('/courses/index', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{id}/download', [CourseController::class, 'downloadFile'])->name('courses.download');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::patch('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.delete');

    /*Messages*/
    Route::get('/chats/chat', [MessageController::class, 'create'])->name('chats.chat');
    Route::get('/chats/{id}/download', [MessageController::class, 'downloadFile'])->name('chats.download');
    Route::get('/audio/{filename}', [MessageController::class, 'getAudioFile'])->name('getAudioFile');
    Route::post('/chats/chat', [MessageController::class, 'store']);
    Route::put('/chats/chat/{message}', [MessageController::class, 'update'])->name('chats.chat.update');
    Route::delete('/chats/chat/{message}', [MessageController::class, 'destroy'])->name('chats.chat.delete');
    Route::get('/chats/chat/{user}', [MessageController::class, 'loadChat'])->name('chats.load-chat');
    Route::get('/chats/messanger', [MessageController::class, 'messanger'])->name('chats.messanger');

    /*Users*/
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/{user_id}', [UserController::class, 'update'])->name('user.update');

    Route::get('/user/profile/{user_id}', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/authUser/deleteFriend', [UserController::class, 'deleteFriend']);


    Route::post('/sendLike', [UserPostRelationshipController::class, 'like_send'])->name('user.like_send');
    Route::post('/savePost', [UserPostRelationshipController::class, 'post_save'])->name('user.post_save');
    Route::get('/bookmarks', [UserController::class, 'bookmarks'])->name('user.bookmarks');

    /*Friend Requests */
    Route::get('/user/List', [FriendRequestController::class, 'usersList'])->name('user.usersList');
    Route::post('/userRequests/request', [FriendRequestController::class, 'store']);
    Route::post('/acceptRequests/{id}', [FriendRequestController::class, 'accept_update'])->name('accept_update');
    Route::post('/declineRequests/{id}', [FriendRequestController::class, 'decline_update'])->name('decline_update');

    /*Friends */


    // Route::get('/chats/messanger', [FriendsController::class, 'messanger'])->name('chats.messanger');


    Route::post('/group/store', [GroupController::class, 'store'])->name('group.store');
    Route::get('/groups/chat', [GroupController::class, 'create'])->name('groups.chat');
    Route::get('/groups/chat/{group}', [GroupController::class, 'loadChat'])->name('groups.load-chat');
    /*Отправка сообщений в группу */
    Route::post('/groups/chat', [GroupController::class, 'groupMessageStore']);
    Route::get('/groups/{id}/download', [GroupController::class, 'downloadFile'])->name('groups.download');
    Route::post('/group/update/{id}', [GroupController::class, 'update'])->name('group.update');


    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('group_chat_files/{filename}', function ($filename) {
        $path = storage_path('app/group_chat_files/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('chat_files/{filename}', function ($filename) {
        $path = storage_path('app/chat_files/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
});

Auth::routes(['login' => false, 'logout' => false]);

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('adminLoginShow');
    Route::post('/login', [AdminAuthController::class, 'adminLoginForm'])->name('adminLoginForm');
});


