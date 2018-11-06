<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request) {

        $data = $request->validate([
            'username' => 'required|string',
            'friend_id' => 'required|integer',
            'message' => 'required|string'
        ]);

        $friend_id = $data['friend_id'];
        $message = $data['message'];

        $messageEntry = new Message;
        $messageEntry->user_id = Auth::id();
        $messageEntry->text = $message;
        $messageEntry->friend_id = $friend_id;
        $messageEntry->save();

        return 'ok';
    }
}
