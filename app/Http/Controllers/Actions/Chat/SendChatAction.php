<?php

namespace App\Http\Controllers\Actions\Chat;

use App\Http\Controllers\Contracts\Chat\SendChatActionContract;
use App\Events\MessageSent;
use App\Http\Requests\MessageFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class SendChatAction implements SendChatActionContract
{
    protected $request;

    public function __construct(MessageFormRequest $request)
    {
        $this->request = $request;
    }

    public function __invoke()
    {
        $user = $this->request->user();
        
        if (!$user) {
            return response()->json(['message' => 'Пользователь не авторизован'], 401);
        }

        $message = $user->messages()->create($this->request->validated());

        if (!$message) {
            return response()->json(['message' => 'Не удалось сохранить сообщение'], 500);
        }

        broadcast(new MessageSent($user, $message));

        return $message;
    }
}
