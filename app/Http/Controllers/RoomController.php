<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return response()->json(['rooms' => $rooms], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'hotel_id' => 'required|exists:hotels,id',
            'category_id' => 'required|exists:categories,id',
            'number' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $room = Room::create($request->all());

        return response()->json(['room' => $room], 201);
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return response()->json(['room' => $room], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'hotel_id' => 'exists:hotels,id',
            'category_id' => 'exists:categories,id',
            'number' => 'string',
            'price' => 'numeric|min:0',
        ]);

        $room = Room::findOrFail($id);
        $room->update($request->all());

        return response()->json(['room' => $room], 200);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(['message' => 'Room deleted successfully'], 200);
    }
}
