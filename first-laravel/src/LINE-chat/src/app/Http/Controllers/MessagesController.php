<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;

use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        return view('chatify.index'); // チャット画面のビューを返す
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $message = [
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ];
        

        // Pusher にイベントを発火
        broadcast(new MessageSent($message))->toOthers();

        // メッセージデータを返す
        return response()->json($message);
    }
    
}
