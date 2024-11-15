<?php

namespace App\Http\Controllers\Contracts\Booking;

use Illuminate\Http\JsonResponse;

interface DestroyBookingActionContract
{
    public function destroy($id): JsonResponse;
}
