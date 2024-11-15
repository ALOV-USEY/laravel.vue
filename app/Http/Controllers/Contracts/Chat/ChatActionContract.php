<?php

namespace App\Http\Controllers\Contracts\Chat;

use Illuminate\Http\JsonResponse;

interface ChatActionContract
{
    public function __invoke();
}
