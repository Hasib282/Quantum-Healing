<?php

namespace App\Http\Controllers\Api\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Event_User_List;
use App\Models\User_Info;

class EventUserController extends Controller
{
    // Show All Event User Lists
    public function Show(Request $req){
        $data = Event::with('users')->where('all', 0)->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Edit Event User List
    public function Edit(Request $req){
        $data = Event_User_List::with('participants')
        ->where('event_id', $req->id)
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data
        ], 200); 
    } // End Method




    // Update Event User Lists
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
            'message' => 'Event User List Added Successfully',
            "updatedData" => $updatedData,
        ], 200);
    } // End Method



    // Get Event User Lists
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



    // Upload Data from excel file to Database
    public function UploadData(Request $req){
        $req->validate([
            'events' => 'required|exists:events,id',
            'file' => 'required|file|mimes:xlsx'
        ]);

        $filePath = $req->file('file')->getRealPath();
        $data = readXlsxRaw($filePath);
        $rows = array_slice($data, 1);

        // Get only reg_no values
        $regNos = collect($rows)->pluck('1')->toArray();

        // Sync users for that event
        $event = Event::find($req->events);
        $event->users()->sync($regNos);

        // If you want updated event data with users
        $updatedData = Event::with('users')->findOrFail($req->events);

        return response()->json([
            'status' => true,
            'message' => 'Excel Data Uploded Successfully',
            "updatedData" => $updatedData,
        ], 200);
    } // End Method
}
