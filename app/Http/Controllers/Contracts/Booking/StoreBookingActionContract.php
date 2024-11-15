<?php

namespace App\Http\Controllers\Contracts\Booking;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface StoreBookingActionContract
{
    public function store(Request $request): JsonResponse;
}
