@extends('layouts.main')
@section('content')
    <div class="middle forrow">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="/storage/{{ $user->avatar }}" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h3>{{ $user->nickname }}</h3>
                                <p class="text-muted mb-1">{{ $user->mamandyq }}</p>
                                <p class="text-muted font-size-sm mb-3">{{ $user->oblys }}, {{ $user->qala }}</p>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
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
                        <hr>
                        <div class="row">
                            <a href="{{ route('user.edit', $user->id) }}" class="mt-2 mb-2"><button
                                    class="btn btn-primary">Өңдеу</button></a>

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
                                <img src="/storage/{{ $user->avatar }}" class="avaChat">
                            </div>
                            <div class="info">
                                @if (Auth::user())
                                    <h3>{{ Auth::user()->name }} {{ Auth::user()->surname }}</h3>
                                @else
                                    <h3>Guest Guest</h3>
                                @endif
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
                        <a href="{{ route('post.edit', $post->id) }}"><button
                                class="btn btn-success mt-2 mb-2">Өңдеу</button></a>
                        <form action="{{ route('post.delete', $post->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Жою" class="btn btn-danger mt-2 mb-2">
                        </form>
                        <span class="edit">
                            <i class="uil uil-ellipsis-h" id="post-popup-triggerr"></i>
                            <div class="post-popup" id="post-action-popupp">
                                <a href="{{ route('post.edit', $post->id) }}"><button
                                        class="btn btn-success mt-2 mb-2">Өңдеу</button></a>
                                <form action="{{ route('post.delete', $post->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Жою" class="btn btn-danger mt-2 mb-2">
                                </form>
                            </div>
                        </span>
                    </div>
                    <div class="photo">
                        <img src="/storage/{{ $post->image }}">
                    </div>
                    {{-- <div class="action-buttons">
                        <div class="interaction-buttons">
                            <span><i class="uil uil-heart"></i></span>
                            <span><i class="uil uil-comment-dots"></i></span>
                            <span><i class="uil uil-share-alt"></i></span>
                        </div>
                        <div class="bookmarks">
                            <span><i class="uil uil-bookmark-full"></i></span>
                        </div>
                    </div> --}}
                    {{-- <div class="liked-by">
                        <span>
                            <img src="{{ asset('images/profile-1.jpg') }}">
                        </span>
                        <span>
                            <img src="{{ asset('images/profile-1.jpg') }}">
                        </span>
                        <span>
                            <img src="{{ asset('images/profile-1.jpg') }}">
                        </span>
                        <p>Liked by <b>Ernest Achiever</b> and <b>2,323 others</b></p>
                    </div> --}}
                    <div class="caption">
                        <p>
                            @if (Auth::user())
                                <b>{{ Auth::user()->name }} {{ Auth::user()->surname }}</b> {{ $post->description }}
                            @else
                                guest
                            @endif
                            @if ($post->content)
                                <span class="harsh-tag">#{{ $post->content }}</span>
                            @endif
                        </p>
                    </div>
                    {{-- <div class="comments text-muted">View all 277 comments</div> --}}
                </div>
            @endforeach
            {{-- END OF FEED --}}
        </div>
        {{-- END OF FEEDS --}}
    </div>
@endsection
