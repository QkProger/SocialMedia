<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $material = Course::paginate($request->input('per_page', 20))
            ->appends($request->except('page'));;

        return Inertia::render('Admin/Material/Index', [
            'material' => $material,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Material/Create');
    }

    public function store(Request $request)
    {
        $data = [
            'title' => $request['title'],
        ];

        if ($request->hasFile('file')) {
            $course_file = $request->file('file');
            $file_name = FileService::saveFile($course_file, "/courses");
            $data['file_name'] = 'courses/' . $file_name;
        }
        Course::create($data);
        return redirect()->route('admin.material.index')->withSuccess("Материал қосылды!");
    }

    public function edit(Course $material)
    {
        return Inertia::render('Admin/Material/Edit', [
            'material' => $material,
            'imageUrl' => asset($material->image),
        ]);
    }

    public function update(Request $request, Course $material)
    {
        $data = [
            'title' => $request['title'],
        ];
        
        $oldCourseFile = basename($material->file_name);
        if ($request->hasFile('file_name')) {
            $course_file = $request->file('file_name');
            $file_name = FileService::saveFile($course_file, "/courses", $oldCourseFile);
            $data['file_name'] = 'courses/' . $file_name;
        }
        $material->update($data);
        return redirect()->route('admin.material.index')->withSuccess("Сәтті сақталды!");
    }

    public function downloadFile(Request $request)
    {
        $filePath = $request->input('url');
        $pathToPublicFolder = public_path();
        $fileFullPath = $pathToPublicFolder . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $filePath;
        return response()->download($fileFullPath);
    }

    public function destroy(Course $material)
    {
        $baseName = basename($material->file_name);
        FileService::deleteFile($baseName, "/courses");
        $material->delete();
        return redirect()->back()->withSuccess('Сәтті жойылды!');
    }
}
