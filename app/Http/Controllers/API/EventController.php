<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function show(Request $req) {
        $data = Event::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }

    public function add(Request $req) {
        $req->validate([
            'name' => 'required|string|max:255',
        ]);

        Event::create([
            'name' => $req->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Event added successfully',
        ], 200);
    }

    public function edit(Request $req) {
        $data = Event::findOrFail($req->id);

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }

    public function update(Request $req) {
        $req->validate([
            'id'   => 'required|exists:events,id',
            'name' => 'required|string|max:255',
        ]);

        Event::findOrFail($req->id)->update([
            'name' => $req->name,
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Event updated successfully',
        ], 200);
    }

    public function delete(Request $req) {
        Event::findOrFail($req->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Event deleted successfully',
        ], 200);
    }

    public function search(Request $req) {
        if ($req->option == 0 || $req->option == 1) {
            $data = Event::where('name', 'like', '%' . $req->search . '%')->get();
        } else {
            $data = Event::orderBy('id', 'desc')->get(); // fallback if unknown option
        }

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }
}
