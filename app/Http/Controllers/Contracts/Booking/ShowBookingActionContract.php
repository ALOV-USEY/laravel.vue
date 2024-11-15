<?php

namespace App\Http\Controllers\Contracts\Booking;

use Illuminate\Http\JsonResponse;

interface ShowBookingActionContract
{
    public function show($id): JsonResponse;
}
