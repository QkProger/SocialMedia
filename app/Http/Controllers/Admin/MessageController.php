<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $message = Message::with(['user', 'user2'])->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));

        return Inertia::render('Admin/Message/Index', [
            'message' => $message,
        ]);
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->back()->withSuccess("Сәтті жойылды!");
    }
}
