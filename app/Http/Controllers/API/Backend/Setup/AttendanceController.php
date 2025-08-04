<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Attendence;
use App\Models\Attendence_Temp;
use App\Models\Event_User_List;
use App\Models\Event;
use App\Models\User_Info;

class AttendanceController extends Controller
{
    // Show All Attendance
    public function Show(Request $req){
        $data = Attendence::with('users:name,reg_no','events:id,name')
        ->where('date', date('Y-m-d'))
        ->get();

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

        // Check User Data
        $user = User_Info::with('branchs')
        ->select('reg_no','id','name','phone','gender','qt_status','branch','image')
        ->where('qr_url', $req->qr_url)
        ->orWhere('reg_no', $req->qr_url)
        ->first();

        if(!$user){
            Attendence_Temp::create([
                'event_id' => $req->events,
                'date' => $req->date,
                'qr_url' => $req->qr_url,
            ]);

            return response()->json([
                'status'=> false,
                'message' => 'Your QR is not found ',
                "user" => $user
            ], 200);
        }

        // Check User Attendance
        $attendence = Attendence::where('event_id',$req->events)->where('reg_no',$user->reg_no)->where('date',$req->date)->first();

        if($attendence){
            return response()->json([
                'status'=> false,
                'message' => 'Your Attendance is already Given',
                "user" => $user
            ], 200);
        }

        // Check Event Status
        $event = Event::where('id', $req->events)->first();

        if($event->all == 1){
            $insert = Attendence::create([
                'event_id' => $req->events,
                'date' => $req->date,
                'reg_no' => $user->reg_no,
            ]);

            $data = Attendence::with('users:name,reg_no','events:id,name')->findOrFail($insert->id);
            
            return response()->json([
                'status'=> true,
                'message' => 'Your Attendance is Successfull',
                "data" => $data,
                "user" => $user
            ], 200);
        }
        else if($event->all == 0){
            $data = Event_User_List::with('events','participants')
            ->where('event_id', $req->events)
            ->whereHas('participants',function($query) use ($req) {
                $query->where('qr_url', $req->qr_url);
                $query->orWhere('reg_no', $req->qr_url);
            })
            ->first();

            if ($data) {
                if($event->id == 2){
                    Attendence::create([
                        'event_id' => 1,
                        'date' => $req->date,
                        'reg_no' => $data->participants->first()->reg_no,
                    ]);
                }

                $insert = Attendence::create([
                    'event_id' => $req->events,
                    'date' => $req->date,
                    'reg_no' => $data->participants->first()->reg_no,
                ]);

                $data = Attendence::with('users:name,reg_no','events:id,name')->findOrFail($insert->id);
                
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



    // Search All Attendance
    public function Search(Request $req){
        $data = Attendence::with('users:name,reg_no','events:id,name')
        ->where('date', 'like', $req->date.'%')
        ->where('event_id', 'like', $req->event.'%')
        ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
