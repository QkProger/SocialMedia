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

        <div>
            <h1 class="mb-3">Курстар</h1>
            <table class="course-table">
                <thead>
                    <tr>
                        <th>Аты</th>
                        <th>Курс</th>
                        <th>Сипаттамасы</th>
                        <th>Тип</th>
                        <th>Тілі</th>
                        <th>Бағасы</th>
                        <th>Өңдеу</th>
                        <th>Жою</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->title }}</td>
                            <td>
                                @if ($course->file_name)
                                    <a href="{{ route('courses.download', ['id' => $course->id]) }}">{{ $course->file_name }}</a>
                                @endif
                            </td>
                            <td>{{ $course->description }}</td>
                            <td>{{ $course->type }}</td>
                            <td>{{ $course->language }}</td>
                            <td>{{ $course->price }} тг</td>
                            <td>
                                <a href="{{ route('courses.edit', $course->id) }}" class="menu-item">
                                    <button class="btn"><i class="uil uil-edit"></i></button>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('courses.delete', $course->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('courses.create') }}">
                <label for="create-post" class="btn btn-primary mt-3">Жаңа курс салу</label>
            </a>
        </div>
    </div>
    {{-- END OF MIDDLE --}}
@endsection
