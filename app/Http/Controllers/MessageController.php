<?php

namespace App\Http\Controllers;

use App\Actions\Messages\StoreMessageAction;
use App\Actions\Messages\GetConversationAction;
use App\Http\Requests\MessageRequest;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function store(
        MessageRequest $request,
        StoreMessageAction $action
    ): JsonResponse {
        $messageData = $action->execute(
            $request->validated(),
            $request->user()
        );

        return response()->json($messageData);
    }

    public function show(
        int $friendId,
        GetConversationAction $action
    ): JsonResponse {
        $messages = $action->execute(
            auth()->id(),
            $friendId
        );

        return response()->json(['messages' => $messages]);
    }
}
