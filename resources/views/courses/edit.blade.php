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
                    <input type="submit" value="Өңдеу">
                </div>
            </form>
        </div>
    </div>
@endsection
