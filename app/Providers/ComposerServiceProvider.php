<?php

namespace App\Providers;

use App\Models\FriendRequests;
use App\Models\Friend;
use App\Models\GruppaUser;
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
            $user_id = auth()->id();
            $last_group_id = GruppaUser::where('user_id', $user_id)->latest('id')->pluck('gruppa_id')->first();
            $view->with([
                'user_requests' => $user_requests,
                'friends' => $friends,
                'last_group_id' => $last_group_id,
            ]);
        });
    }
}
