@extends('layouts.main')
@section('content')
    <div class="middle">
        <div class="d-b">
            <div class="filter-friend">
                <div class="messages">
                    <h3 class="friend-title">Достар</h3>
                    <div class="user-list">
                        @foreach ($friends as $friend)
                            @php
                                $friendUser = $friend->user2;
                            @endphp
                            <a href="{{ route('chats.load-chat', $friendUser) }}" class="user-link"
                                data-user-id="{{ $friendUser->id }}">
                                <div class="message">
                                    <div class="profile-photo">
                                        <img src="/{{ $friendUser->avatar }}">
                                        <div class="active"></div>
                                    </div>
                                    <div class="message-body">
                                        <h5>{{ $friendUser->name }} {{ $friendUser->surname }}</h5>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <br>
            <div class="filter-friend">
                <div class="messages">
                    <h3 class="friend-title">Ғаламдық іздеу</h3>
                    <div class="user-list">
                        @foreach ($otherUsers as $otherUser)
                            <a href="{{ route('chats.load-chat', $otherUser) }}" class="user-link"
                                data-user-id="{{ $otherUser->id }}">
                                <div class="message">
                                    <div class="profile-photo">
                                        <img src="/{{ $otherUser->avatar }}">
                                        <div class="active"></div>
                                    </div>
                                    <div class="message-body">
                                        <h5>{{ $otherUser->name }} {{ $otherUser->surname }}</h5>
                                    </div>
                                    <form class="AddFriendForm chat-form">
                                        <input type="hidden" value="{{ $otherUser->id }}" class="user_id">
                                        <button type="submit" class="addFriendButton no-btn">
                                            <div class="svg-plus ml-3">
                                                @if ($friendRequests->where('receiver_user_id', $otherUser->id)->count() > 0)
                                                    <img src="{{ asset('images/request-friend.svg') }}" class="toUp">
                                                @else
                                                    <img src="{{ asset('images/addToFriend.svg') }}"
                                                        class="addToFriendImage">
                                                    <img src="{{ asset('images/request-friend.svg') }}" class="checkmark">
                                                @endif
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.AddFriendForm').on('submit', function(event) {
            event.preventDefault();
            var form = $(this);
            var formDataArray = form.serializeArray();
            formDataArray.push({
                name: 'receiver_user_id',
                value: $(this).find(".user_id").val()
            });

            // Add CSRF token
            formDataArray.push({
                name: '_token',
                value: "{{ csrf_token() }}"
            });

            var formData = $.param(formDataArray);
            $.ajax({
                url: "/userRequests/request",
                type: "POST",
                data: formData,
                success: function(response) {
                    console.log('Успешный ответ сервера:', response);
                    // Скрытие кнопки добавления
                    form.find('.addToFriendImage').hide();
                    // Изменение изображения на галочку
                    form.closest('.message').find('.checkmark').show();
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при отправке AJAX:', xhr, status, error);
                },
            });
        });
    </script>
@endsection
