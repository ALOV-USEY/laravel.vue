<?php

namespace App\Http\Controllers\Contracts\Booking;

use Illuminate\Http\JsonResponse;

interface IndexBookingActionContract
{
    public function index(): JsonResponse;
}
