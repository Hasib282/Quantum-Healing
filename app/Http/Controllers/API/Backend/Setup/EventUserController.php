<?php

namespace App\Http\Controllers\Api\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Event_User_List;
use App\Models\User_Info;

class EventUserController extends Controller
{
    // Show All Branchs
    public function Show(Request $req){
        $data = Event::with('users')->where('all', 0)->get();

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



    // Get Branchs
    public function Get(Request $req){
        $event = Event::where('id', $req->id)->first();
        if($event->all == 1){
            $data = User_Info::select('id', 'name', 'reg_no','phone','gender')
            ->get();
        }
        else if($event->all == 0){
            $data = Event_User_List::with('participants')
            ->where('event_id', $req->id)
            ->get();
        }
        

        return response()->json([
            'status'=> true,
            'data' => $data
        ], 200);
    } // End Method
}
