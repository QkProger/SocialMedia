<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('created_at', 'desc')->get();
        return view('courses.index', compact('courses'));
    }

    public function downloadFile($id)
    {
        $course = Course::findOrFail($id);

        $filePath = storage_path('app/course_files/' . $course->file_name);

        return response()->download($filePath, $course->file_name, [
            'Content-Type' => $course->file_mime,
        ]);
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        try {
            $data = request()->validate([
                'title' => 'string',
                'description' => 'string',
                'type' => 'string',
                'file_name' => 'file|max:102400', // Валидация файла
                'language' => 'string',
                'price' => 'int',
            ]);

            // Создаем курс
            $course = Course::create($data);

            // Если загружен файл
            if ($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $fileName = $file->getClientOriginalName();
                $file->storeAs('course_files', $fileName);

                // Обновляем модель Course с информацией о файле
                $course->update([
                    'file_name' => $fileName,
                    'file_mime' => $file->getMimeType(),
                ]);
            }

            // Возвращаемся на страницу со списком курсов
            return redirect()->route('courses.index')->with('success', 'Курс успешно создан.');
        } catch (\Exception $e) {
            // Обработка ошибок
            return redirect()->back()->withInput()->withErrors(['error' => 'Произошла ошибка при сохранении файла.']);
        }
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {        
        try {
            $data = request()->validate([
                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'type' => 'nullable|string',
                'file_name' => 'file|max:102400',
                'language' => 'nullable|string',
                'price' => 'nullable|int',
            ]);

            // Если загружен новый файл, обновляем информацию о файле
            if ($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $fileName = $file->getClientOriginalName();
                $file->storeAs('course_files', $fileName);

                // Удаляем старый файл, если он существует
                if ($course->file_name) {
                    Storage::delete('course_files/' . $course->file_name);
                }

                // Обновляем модель Course с информацией о новом файле
                $data['file_name'] = $fileName;
                $data['file_mime'] = $file->getMimeType();
            }

            $course->update($data);

            return redirect()->route('courses.index');

        } catch (\Exception $e) {
            dd($e->getMessage());
            // Обработка ошибок
            return redirect()->back()->withInput()->withErrors(['error' => 'Произошла ошибка при обновлении курса.']);
        }
    }

    public function destroy(Course $course)
    {
        $course->delete();
        if ($course->file_name) {
            Storage::delete('course_files/' . $course->file_name);
        }
        return redirect()->route('courses.index');
    }
}
