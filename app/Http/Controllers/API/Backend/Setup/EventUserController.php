<?php

namespace App\Http\Controllers\Api\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Event_User_List;

class EventUserController extends Controller
{
    // Show All Branchs
    public function Show(Request $req){
        $data = Event::with('users')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Edit Branch
    public function Edit(Request $req){
        $data = Event_User_List::with('participants')
        ->where('event_id', $req->id)
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data
        ], 200); 
    } // End Method




    // Update Branchs
    public function Update(Request $req){
        $req->validate([
            'events' => 'required|exists:events,id',
            'all_participants' => 'required',
        ]);

        $participants = json_decode($req->all_participants, true);
        $event = Event::find($req->events);
        $regNos = collect($participants)->pluck('reg_no')->toArray();
        
        // This will remove old participants and add only the current ones
        $event->users()->sync($regNos);

        $updatedData = Event::with('users')->findOrFail($req->events);
        
        return response()->json([
            'status'=> true,
            'message' => 'Branch Added Successfully',
            "updatedData" => $updatedData,
        ], 200);
    } // End Method



    // Delete Branch
    public function Delete(Request $req){
        Event_User_List::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Branch Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Branch Status
    public function DeleteStatus(Request $req){
        $data = Event_User_List::findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Event_User_List::on('mysql')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Branch Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Branchs
    public function Get(Request $req){
        $data = Event_User_List::with('participants')
        ->where('event_id', $req->id)
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data
        ], 200);
    } // End Method
}
