<?php

namespace App\Http\Controllers\Actions\Booking;

use App\Http\Controllers\Contracts\Booking\StoreBookingActionContract;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreBookingAction implements StoreBookingActionContract
{
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $booking = Booking::create($request->all());

        return response()->json(['booking' => $booking], 201);
    }
}
