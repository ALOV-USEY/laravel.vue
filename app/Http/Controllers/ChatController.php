<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function messages()
    {
        $messages = Message::with('user')->get();
        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:255',
        ]);
    
        $message = Message::create([
            'user_id' => $validated['user_id'],
            'message' => $validated['message'],
        ]);

        broadcast(new MessageSent($message->user, $message));

        return response()->json($message, 201);
    }
    
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }
}
