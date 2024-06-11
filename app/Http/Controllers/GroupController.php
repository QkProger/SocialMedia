<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gruppa;
use App\Models\GruppaMessage;
use App\Models\GruppaUser;
use App\Models\Message;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'image',
        ]);

        $group = new Gruppa();
        $group->name = $data['name'];
        $group->description = $data['description'];


        if ($request->hasFile('image')) {
            $group_ava = $request->file('image');
            $file_name = FileService::saveFile($group_ava, "/groupsAvatars");
            $data['image'] = 'groupsAvatars/' . $file_name;
            $group->image = $data['image'];
        }

        $group->save();

        $me = auth()->id();
        GruppaUser::create([
            'gruppa_id' => $group->id,
            'user_id' => $me,
            'is_admin' => 1,
        ]);

        if ($request->input('selectedUsers')) {
            foreach ($request->input('selectedUsers') as $userId) {
                GruppaUser::create([
                    'gruppa_id' => $group->id,
                    'user_id' => $userId,
                ]);
            }
        }

        return redirect()->route('chats.messanger');
    }

    public function create()
    {
        $groups = Gruppa::orderBy('id', 'desc')->get();
        $group = Gruppa::latest('id')->first();
        return view('groups.chat', compact('groups', 'group'));
    }

    public function loadChat($gruppaId)
    {
        $groupp = Gruppa::findOrFail($gruppaId);
        $userId = auth()->id();

        $messages = GruppaMessage::where('gruppa_id', $gruppaId)
            ->orderBy('id')
            ->get();

        foreach ($messages as $message) {
            $message->svg = $message->getSvgIcon();
            $message->extension = strtolower(pathinfo($message->file_name, PATHINFO_EXTENSION));
        }
        $groups = GruppaUser::where('user_id', $userId)
            ->with(['groups' => function ($query) {
                $query->orderBy('id', 'desc');
            }])->first();

        // $groups = User::with('userGroups.group')->find($userId);


        $users = User::whereDoesntHave('groups', function ($query) use ($gruppaId) {
            $query->where('gruppa_id', $gruppaId);
        })->get();
        $is_admin = GruppaUser::where('gruppa_id', $gruppaId)->where('user_id', $userId)->first()->is_admin;
        $group_users = GruppaUser::where('gruppa_id', $gruppaId)->with('user')->get();

        return view('groups.chat', compact(
            'messages',
            'groupp',
            'groups',
            'users',
            'is_admin',
            'group_users',
        ));
    }

    public function groupMessageStore(Request $request)
    {
        $data['user_id'] = auth()->id();
        $data['gruppa_id'] = $request->gruppa_id;

        if ($request->hasFile('file_name')) {
            $request->validate([
                'message' => 'nullable|string',
                'file_name' => 'sometimes|file|max:102400',
            ]);
            if ($request->message) {
                $data['message'] = $request->message;
            } else {
                $data['message'] = '';
            }
            $file = $request->file('file_name');
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
        // Создание новой записи в базе данных
        $messages = GruppaMessage::create($data);

        // Возвращение JSON-ответа
        return response()->json(['success' => 'Сообщение успешно отправлено!', 'message' => $messages]);
    }

    public function downloadFile($id)
    {
        $file = GruppaMessage::findOrFail($id);

        $filePath = storage_path('app/group_chat_files/' . $file->file_name);

        return response()->download($filePath, $file->file_name);
    }

    public function update(Request $request, $groupId)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'image',
        ]);

        $group = Gruppa::find($groupId);

        $oldGroupAva = basename($group->image);
        if ($request->hasFile('image')) {
            $group_ava = $request->file('image');
            $file_name = FileService::saveFile($group_ava, "/groupsAvatars", $oldGroupAva);
            $data['image'] = 'groupsAvatars/' . $file_name;
        }
        $data['status'] = !$request->status ? 0 : 1;
        $group->update($data);
        if ($request->input('selectedUsers')) {
            foreach ($request->input('selectedUsers') as $userId) {
                GruppaUser::create([
                    'gruppa_id' => $group->id,
                    'user_id' => $userId,
                ]);
            }
        }
        if ($request->input('toDeleteSelectedGroupUsers')) {
            foreach ($request->input('toDeleteSelectedGroupUsers') as $userId) {
                GruppaUser::where('gruppa_id', $group->id)->where('user_id', $userId)->delete();
            }
        }
        if ($request->input('toAdminSelectedGroupUsers')) {
            foreach ($request->input('toAdminSelectedGroupUsers') as $userId) {
                GruppaUser::where('gruppa_id', $group->id)->where('user_id', $userId)->update([
                    'is_admin' => 1,
                ]);
            }
        }

        return redirect()->back();
    }
}
