@extends('layouts.main')
@section('content')
    <div>
        <div> {{$course->id}}. {{ $course->title }} </div>
        <div> {{ $course->description }} </div>
    </div>
    <div>
        <a href="{{route('courses.edit', $course->id)}}" class="btn btn-warning mt-2 mb-2">Edit</a>
    </div>
    <div>
        <form action="{{route('courses.delete', $course->id)}}" method="post">
            @csrf
            @method('delete')
            <input type="submit" value="Delete" class="btn btn-danger mt-2 mb-2">
        </form>
    </div>
    <div>
        <a href="{{route('courses.index')}}" class="btn btn-danger mt-2">Back</a>
    </div>
@endsection
