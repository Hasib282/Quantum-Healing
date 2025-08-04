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

class TempAttendanceController extends Controller
{
    // Show All Attendance
    public function Show(Request $req){
        $data = Attendence_Temp::with('users:name,reg_no','events:id,name')
        ->where('date', date('Y-m-d'))
        ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method


    
    // Insert Attendance and Update User Qr Url and Delete Temp Attendance
    public function Insert(Request $req){
        $req->validate([
            'events' => 'required',
            'date' => 'required',
            'qr_url' => 'required|url:http,https',
            'reg_no' => 'required|exists:user__infos,reg_no',
        ]);

        $data = Attendence_Temp::findOrFail($req->id);

        // Update User Qr Url
        User_Info::where('reg_no', $req->reg_no)->update([
            'qr_url' => $req->qr_url,
        ]);

        // Insert Attendence
        Attendence::create([
            'event_id' => $data->event_id,
            'date' => $data->date,
            'reg_no' => $req->reg_no,
            'added_at' => $data->added_at
        ]);

        $data->delete();

        return response()->json([
            'status'=> true,
            'message' => 'Attendance and Qr Url Updated Successfully',
        ], 200);
    } // End Method



    // Search All Attendance
    public function Search(Request $req){
        $data = Attendence_Temp::with('users:name,reg_no','events:id,name')
        ->where('date', 'like', $req->date.'%')
        ->where('event_id', 'like', $req->event.'%')
        ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
    
    
    
    // Delete Attendance
    public function Delete(Request $req){
        $data = Attendence_Temp::findOrFail($req->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Temp Attendance Deleted Successfully',
        ], 200);
    } // End Method
}
