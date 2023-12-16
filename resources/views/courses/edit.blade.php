@extends('layouts.main')
@section('content')
    <div class="middle">
        <div class="create-container">
            <form action="{{ route('courses.update', $course->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-25">
                        <label for="title">Аты</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="title" name="title" value="{{ $course->title }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="file_name">Курс файлы</label>
                    </div>
                    <div class="col-75">
                        <input type="file" id="file_name" name="file_name">
                        <h5>Қазір тұрған файл: {{ $course->file_name }}</р>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="description">Сипаттамасы</label>
                    </div>
                    <div class="col-75">
                        <textarea id="description" name="description" style="height:200px">
                            {{ $course->description }}
                        </textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="type">Типі</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="type" name="type" value="{{ $course->type }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="language">Тілі</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="language" name="language" value="{{ $course->language }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="price">Бағасы</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="price" name="price" value="{{ $course->price }}">
                    </div>
                </div>
                <div class="row">
                    <input type="submit" value="Өңдеу">
                </div>
            </form>
        </div>
    </div>
@endsection
