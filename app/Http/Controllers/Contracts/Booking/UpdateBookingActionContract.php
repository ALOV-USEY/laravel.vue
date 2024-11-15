<?php

namespace App\Http\Controllers\Contracts\Booking;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UpdateBookingActionContract
{
    public function update(Request $request, $id): JsonResponse;
}
