<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Attendence;
use App\Models\Event_User_List;
use App\Models\Event;
use App\Models\User_Info;

class AttendanceController extends Controller
{
    // Show All Attendance
    public function Show(Request $req){
        $data = Attendence::get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method


     // Insert Attendance
    public function Insert(Request $req){
        $req->validate([
            'events' => 'required',
            'date' => 'required',
            'qr_url' => 'required'
        ]);

        $user = User_Info::select('id', 'name', 'reg_no','phone','gender','qr_url')
        ->where('qr_url', $req->qr_url)
        ->orWhere('reg_no', $req->qr_url)
        ->first();

        // if(!$user){

        //     return response()->json([
        //         'status'=> false,
        //         'message' => 'Your Attendance is already Given',
        //         "user" => $user
        //     ], 200);
        // }

        $attendence = Attendence::where('event_id',$req->events)->where('reg_no',$user->reg_no)->where('date',$req->date)->first();

        if($attendence){
            return response()->json([
                'status'=> false,
                'message' => 'Your Attendance is already Given',
                "user" => $user
            ], 200);
        }

        $event = Event::where('id', $req->events)->first();

        if($event->all == 1){
            $data = User_Info::where('qr_url', $req->qr_url)
            ->orWhere('reg_no', $req->qr_url)
            ->first();

            if ($data) {
                $insert = Attendence::create([
                    'event_id' => $req->events,
                    'date' => $req->date,
                    'reg_no' => $data->reg_no,
                ]);

                $data = Attendence::findOrFail($insert->id);
                
                return response()->json([
                    'status'=> true,
                    'message' => 'Your Attendance is Successfull',
                    "data" => $data,
                    "user" => $user
                ], 200);
            }
        }
        else if($event->all == 0){
            $data = Event_User_List::with('events','participants')
            ->where('event_id',$req->events)
            ->whereHas('participants',function($query) use ($req) {
                $query->where('qr_url', $req->qr_url);
                $query->orWhere('reg_no', $req->qr_url);
            })->first();

            if ($data) {
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
                    "user" => $user
                ], 200);
            }
        }
        

        return response()->json([
            'status'=> false,
            'message' => 'You are not allowed to enter',
            'user' => $user,
        ], 200);
    } // End Method



     // Update Attendance
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




     // Delete Attendance
    public function Delete(Request $req){
        Attendence::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Attendance Deleted Successfully',
        ], 200); 
    } // End Method
}
