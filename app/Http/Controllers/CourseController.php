<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Services\FileService;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('id', 'desc')->get();
        return view('courses.index', compact('courses'));
    }

    public function downloadFile($id)
    {
        $course = Course::findOrFail($id);
        $filePath = public_path('storage/' . $course->file_name);
        $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);
        return response()->download($filePath);
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $data = [
            'title' => $request['title'],
        ];

        if ($request->hasFile('file_name')) {
            $course_file = $request->file('file_name');
            $file_name = FileService::saveFile($course_file, "/courses");
            $data['file_name'] = 'courses/' . $file_name;
        }
        Course::create($data);
        return redirect()->route('courses.index');
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
        $data = [
            'title' => $request['title'],
        ];

        $oldCourseFile = basename($course->file_name);
        if ($request->hasFile('file_name')) {
            $course_file = $request->file('file_name');
            $file_name = FileService::saveFile($course_file, "/courses", $oldCourseFile);
            $data['file_name'] = 'courses/' . $file_name;
        }
        $course->update($data);
        return redirect()->route('courses.index');
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
