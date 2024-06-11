<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}">
    {{-- ICON SCOUT CDN --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    {{-- STYLESHEET --}}
    <title>Social media</title>
</head>

<body>
    <nav>
        <div class="container">
            <h2 class="log">
                <a href="{{ route('post.index') }}">eduSocial</a>
            </h2>
            <form action="{{ route('user.usersList') }}" method="GET">
                <div class="search-bar main-search">
                    <i class="uil uil-search"></i>
                    <input type="search" name="query" placeholder="Қолданушыларды іздеу...">
                    <button type="submit"><i class="uil uil-search"></i></button>
                </div>
            </form>
            <div class="create">
                @if (!Auth::user())
                    <a href="{{ route('register') }}">
                        <label for="create-post" class="btn btn-primary">Тіркелу</label>
                    </a>
                @endif
                @if (Auth::user())
                    <a href="{{ route('user.index') }}">
                        <div class="profile-photo">
                            <img src="/storage/{{ Auth::user()->avatar }}" class="avaChat">
                        </div>
                    </a>
                @else
                    <a href="{{ route('adminLoginForm') }}">
                        <div class="profile-photo">
                            <img src="{{ asset('images/default-avatar.jpg') }}" class="avaChat">
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </nav>

    {{-- MAIN --}}
    <main>
        <div class="container">
            {{-- LEFT --}}
            <div class="left">
                <div class="profile">
                    <div class="profile-photo">
                        @if (Auth::user())
                            <a href="{{ route('user.index') }}">
                                <img src="/storage/{{ Auth::user()->avatar }}" class="avaChat">
                            </a>
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}" class="avaChat">
                        @endif
                    </div>
                    <div class="handle">
                        @if (Auth::user())
                            <h4>{{ Auth::user()->name }} {{ Auth::user()->surname }}</h4>
                        @else
                            @if (Route::has('adminLoginForm'))
                                <h4><a href="{{ route('adminLoginForm') }}">{{ __('Кіру') }}</a></h4>
                            @endif
                            @if (Route::has('register'))
                                <h4><a href="{{ route('register') }}">{{ __('Тіркелу') }}</a></h4>
                            @endif
                        @endif
                        <p class="text-muted">
                            @if (Auth::user())
                                <span>{{ Auth::user()->nickname }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- SIDEBAR --}}
                <div class="sidebar">
                    <a href="{{ route('post.index') }}"
                        class="menu-item {{ request()->routeIs('post.index') ? 'active' : '' }}">
                        <span><i class="uil uil-home"></i></span>
                        <h3>Басты бет</h3>
                    </a>
                    {{-- <a class="menu-item" id="notifications">
                        <span><i class="uil uil-bell"><small class="notification-count">9+</small></i></span>
                        <h3>Notifications</h3>
                        <div class="notifications-popup">
                            <div>
                                <div class="profile-photo">
                                    <img src="{{ asset('images/profile-1.jpg') }}">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 DAYS AGO</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="{{ asset('images/profile-1.jpg') }}">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 DAYS AGO</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="{{ asset('images/profile-1.jpg') }}">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 DAYS AGO</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="{{ asset('images/profile-1.jpg') }}">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 DAYS AGO</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="{{ asset('images/profile-1.jpg') }}">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 DAYS AGO</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="{{ asset('images/profile-1.jpg') }}">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 DAYS AGO</small>
                                </div>
                            </div>
                        </div>
                    </a> --}}

                    <a href="{{ route('chats.messanger') }}"
                        class="menu-item {{ request()->routeIs('chats.messanger') ? 'active' : '' }}">
                        {{-- <span><i class="uil uil-envelope-alt"><small class="notification-count">6</small></i></span> --}}
                        <span><i class="uil uil-envelope-alt"></i></span>
                        <h3>Достар</h3>
                    </a>
                    <a href="{{ route('chats.chat') }}"
                        class="menu-item {{ request()->routeIs('chats.chat') || request()->is('chats/chat/*') ? 'active' : '' }}">
                        <span><i class="uil uil-facebook-messenger-alt"></i></span>
                        <h3>Чаттар</h3>
                    </a>
                    <a href="/groups/chat/{{ $last_group_id }}"
                        class="menu-item {{ request()->routeIs('groups.chat') || request()->is('groups/chat/*') ? 'active' : '' }}">
                        <span><i class="uil uil-facebook-messenger-alt"></i></span>
                        <h3>Группалар</h3>
                    </a>
                    <a href="{{ route('user.bookmarks') }}"
                        class="menu-item {{ request()->routeIs('user.bookmarks') ? 'active' : '' }}">
                        <span><i class="uil uil-bookmark"></i></span>
                        <h3>Сақталғандар</h3>
                    </a>
                    <a href="{{ route('courses.index') }}"
                        class="menu-item {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                        <span><i class="uil uil-book-open"></i></span>
                        <h3>Материалдар</h3>
                    </a>
                    @if (Route::currentRouteName() == 'user.index')
                        <a href="{{ route('logout') }}" class="menu-item"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <span><i class="uil uil-sign-out-alt"></i></span>
                            <h3>Шығу</h3>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="get" class="d-none">
                            @csrf
                        </form>
                    @endif
                </div>
                {{-- END OF SIDEBAR --}}
                @if (Route::currentRouteName() == 'user.index')
                    <a href="{{ route('post.create') }}">
                        <label for="create-post" class="btn btn-primary">Жаңа пост салу</label>
                    </a>
                @endif
            </div>
            {{-- END OF LEFT --}}


            {{-- MIDDLE --}}
            @yield('content')
            {{-- END OF MIDDLE --}}
            @if (Route::currentRouteName() == 'user.index' ||
                    Route::currentRouteName() == 'user.profile' ||
                    Route::currentRouteName() == 'user.edit' ||
                    Route::currentRouteName() == 'chats.chat' ||
                    Route::currentRouteName() == 'chats.load-chat' ||
                    Route::currentRouteName() == 'user.usersList' ||
                    Route::currentRouteName() == 'groups.chat' ||
                    Route::currentRouteName() == 'groups.load-chat')
                <style>
                    main .container {
                        grid-template-columns: 18vw auto;
                    }

                    main .container .right {
                        display: none;
                    }
                </style>
            @endif
            {{-- RIGHT --}}
            <div class="right">
                @if (Route::currentRouteName() != 'chats.messanger')
                    <div class="messages">
                        <div class="heading">
                            <h4>Достар</h4>
                        </div>
                        {{-- SEARCH BAR --}}
                        <div class="search-bar">
                            <i class="uil uil-search"></i>
                            <input type="search" placeholder="Іздеу" id="message-search">
                        </div>
                        {{-- MESSAGES CATEGORY --}}
                        <div class="category">
                            <h6 class="active"></h6>
                        </div>
                        @foreach ($friends as $friend)
                            @php
                                $friendUser = $friend->user2;
                            @endphp
                            {{-- MESSAGE --}}
                            <a href="{{ route('chats.load-chat', $friendUser) }}" class="user-link"
                                data-user-id="{{ $friendUser->id }}">
                                <div class="message align-items-center">
                                    <div class="profile-photo">
                                        @if ($friendUser->avatar)
                                            <img src="/storage/{{ $friendUser->avatar }}" class="avaChat">
                                        @else
                                            <img src="{{ asset('images/profile-1.jpg') }}" class="avaChat">
                                        @endif
                                        {{-- <div class="active"></div> --}}
                                    </div>
                                    <div class="message-body">
                                        <h5>{{ $friendUser->name }} {{ $friendUser->surname }}</h5>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    {{-- END OF MESSAGES --}}
                @endif

                {{-- FRIEND REQUESTS --}}
                @if (Route::currentRouteName() == 'chats.messanger')
                    <style>
                        .right .friend-requests {
                            margin-top: 0;
                        }
                    </style>
                @endif
                <div class="friend-requests">
                    <h4 style="margin-top: 0">Сұраныстар</h4>
                    @php
                        $k = 0;
                    @endphp
                    @if (Auth::user())
                        @foreach ($user_requests as $ur)
                            @if ($ur->is_waiting == 1 && $ur->receiver_user_id == Auth::user()->id && $ur->user_id != Auth::user()->id)
                                <div class="request">
                                    <div class="info">
                                        <div class="profile-photo">
                                            @if ($ur->user->avatar)
                                                <img src="/storage/{{ $ur->user->avatar }}" class="avaChat">
                                            @else
                                                <img src="{{ asset('images/profile-1.jpg') }}" class="avaChat">
                                            @endif
                                        </div>
                                        <div>
                                            <h5>{{ $ur->user->surname }} {{ $ur->user->name }}</h5>
                                            {{-- <p class="text-muted">
                                                8 дос бірге
                                            </p> --}}
                                        </div>
                                    </div>
                                    <div class="action">
                                        <form class="Accept" action="{{ route('accept_update', $ur->user_id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Қабылдау</button>
                                        </form>
                                        <form class="Decline" action="{{ route('decline_update', $ur->user_id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Қабылдамау</button>
                                        </form>
                                    </div>
                                </div>
                                @php
                                    $k++;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    @if ($k == 0)
                        <div class="request">
                            <p class="text-muted ml-3">Сұраныс жоқ</p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- END OF RIGHT --}}
        </div>
    </main>
    <script src="{{ asset('js/index.js') }}"></script>
    <style>
        .action {
            gap: 0.5rem !important;
        }

        @media screen and (max-width: 992px) {
            main .container .right {
                /* display: contents !important; */
            }
        }
    </style>
</body>

</html>
