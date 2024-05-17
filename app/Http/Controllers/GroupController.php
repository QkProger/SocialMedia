<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gruppa;
use App\Models\GruppaMessage;
use App\Models\GruppaUser;
use App\Models\Message;
use App\Models\User;
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
            'selectedUsers' => 'required|array',
        ]);

        // Создание новой группы
        $group = new Gruppa();
        $group->name = $data['name'];
        $group->description = $data['description'];


        if ($request->hasFile('image')) {
            // Получаем загруженный файл
            $image = $request->file('image');

            // Генерируем уникальное имя для файла
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Сохраняем файл на сервер
            $image->storeAs('public/images', $imageName);

            // Сохраняем путь к файлу в базу данных
            $data['image'] = 'storage/images/' . $imageName;
            $group->image = $data['image'];
        }

        $group->save();

        // Связывание выбранных пользователей с созданной группой
        $me = auth()->id();
        GruppaUser::create([
            'gruppa_id' => $group->id,
            'user_id' => $me,
        ]);
        foreach ($request->input('selectedUsers') as $userId) {
            GruppaUser::create([
                'gruppa_id' => $group->id,
                'user_id' => $userId,
            ]);
        }

        // Дополнительные действия, редирект или что-то еще
        return redirect()->route('chats.messanger')->with('success', 'Группа успешно создана.');
    }

    public function create()
    {
        $groups = Gruppa::orderBy('created_at', 'desc')->get();
        $group = Gruppa::latest('id')->first();
        return view('groups.chat', compact('groups', 'group'));
    }

    public function loadChat($gruppaId)
    {
        $groupp = Gruppa::findOrFail($gruppaId);
        $userId = auth()->id();

        $messages = GruppaMessage::where('gruppa_id', $gruppaId)
            ->orderBy('created_at')
            ->get();

        $groups = GruppaUser::where('user_id', $userId)->with('groups')->first();
        return view('groups.chat', compact('messages', 'groupp', 'groups'));
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
            $file->storeAs('chat_files', $fileName);

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

        $filePath = storage_path('app/chat_files/' . $file->file_name);

        return response()->download($filePath, $file->file_name);
    }
}
