<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return response()->json(['hotels' => $hotels], 200);
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }
        return response()->json(['hotel' => $hotel], 200);
    }

    public function store(Request $request)
    {
        if (session('is_admin') !== true) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->validate($request, [
            'name' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $hotel = Hotel::create([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json(['hotel' => $hotel], 201);
    }

    public function update(Request $request, $id)
    {
        if (session('is_admin') !== true) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        $this->validate($request, [
            'name' => 'string',
            'location' => 'string',
            'description' => 'string',
            'price' => 'numeric',
        ]);

        $hotel->update($request->all());

        return response()->json(['hotel' => $hotel], 200);
    }

    public function destroy($id)
    {
        if (session('is_admin') !== true) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $hotel = Hotel::find($id);
        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        $hotel->delete();

        return response()->json(['message' => 'Hotel deleted successfully'], 200);
    }

    public function getUniqueLocations()
    {
        $uniqueLocations = Hotel::distinct()->pluck('location');
        return response()->json(['uniqueLocations' => $uniqueLocations], 200);
    }
}
