<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Attendence;
use App\Models\Event_User_List;

class AttendanceController extends Controller
{

    
    // Show All Attendance
    public function Show(Request $req){
        $data = Attendence::get();

        // $data = Event_User_List::with('events','participants')
        // ->where('event_id',$req->events)
        // ->whereHas('participants',function($query) use ($req) {
        //     $query->where('qr_url',$req->qr_url);
        //     $query->where('reg_no',$req->reg_no);
        // })->first();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method


     // Insert Branchs
    public function Insert(Request $req){

        // $data = Event_User_List::with('events','participants')
        // ->where('event_id',$req->events)
        // ->whereHas('participants',function($query) use ($req) {
        //     $query->where('qr_url',$req->qr_url);
        //     $query->orWhere('reg_no',$req->reg_no);
        // })->first();
        $data = Event_User_List::with('events','participants')
        ->where('event_id',$req->events)
        ->whereHas('participants',function($query) use ($req) {
            $query->where('qr_url','like','%'.$req->qr_url.'%');
            // $query->orWhere('reg_no',$req->reg_no);
        })->first();
// dd($data->participants->reg_no);  


    if ($data->count() > 0) {

        $req->validate([
            'events' => 'required',
            'date' => 'required',
            'qr_url' => 'required'
        ]);

        $insert = Attendence::create([
            'event_id' => $req->events,
            'date' => $req->date,
            'reg_no' => $data->participants->first()->reg_no,
        ]);

        $data = Attendence::findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Attendance Added Successfully',
            "data" => $data,
        ], 200);

    } else {

        
        return response()->json([
                'status'=> true,
                'message' => 'Attendence Unseccessful',
                "data" => $data,
        ], 200);

   
}
    } // End Method



     // Update Attendence
    public function Update(Request $req){
        $data = Attendence::findOrFail($req->id);

      

       $req->validate([
            'events' => 'required',
            'date' => 'required',
            'qr_url' => 'required'
        ]);
       

        $update = $data->update([
            'event_id' => $req->events,
            'date' => $req->date,
            'reg_no' => $data->reg_no,
        ]);

        $updatedData = Attendence::findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Attendence Updated successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method


    // Delete Branch Status
     // Delete Events
    public function Delete(Request $req){
        Attendence::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Attendance Deleted Successfully',
        ], 200); 
    } // End Method


  



}
