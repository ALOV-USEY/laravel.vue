<?php

namespace App\Http\Controllers\Actions\Booking;

use App\Http\Controllers\Contracts\Booking\UpdateBookingActionContract;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateBookingAction implements UpdateBookingActionContract
{
    public function update(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'user_id' => 'exists:users,id',
            'room_id' => 'exists:rooms,id',
            'check_in' => 'date',
            'check_out' => 'date|after:check_in',
            'guests' => 'integer|min:1',
            'total_price' => 'numeric|min:0',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return response()->json(['booking' => $booking], 200);
    }
}
