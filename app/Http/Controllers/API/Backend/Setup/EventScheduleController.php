<?php

namespace App\Http\Controllers\Api\Backend\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Models\Event_Schedule;

class EventScheduleController extends Controller
{
    // Show All Event Schedules
    public function Show(Request $req){
        $data = Event_Schedule::with('event')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Event Schedules
    public function Insert(Request $req){
        $req->validate([
            "events" => 'required|exists:events,id',
        ]);

        $insert = Event_Schedule::create([
            "event_id" => $req->events,
            "date" => $req->date,
        ]);

        $data = Event_Schedule::on('mysql')->with('event')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Event_Schedule Added Successfully',
            "data" => $data,
        ], 200);
    } // End Method



    // Update Event Schedules
    public function Update(Request $req){
        $data = Event_Schedule::findOrFail($req->id);

        $req->validate([
            "events" => 'required|exists:events,id',
        ]);

        $update = $data->update([
            "event_id" => $req->events,
            "date" => $req->date,
        ]);

        $updatedData = Event_Schedule::with('event')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Event Schedule Updated successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Event Schedules
    public function Delete(Request $req){
        Event_Schedule::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Event Schedule Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Event Schedules Status
    public function DeleteStatus(Request $req){
        $data = Event_Schedule::findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Event_Schedule::on('mysql')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Event Schedule Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Schedule Events
    public function Get(Request $req){
        $data = Event_Schedule::with('event')
        ->where('date', $req->search ?? date('Y-m-d'))
        ->get();

        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    } // End Method
    
    
    
    // Get Event Schedules Date
    public function GetDate(Request $req){
        $data = Event_Schedule::select('date')
        ->where('event_id', $req->search)
        ->distinct()
        ->get();

        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    } // End Method
}
