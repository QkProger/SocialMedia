@extends('layouts.main')
@section('content')
    <div class="right">
        <div class="friendsBlock">
            <div class="messages">
                <div class="heading">
                    <h4>Достар</h4>
                    <button class="btn btn-primary group-btn" onclick="openGroupModal()">Группа ашу</button>
                </div>
                <div id="overlay" onclick="closeGroupModal()"></div>
                <div class="create-container" id="groupModal-container">
                    <div id="groupModal">
                        <span class="close-btn" onclick="closeGroupModal()">✖</span>
                        <h2>Группа ашу</h2>
                        <form action="{{ route('group.store') }}" method="post" enctype="multipart/form-data"
                            id="group">
                            @csrf
                            <div class="row">
                                <div class="col-75">
                                    <input type="text" id="name" name="name" placeholder="Аты..">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-75">
                                    <textarea id="description" name="description" placeholder="Сипаттамасы.." style="height:200px"></textarea>
                                </div>
                            </div>

                            <div class="middle">
                                <div class="d-b">
                                    <div class="filter-friend">
                                        <div class="messages modal-messages">
                                            <h3 class="friend-title">Достар</h3>
                                            <div class="user-list">
                                                @foreach ($friends as $friend)
                                                    @php
                                                        $friendUser = $friend->user2;
                                                    @endphp
                                                    <div class="user-wrapper">
                                                        <input type="checkbox" name="selectedUsers[]"
                                                            value="{{ $friendUser->id }}" id="friend-{{ $friendUser->id }}"
                                                            style="display: none">
                                                        <label for="friend-{{ $friendUser->id }}" class="user-link w-100">
                                                            <div class="message align-items-center">
                                                                <div class="profile-photo">
                                                                    @if ($friendUser->avatar)
                                                                        <img src="/storage/{{ $friendUser->avatar }}"
                                                                            class="avaChat">
                                                                    @else
                                                                        <img src="{{ asset('images/profile-1.jpg') }}"
                                                                            class="avaChat">
                                                                    @endif
                                                                    {{-- <div class="active"></div> --}}
                                                                </div>
                                                                <div class="message-body">
                                                                    <h5>{{ $friendUser->name }}
                                                                        {{ $friendUser->surname }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="filter-friend">
                                        <div class="messages modal-messages">
                                            <h3 class="friend-title">Ғаламдық іздеу</h3>
                                            <div class="user-list">
                                                @foreach ($otherUsers as $otherUser)
                                                    <div class="user-wrapper">
                                                        <input type="checkbox" name="selectedUsers[]"
                                                            value="{{ $otherUser->id }}" id="otherUser-{{ $otherUser->id }}"
                                                            style="display: none">
                                                        <label for="otherUser-{{ $otherUser->id }}"
                                                            class="user-link w-100">
                                                            <div class="message">
                                                                <div class="profile-photo">
                                                                    @if ($otherUser->avatar)
                                                                        <img src="/storage/{{ $otherUser->avatar }}"
                                                                            class="avaChat">
                                                                    @else
                                                                        <img src="{{ asset('images/profile-1.jpg') }}"
                                                                            class="avaChat">
                                                                    @endif
                                                                    {{-- <div class="active"></div> --}}
                                                                </div>
                                                                <div class="message-body">
                                                                    <h5>{{ $otherUser->name }}
                                                                        {{ $otherUser->surname }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="image">Суреті</label>
                                </div>
                                <div class="col-75">
                                    <input type="file" id="image" name="image">
                                </div>
                            </div>
                            <div class="row">
                                <input type="submit" value="Ашу" onclick="saveGroup()">
                            </div>
                        </form>
                    </div>
                </div>
                {{-- SEARCH BAR --}}
                <div class="search-bar d-flex align-items-center">
                    <i class="uil uil-search"></i>
                    {{-- <input type="search" placeholder="Достарды іздеу..." id="message-search"> --}}
                    <form action="{{ route('chats.messanger') }}" method="GET">
                        <input type="search" name="query" placeholder="Достарды іздеу..." id="message-search">
                        <button type="submit" style="display: none;"></button>
                    </form>
                </div>
                {{-- MESSAGES CATEGORY --}}
                <div class="category">
                    <h6 class="active"></h6>
                </div>
                <div class="friendsList">
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
            {{-- END OF MESSAGES --}}
        </div>
    </div>
    <script>
        function openGroupModal() {
            document.querySelector('.left').style.zIndex = '0';
            document.querySelector('nav').style.zIndex = '0';

            document.getElementById('groupModal-container').style.display = 'block';
            document.getElementById('groupModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeGroupModal() {
            document.querySelector('.left').style.zIndex = 'auto';
            document.querySelector('nav').style.zIndex = 'auto';

            document.getElementById('groupModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function saveGroup() {
            event.preventDefault();
            document.getElementById('group').submit();
        }
    </script>
    <style>
        #groupModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 30px;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            max-height: 500px;
            overflow: scroll;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .right .messages .heading {
            justify-content: space-between;
        }

        .group-btn {
            right: 17px;
            /* position: absolute; */
        }

        .col-75 {
            width: 75%;
            margin: 0 auto;
        }

        .col-75 input[type="file"] {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
            margin-top: 9px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .modal-messages {
            max-height: 300px;
            overflow-y: scroll;
        }

        .create-container {
            display: none;
        }

        @media screen and (max-width: 992px) {
            .container {
                width: 80%;
            }

            .friend-requests {
                margin-top: 15px !important;
            }

            main .container {
                grid-template-columns: auto;
                gap: 0;
            }

            main .container .right {
                display: contents !important;
            }
        }

        @media screen and (max-width: 500px) {
            .container {
                width: 96% !important;
            }

            .friendsBlock {
                margin-right: 80px !important;
            }

            .friend-requests {
                margin-right: 80px !important;

            }
        }
    </style>
@endsection
