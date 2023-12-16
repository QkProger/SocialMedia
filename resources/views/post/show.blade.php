@extends('layouts.main')
@section('content')
    <div>
        <div> {{$post->id}}. {{ $post->title }} </div>
        <div> {{ $post->content }} </div>
    </div>
    <div>
        <a href="{{route('post.edit', $post->id)}}" class="btn btn-warning mt-2 mb-2">Edit</a>
    </div>
    <div>
        <form action="{{route('post.delete', $post->id)}}" method="post">
            @csrf
            @method('delete')
            <input type="submit" value="Delete" class="btn btn-danger mt-2 mb-2">
        </form>
    </div>
    <div>
        <a href="{{route('post.index')}}" class="btn btn-danger mt-2">Back</a>
    </div>
@endsection
