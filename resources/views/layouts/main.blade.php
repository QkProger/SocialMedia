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
                    <input type="search" name="query" placeholder="Search users...">
                    <button type="submit"><i class="uil uil-search"></i></button>
                </div>
            </form>
            <div class="create">
                <a href="{{ route('home') }}">
                    <label for="create-post" class="btn btn-primary">Create</label>
                </a>
                <a href="{{ route('user.index') }}">
                    <div class="profile-photo">
                        @if (Auth::user())
                            <img src="{{ asset(Auth::user()->avatar) }}">
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}">    
                        @endif
                    </div>
                </a>
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
                                <img src="{{ asset(Auth::user()->avatar) }}">
                            </a>
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}">
                        @endif
                    </div>
                    <div class="handle">
                        @if (Auth::user())
                            <h4>{{ Auth::user()->name }} {{ Auth::user()->surname }}</h4>
                        @else
                            @if (Route::has('login'))
                                <h4><a href="{{ route('login') }}">{{ __('Login') }}</a></h4>
                            @endif
                            @if (Route::has('register'))
                                <h4><a href="{{ route('register') }}">{{ __('Register') }}</a></h4>
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
                        <h3>Home</h3>
                    </a>
                    {{-- <a class="menu-item">
                        <span><i class="uil uil-compass"></i></span>
                        <h3>Explore</h3>
                    </a> --}}
                    <a class="menu-item" id="notifications">
                        <span><i class="uil uil-bell"><small class="notification-count">9+</small></i></span>
                        <h3>Notifications</h3>
                        {{-- NOTIFICATION POPUP --}}
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
                        {{-- END NOTIFICATION POPUP --}}
                    </a>
                    <a href="{{ route('chats.messanger') }}"
                        class="menu-item {{ request()->routeIs('chats.messanger') ? 'active' : '' }}">
                        <span><i class="uil uil-envelope-alt"><small class="notification-count">6</small></i></span>
                        <h3>Достар</h3>
                    </a>
                    <a href="{{ route('chats.chat') }}" class="menu-item {{ request()->routeIs('chats.chat') ||  request()->is('chats/chat/*') ? 'active' : '' }}">
                        <span><i class="uil uil-facebook-messenger-alt"></i></span>
                        <h3>Жалпы чат</h3>
                    </a>
                    <a href="{{ route('user.bookmarks') }}" class="menu-item {{ request()->routeIs('user.bookmarks') ? 'active' : '' }}">
                        <span><i class="uil uil-bookmark"></i></span>
                        <h3>Bookmarks</h3>
                    </a>
                    <a href="{{ route('courses.index') }}" class="menu-item {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                        <span><i class="uil uil-book-open"></i></span>
                        <h3>Курстар</h3>
                    </a>
                    <a href="#" class="menu-item">
                        <span><i class="uil uil-book-open"></i></span>
                        <h3>Жобалар</h3>
                    </a>
                    <a href="#" class="menu-item">
                        <span><i class="uil uil-book-open"></i></span>
                        <h3>Ғылыми жобалар</h3>
                    </a>
                    <a href="#" class="menu-item">
                        <span><i class="uil uil-book-open"></i></span>
                        <h3>Дипломдық жұмыстар</h3>
                    </a>
                    <a href="#" class="menu-item">
                        <span><i class="uil uil-book-open"></i></span>
                        <h3>Форум</h3>
                    </a>
                    <a class="menu-item" id="theme">
                        <span><i class="uil uil-palette"></i></span>
                        <h3>Theme</h3>
                    </a>
                    {{-- <a class="menu-item">
                        <span><i class="uil uil-setting"></i></span>
                        <h3>Settings</h3>
                    </a> --}}
                    @if (Route::currentRouteName() == 'user.index')
                        <a href="{{ route('logout') }}" class="menu-item"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <span><i class="uil uil-sign-out-alt"></i></span>
                            <h3>Logout</h3>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
                    Route::currentRouteName() == 'user.edit' ||
                    Route::currentRouteName() == 'chats.chat' ||
                    Route::currentRouteName() == 'chats.load-chat' ||
                    Route::currentRouteName() == 'user.usersList')
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
                            <input type="search" placeholder="Search messages" id="message-search">
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
                    <h4 style="margin-top: 0">Requests</h4>
                    @php
                        $k = 0;
                    @endphp
                    @if (Auth::user())
                        @foreach ($user_requests as $ur)
                            @if ($ur->is_waiting == 1 && $ur->receiver_user_id == Auth::user()->id && $ur->user_id != Auth::user()->id)
                                <div class="request">   
                                    <div class="info">
                                        <div class="profile-photo">
                                            <img src="{{ asset('images/profile-1.jpg') }}">
                                        </div>
                                        <div>
                                            <h5>{{ $ur->user->surname }} {{ $ur->user->name }}</h5>
                                            <p class="text-muted">
                                                8 mutual friends
                                            </p>
                                        </div>
                                    </div>
                                    <div class="action">
                                        <form class="Accept" action="{{ route('accept_update', $ur->user_id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Accept</button>
                                        </form>
                                        <form class="Decline" action="{{ route('decline_update', $ur->user_id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn">Decline</button>
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
                            <p class="text-muted ml-3">No Requests</p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- END OF RIGHT --}}
        </div>
    </main>

    {{-- THEME CUSTOMZTION --}}
    <div class="customize-theme">
        <div class="card">
            <h2>Customize your view</h2>
            <p class="text-muted">Manage your font size, color and background.</p>

            {{-- FONT SIZES --}}
            <div class="font-size">
                <h4>Font Size</h4>
                <div>
                    <h6>Aa</h6>
                    <div class="choose-size">
                        <span class="font-size-1"></span>
                        <span class="font-size-2"></span>
                        <span class="font-size-3 active"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                    <h3>Aa</h3>
                </div>
            </div>

            {{-- PRIMARY COLORS --}}
            <div class="color">
                <h4>Color</h4>
                <div class="choose-color">
                    <span class="color-1 active"></span>
                    <span class="color-2"></span>
                    <span class="color-3"></span>
                    <span class="color-4"></span>
                    <span class="color-5"></span>
                </div>
            </div>

            {{-- BACKGOUND COLORS --}}
            <div class="background">
                <h4>Background</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Light</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
                        <h5>Dark</h5>
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5 for="bg-3">Light Out</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>
