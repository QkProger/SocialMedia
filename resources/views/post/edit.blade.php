@extends('layouts.main')
@section('content')
    <div class="middle">
        <div class="create-container">
            <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-25">
                        <label for="title">Тақырыпша</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="title" name="title" value="{{ $post->title }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="content">#херштег</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="content" name="content" value="{{ $post->content }}"
                            placeholder="#херштег..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="image">Суреті</label>
                    </div>
                    <div class="col-75">
                        @if ($post->image)
                            <input type="file" id="image" name="image">
                        @else
                            <input type="file" id="image" name="image" required>
                        @endif
                        <img src="/storage/{{ $post->image }}">
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-25">
                        <label for="video">Бейнесі</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="video" name="video" value="{{ $post->video }}">
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-25">
                        <label for="description">Сипаттамасы</label>
                    </div>
                    <div class="col-75">
                        <textarea id="description" name="description" style="height:200px" required>
                            {{ $post->description }}
                        </textarea>
                    </div>
                </div>
                <div class="row">
                    <input type="submit" value="Өңдеу">
                </div>
            </form>
        </div>
    </div>
@endsection
