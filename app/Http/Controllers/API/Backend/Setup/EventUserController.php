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
        $data = Event::with('eventparticipants')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Branchs
    public function Insert(Request $req){
        $req->validate([
            'events' => 'required|exists:events,id',
            'all_participants' => 'required'
        ]);
        
        $participants = json_decode($req->all_participants, true);

        foreach ($participants as $p){
            $insert = Event_User_List::create([
                'event_id' => $req->events,
                'reg_no' => $p['reg_no']
            ]);
        }

        

        // $data = Event_User_List::findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Branch Added Successfully',
            // "data" => $data,
        ], 200);
    } // End Method



    // Update Branchs
    public function Update(Request $req){
        $data = Event_User_List::findOrFail($req->id);

        $req->validate([
            'branch' => 'required|string|max:255',
            'short' => 'required|string|max:100'
        ]);

        $update = $data->update([
            'branch' => $req->branch,
            'short' => $req->short
        ]);

        $updatedData = Branch::findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Branch Updated successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
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
        $data = Event_User_List::on('mysql')
        ->where('event_id', $req->id)
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data
        ], 200);

        // return $list;
    } // End Method
}
