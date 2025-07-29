<?php

namespace App\Http\Controllers\Api\Backend\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Models\Event;

class EventController extends Controller
{
    // Show All Events
    public function Show(Request $req){
        $data = Event::get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Events
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:events,name',
        ]);

        $insert = Event::create([
            "name" => $req->name,
            "all" => $req->all ? 1 : 0,
        ]);

        $data = Event::on('mysql')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Event Added Successfully',
            "data" => $data,
        ], 200);
    } // End Method



    // Update Events
    public function Update(Request $req){
        $data = Event::findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('events', 'name')->ignore($data->id)],
        ]);

        $update = $data->update([
            "name" => $req->name,
            "all" => $req->all ? 1 : 0,
        ]);

        $updatedData = Event::findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Event Updated successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Events
    public function Delete(Request $req){
        Event::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Event Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Events Status
    public function DeleteStatus(Request $req){
        $data = Event::findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Event::on('mysql')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Event Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Events
    public function Get(){
        $data = Event::on('mysql')
        ->orderBy('name')
        ->get();

        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    } // End Method
}
