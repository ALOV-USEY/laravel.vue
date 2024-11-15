<?php

namespace App\Http\Controllers\Actions\Chat;

use App\Http\Controllers\Contracts\Chat\IndexChatActionContract;
use Illuminate\Http\JsonResponse;

class IndexChatAction implements IndexChatActionContract
{
    public function __invoke(): array
    {
        return ['status' => 'success'];
    }
}
