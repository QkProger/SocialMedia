@extends('layouts.main')
@section('content')
    <div class="middle">
        <div class="create-container">
            <form action="{{route('courses.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-25">
                        <label for="title">Аты</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="title" name="title" placeholder="Аты..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="file_name">Курс файлы</label>
                    </div>
                    <div class="col-75">
                        <input type="file" id="file_name" name="file_name">
                    </div>
                </div>
                <div class="row">
                    <input type="submit" value="Жіберу">
                </div>
            </form>
        </div>
    </div>
@endsection
