@extends('layouts.main')
@section('content')
    <div class="right">
        <div class="messages">
            <div class="heading">
                <h4>Достар</h4><i class="uil uil-edit"></i>
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
    </div>
@endsection
