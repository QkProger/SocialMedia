@extends('layouts.main')
@section('content')
    <div class="middle">
        <div class="create-container">
            <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-25">
                        <label for="title">Тақырыпша</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="title" name="title" placeholder="Тақырыпша.." required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="content">#херштег</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="content" name="content" placeholder="#херштег..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="image">Суреті</label>
                    </div>
                    <div class="col-75">
                        <input type="file" id="image" name="image" required>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-25">
                        <label for="video">Бейнесі</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="video" name="video" placeholder="Бейнесі..">
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-25">
                        <label for="description">Сипаттамасы</label>
                    </div>
                    <div class="col-75">
                        <textarea id="description" name="description" placeholder="Сипаттамасы.." style="height:200px" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <input type="submit" value="Жіберу">
                </div>
            </form>
        </div>
    </div>
@endsection
