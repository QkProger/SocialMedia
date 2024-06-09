@extends('layouts.main')
@section('content')
    <div class="middle forrow">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ asset($user->avatar) }}" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h3>{{ $user->nickname }}</h3>
                                <p class="text-muted mb-1">{{ $user->mamandyq }}</p>
                                <p class="text-muted font-size-sm mb-3">{{ $user->oblys }}, {{ $user->qala }}</p>
                                @if ($user->id != auth()->id())
                                    @if ($is_friend)
                                        <form class="deleteForm">
                                            <input type="hidden" value="{{ $user->id }}" class="friend_id">
                                            <button type="submit" class="addFriendButton no-btn">
                                                <div class="btn btn-danger mr-5 deleteFriend mb-2">Өшіру</div>
                                                <div class="ma-0 waiting is_deleted">
                                                    Жойылды...
                                                </div>
                                            </button>
                                        </form>
                                    @else
                                        <form class="form">
                                            <input type="hidden" value="{{ $user->id }}" class="user_id">
                                            <button type="submit" class="addFriendButton no-btn">
                                                @if ($friendRequests->where('receiver_user_id', $user->id)->count() > 0)
                                                    <div class="ma-0 waiting">
                                                        Жауап күтілуде...
                                                    </div>
                                                @else
                                                    <div class="btn btn-primary mr-5 addToFriend mb-2">Тіркелу</div>
                                                    <div class="ma-0 waiting checkmark">
                                                        Жауап күтілуде...
                                                    </div>
                                                @endif
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('chats.load-chat', $user->id) }}" class="user-link">
                                        <button class="btn">Хабарлама</button>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <style>
                .form {
                    width: 100%;
                }

                .waiting {
                    cursor: default;
                    margin-bottom: 10px;
                }
            </style>
            <script>
                $('.deleteForm').on('submit', function(event) {
                    event.preventDefault();
                    var form = $(this);
                    var formDataArray = form.serializeArray();
                    formDataArray.push({
                        name: 'friend_id',
                        value: $(this).find(".friend_id").val()
                    });
                    formDataArray.push({
                        name: '_token',
                        value: "{{ csrf_token() }}"
                    });

                    var formData = $.param(formDataArray);
                    console.log(formData);
                    $.ajax({
                        url: "/authUser/deleteFriend",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            form.find('.deleteFriend').hide();
                            form.closest('.deleteForm').find('.is_deleted').show();
                        },
                    });
                });
                $('.form').on('submit', function(event) {
                    event.preventDefault();
                    var form = $(this);
                    var formDataArray = form.serializeArray();
                    formDataArray.push({
                        name: 'receiver_user_id',
                        value: $(this).find(".user_id").val()
                    });
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
                            form.find('.addToFriend').hide();
                            form.closest('.form').find('.checkmark').show();
                        }
                    });
                });
            </script>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="mb-0">Аты-жөні</h4>
                            </div>
                            <div class="col-sm-9 text-muted">
                                {{ $user->name }} {{ $user->surname }}
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="mb-0">Туған-күні</h4>
                            </div>
                            <div class="col-sm-9 text-muted">
                                {{ $user->birthday }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="mb-0">Мамандығы</h4>
                            </div>
                            <div class="col-sm-9 text-muted">
                                {{ $user->mamandyq }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="mb-0">Телефон номері</h4>
                            </div>
                            <div class="col-sm-9 text-muted">
                                {{ $user->phone }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="mb-0">Почтасы</h4>
                            </div>
                            <div class="col-sm-9 text-muted">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FEEDS --}}
        <div class="feeds">
            {{-- FEED 1 --}}
            @foreach ($posts as $post)
                <div class="feed">
                    <div class="head">
                        <div class="user">
                            <div class="profile-photo">
                                <img src="{{ asset($user->avatar) }}" class="avaChat">
                            </div>
                            <div class="info">
                                <h3>{{ $user->name }} {{ $user->surname }}</h3>
                                <small>
                                    @php
                                        $publishedDate = Carbon\Carbon::parse($post->published_at);
                                        $currentDate = Carbon\Carbon::now();
                                        $daysDifference = $publishedDate->diffInDays($currentDate);
                                    @endphp

                                    @if ($daysDifference > 2)
                                        @if ($publishedDate->isCurrentYear())
                                            {{ $publishedDate->format('M-d') }}
                                        @else
                                            {{ $publishedDate->format('Y-M-d') }}
                                        @endif
                                    @else
                                        {{ $publishedDate->isToday() ? $publishedDate->format('Бүгін H:i') : $publishedDate->format('M-d') }}
                                    @endif
                                </small>

                            </div>
                        </div>
                    </div>
                    <div class="photo">
                        <img src="{{ asset($post->image) }}">
                    </div>
            @endforeach
            {{-- END OF FEED --}}
        </div>
        {{-- END OF FEEDS --}}
    </div>
@endsection
