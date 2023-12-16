<?php

namespace App\Providers;

use App\Models\FriendRequests;
use App\Models\Friend;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.main', function ($view) {
            $friends = Friend::where('user1_id', auth()->id())
                ->with('user2')
                ->get();
            $user_requests = FriendRequests::with('user')->get();
            $view->with([
                'user_requests' => $user_requests,
                'friends' => $friends,
            ]);
        });
    }
}
