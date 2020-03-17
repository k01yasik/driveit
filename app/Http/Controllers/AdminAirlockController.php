<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTokenRequest;
use App\Services\AirlockService;

class AdminAirlockController extends Controller
{
    protected $airlockService;

    public function __construct(AirlockService $airlockService)
    {
        $this->airlockService = $airlockService;
    }

    public function create(CreateTokenRequest $request)
    {
        $user_id = $request->validated()['id'];

        $this->airlockService->createTokenForUser($user_id);

        return redirect()->route('');
    }
}
