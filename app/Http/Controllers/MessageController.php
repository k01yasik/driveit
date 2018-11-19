<?php

namespace App\Http\Controllers;

use App\Events\MessageSaved;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request) {

        $data = $request->validate([
            'username' => 'required|string',
            'friend_id' => 'required|integer',
            'message' => 'required|string'
        ]);

        $friend_id = $data['friend_id'];
        $message = clean($data['message']);
        $username = $data['username'];

        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $messageEntry = new Message;
        $messageEntry->user_id = $user->id;
        $messageEntry->text = $message;
        $messageEntry->friend_id = $friend_id;
        $messageEntry->save();

        broadcast(new MessageSaved($messageEntry));

        return [
            'username' => $username,
            'url' => route('user.profile', ['username' => $username]),
            'avatar' => $user->profile->avatar,
            'time' => $messageEntry->created_at,
            'text' => $messageEntry->text
        ];
    }
}
