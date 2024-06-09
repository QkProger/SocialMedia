<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
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
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('course_files', $fileName);
            $data['file_name'] = $fileName;
            $data['file_mime'] = $file->getMimeType();
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
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('course_files', $fileName);
            $data['file_name'] = $fileName;
            $data['file_mime'] = $file->getMimeType();
        }
        $material->update($data);
        return redirect()->route('admin.material.index')->withSuccess("Сәтті сақталды!");
    }

    public function destroy(Course $material)
    {
        $material->delete();
        return redirect()->back()->withSuccess("Сәтті жойылды!");
    }

    public function downloadFile(Request $request)
    {
        $filePath = $request->input('url');
        $filePath = storage_path('app/' . $filePath);
        return response()->download($filePath);
    }
}
