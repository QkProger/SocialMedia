@extends('layouts.main')
@section('content')
    {{-- MIDDLE --}}
    <div class="middle">
        {{-- FEEDS --}}
        <div class="feeds">
            {{-- FEED 1 --}}
            @foreach ($bookmarkedPosts->bookmarks as $bookmark)
                <div class="feed">
                    <div class="head">
                        <div class="user">
                            <a href="{{ route('user.profile', $bookmark->post->user->id) }}" class="profile-photo">
                                <img src="{{ asset($bookmark->post->user->avatar) }}">
                            </a>
                            <div class="info">
                                <h3>{{ $bookmark->post->user->name }} {{ $bookmark->post->user->surname }}</h3>
                                <small>
                                    @php
                                        $publishedDate = Carbon\Carbon::parse($bookmark->post->published_at);
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
                        <span class="edit">
                            <i class="uil uil-ellipsis-h"></i>
                        </span>
                    </div>
                    <div class="photo">
                        <img src="{{ asset($bookmark->post->image) }}">
                    </div>
                    <div class="action-buttons">
                        <div class="interaction-buttons d-f">
                            @php
                                $liked;
                            @endphp
                            <form class="likeSendForm">
                                <input type="hidden" value="{{ $bookmark->post->id }}" class="post_id">
                                @if (auth()->check() &&
                                        auth()->user()->hasLiked($bookmark->post->id))
                                    @php
                                        $liked = true;
                                    @endphp
                                    <button type="submit" class="no-btn liked"><i class="uil uil-heart"></i></button>
                                @else
                                    @php
                                        $liked = false;
                                    @endphp
                                    <button type="submit" class="no-btn"><i class="uil uil-heart"></i></button>
                                @endif
                            </form>
                            <span><i class="uil uil-comment-dots"></i></span>
                            <span><i class="uil uil-share-alt"></i></span>
                        </div>
                        <div class="bookmarks">
                            <span>
                                <form class="savePostForm">
                                    <input type="hidden" value="{{ $bookmark->post->id }}" class="post_id">
                                    @if (auth()->check() &&
                                            auth()->user()->hasSaved($bookmark->post->id))
                                        <button type="submit" class="no-btn SavedToNone">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="18" width="18"
                                                viewBox="0 0 384 512" style="transform: translateX(-5px)">
                                                <path
                                                    d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                                            </svg>
                                        </button>
                                        <button type="submit" class="no-btn noSave">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="18" width="18"
                                                viewBox="0 0 384 512" style="transform: translateX(-5px)">
                                                <path
                                                    d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z" />
                                            </svg>
                                        </button>
                                    @else
                                        <button type="submit" class="no-btn toNone">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="18" width="18"
                                                viewBox="0 0 384 512" style="transform: translateX(-5px)">
                                                <path
                                                    d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z" />
                                            </svg>
                                        </button>
                                        <button type="submit" class="no-btn saved">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="18" width="18"
                                                viewBox="0 0 384 512" style="transform: translateX(-5px)">
                                                <path
                                                    d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                                            </svg>
                                        </button>
                                    @endif
                                </form>

                            </span>
                        </div>
                    </div>
                    <div class="liked-by">
                        <p>Лүпіл басқандар
                            @php
                                $likedFriendCount = 0;
                                $likedOtherCount = 0;
                            @endphp
                            @if ($liked)
                                <b class="d-on">Сіз, </b>
                            @endif
                            @if ($likedFriends->count() > 0)
                                <b>
                                    @foreach ($likedFriends as $likedFriend)
                                        @php
                                            $friendUser = $likedFriend->user2;
                                        @endphp
                                        @if ($friendUser->hasLiked($bookmark->post->id))
                                            {{ $friendUser->name }} {{ $friendUser->surname }}
                                            @php
                                                $likedFriendCount++;
                                            @endphp
                                        @endif
                                        @if ($likedFriendCount == 3)
                                            @break;
                                        @endif
                                    @endforeach
                                </b> және
                            @endif
                            
                            @if ($likedOthers->count() > 0)
                                <b>
                                    @foreach ($likedOthers as $likedOther)
                                        @if ($likedOther->hasLiked($bookmark->post->id))
                                            @php
                                                $likedOtherCount++;
                                            @endphp
                                        @endif
                                    @endforeach
                            @endif
                        @php
                            $likedRestOtherCount = $likedOtherCount - $likedFriendCount;
                        @endphp
                        <b>{{ $likedRestOtherCount }}
                            @if ($likedRestOtherCount != $likedOtherCount)
                                басқалар
                            @else
                                адамдар 
                            @endif
                        </b>
                    </p>
                </div>
                <div class="caption">
                    <p>
                        <b>{{ $bookmark->post->user->name }} {{ $bookmark->post->user->surname }}</b> {{ $bookmark->post->description }}
                        {{-- <span class="harsh-tag">#lifestyle</span> --}}
                    </p>
                </div>
                <div class="comments text-muted">Барлық пікірді көру</div>
            </div>
        @endforeach
        {{-- END OF FEED --}}
    </div>
    {{-- END OF FEEDS --}}
</div>
{{-- END OF MIDDLE --}}
<script>
    const displayView = 'Сіз, ';
    $('.likeSendForm').on('submit', function(event) {
        event.preventDefault();
        var form = $(this);

        var formDataArray = $(this).serializeArray();
        formDataArray.push({
            name: 'post_id',
            value: form.find(".post_id").val()
        });

        // Add CSRF token
        formDataArray.push({
            name: '_token',
            value: "{{ csrf_token() }}"
        });

        var formData = $.param(formDataArray);
        $.ajax({
            url: "/sendLike",
            type: "POST",
            data: formData,
            success: function(response) {
                console.log('Успешный ответ сервера:', response);

                if (response.isLiked) {
                    form.find('.no-btn').addClass('liked');
                    $('.d-on').text(displayView);
                } else {
                    form.find('.no-btn').removeClass('liked');
                    $('.d-on').text('');
                }
            },
            error: function(xhr, status, error) {
                console.error('Ошибка при отправке AJAX:', xhr, status, error);
            },
        });
    });
</script>


<script>
    $('.savePostForm').on('submit', function(event) {
        event.preventDefault();
        var form = $(this);

        var formDataArray = $(this).serializeArray();
        formDataArray.push({
            name: 'post_id',
            value: form.find(".post_id").val()
        });

        // Add CSRF token
        formDataArray.push({
            name: '_token',
            value: "{{ csrf_token() }}"
        });

        var formData = $.param(formDataArray);
        $.ajax({
            url: "/savePost",
            type: "POST",
            data: formData,
            success: function(response) {
                console.log('Успешный ответ сервера:', response);

                var bookmarks = form.closest('.bookmarks');

                if (response.isSaved) {
                    form.find('.toNone').hide();
                    bookmarks.find('.saved').show();
                    bookmarks.find('.noSave').hide();
                    bookmarks.find('.SavedToNone').show();
                } else {
                    form.find('.toNone').show();
                    bookmarks.find('.saved').hide();
                    bookmarks.find('.noSave').show();
                    bookmarks.find('.SavedToNone').hide();
                }

            },
            error: function(xhr, status, error) {
                console.error('Ошибка при отправке AJAX:', xhr, status, error);
            },
        });
    });
</script>
@endsection
