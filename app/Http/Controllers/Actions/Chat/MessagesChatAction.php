<?php

namespace App\Http\Controllers\Actions\Chat;

use App\Http\Controllers\Contracts\Chat\MessagesChatActionContract;
use App\Models\Message;
use Illuminate\Http\JsonResponse;

class MessagesChatAction implements MessagesChatActionContract
{
    public function __invoke()
    {
        $messages = Message::query()->with('user')->get();
        return $messages;
    }
}
