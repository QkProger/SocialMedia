@extends('layouts.main')
@section('content')
    {{-- MIDDLE --}}
    <div class="middle">
        <style>
            .course-table {
                border-radius: var(--border-radius);
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th,
            table td {
                border: 1px solid #ccc;
                padding: 8px;
                background-color: var(--color-white);
                color: var(--color-dark);
            }

            table th {
                background: var(--color-light);
                text-align: left;
                color: var(--color-gray);
            }
        </style>

        <div class="label mb-15">
            Материалдар
        </div>
        <div class="files">
            @foreach ($courses as $course)
                <a href="{{ route('courses.download', ['id' => $course->id]) }}">
                    <div class="file mb-10 d-f j-b a-c c-p mb-2">
                        <div class="d-f a-c">
                            <div class="file_name d-f gap-10">
                                <img src="{{ asset('images/svg/file_ico.svg') }}" class="file_svg">
                                {{ $course->title }}
                            </div>
                        </div>
                        <p class="download">
                            Жүктеп алу
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
        @if (Auth::user()->admin)
            <div>
                <a href="{{ route('courses.create') }}">
                    <label for="create-post" class="btn btn-primary mt-1">Жаңа материал салу</label>
                </a>
            </div>
        @endif
    </div>
    {{-- END OF MIDDLE --}}
@endsection
<style>
    .files {
        max-height: 460px;
        overflow: auto;
        padding-right: 5px;
    }

    .files::-webkit-scrollbar {
        width: 8px;
    }

    .files::-webkit-scrollbar-thumb {
        background-color: var(--color-primary);
        border-radius: 20px;
    }


    .label {
        font-size: 20px;
        font-weight: 600;
        line-height: 29px;
        letter-spacing: 0em;
    }

    .file {
        border-radius: 15px;
        background: #fff;
        height: 50px;
        padding: 0 15px 0 20px;

    }

    .file:hover {
        text-decoration: underline;
    }

    .file_name {
        font-size: 16px;
        font-weight: 600;
        line-height: 23px;
        letter-spacing: 0em;
    }

    .download {
        font-size: 16px;
        font-weight: 600;
        line-height: 19px;
        letter-spacing: 0em;
        color: var(--color-black);
    }
</style>
