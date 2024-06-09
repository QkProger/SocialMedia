<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GruppaMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupMessageController extends Controller
{
    public function index(Request $request)
    {
        $group_message = GruppaMessage::with(['user', 'group'])->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));

        return Inertia::render('Admin/GroupMessage/Index', [
            'group_message' => $group_message,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/GroupMessage/Create');
    }

    public function store(Request $request)
    {

        $data['user_id'] = auth()->id();
        $data['gruppa_id'] = 1;

        if ($request->hasFile('file')) {
            $request->validate([
                'message' => 'nullable|string',
                'file_name' => 'sometimes|file|max:102400',
            ]);
            if ($request->message) {
                $data['message'] = $request->message;
            } else {
                $data['message'] = '';
            }
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('group_chat_files', $fileName);

            $data['file_name'] = $fileName;
        } else {
            $request->validate([
                'message' => 'sometimes|string',
            ]);
            $data['message'] = $request->message;
            $data['file_name'] = '';
        }

        GruppaMessage::create($data);
        return redirect()->route('admin.group_message.index')->withSuccess("Хабарлама қосылды!");
    }

    public function destroy(GruppaMessage $group_message)
    {
        $group_message->delete();
        return redirect()->back()->withSuccess("Сәтті жойылды!");
    }
    
    public function downloadFile(Request $request)
    {
        $filePath = $request->input('url');
        $filePath = storage_path('app/' . $filePath);
        return response()->download($filePath);
    }
}
