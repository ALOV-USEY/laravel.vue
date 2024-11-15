<?php

namespace App\Http\Controllers\Actions\Booking;

use App\Http\Controllers\Contracts\Booking\DestroyBookingActionContract;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;

class DestroyBookingAction implements DestroyBookingActionContract
{
    public function destroy($id): JsonResponse
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }
}
