<?php

namespace App\Providers;

use App\Models\FriendRequests;
use App\Models\Friend;
use App\Models\Gruppa;
use App\Models\GruppaMessage;
use App\Models\GruppaUser;
use App\Models\Message;
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
            $msg_cnt = Message::where('sendler_user_id', $user_id)->where('is_cheked', 0)->count();

            $groups = GruppaUser::where('user_id', $user_id)->get();
            $totalUnreadMessagesCount = $groups->map(function ($groupUser) use ($user_id) {
                $unreadMessagesCount = GruppaMessage::where('gruppa_id', $groupUser->gruppa_id)
                    ->whereDoesntHave('groupUserMessageCheckeds', function ($query) use ($user_id) {
                        $query->where('user_id', $user_id)
                              ->whereColumn('gruppa_messages.id', 'group_user_message_checkeds.gruppa_message_id');
                    })
                    ->count();
        
                $groupUser->unread_messages_count = $unreadMessagesCount;
        
                return $unreadMessagesCount;
            })->sum();
            $view->with([
                'user_requests' => $user_requests,
                'friends' => $friends,
                'last_group_id' => $last_group_id,
                'msg_cnt' => $msg_cnt,
                'groups_msg_cnt' => $totalUnreadMessagesCount,
            ]);
        });
    }
}
