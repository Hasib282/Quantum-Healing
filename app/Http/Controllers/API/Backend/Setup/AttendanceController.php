<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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
            'events' => 'required|exists:events,id',
            'date' => 'required',
            'qr_url' => 'required'
        ]);

        // Get User Data
        $user = User_Info::with('branchs:id,branch')
        ->select('reg_no','id','name','phone','gender','qt_status','branch','image')
        ->where('qr_url', $req->qr_url)
        ->orWhere('reg_no', $req->qr_url)
        ->first();

        // Get Event Status
        $event = Event::select('all')->find($req->events);

        // Check User Attendance
        if($user){
            $attendence = Attendence::where([
                ['event_id', '=', $req->events],
                ['reg_no', '=', $user->reg_no],
                ['date', '=', $req->date]
            ])->exists();
            
            if($attendence){
                return response()->json([
                    'status'=> false,
                    'message' => 'Your Attendance is already Given',
                    "user" => $user
                ], 200);
            }
        }


        // If All Participants are Alowed in Event
        if($event->all == 1){
            if(!$user){
                Attendence_Temp::create([
                    'event_id' => $req->events,
                    'date' => $req->date,
                    'qr_url' => $req->qr_url,
                ]);

                $counts = $this->Count($req->events, $req->date);

                return response()->json([
                    'status'=> true,
                    'message' => 'Your Attendance is Successfull. Status others.',
                    "user" => null,
                    'counts' => $counts
                ], 200);
            }

            // Save attendence for valid user
            $insert = Attendence::create([
                'event_id' => $req->events,
                'date' => $req->date,
                'reg_no' => $user->reg_no,
            ]);
            
            $counts = $this->Count($req->events, $req->date);

            return response()->json([
                'status'=> true,
                'message' => 'Your Attendance is Successfull',
                "data" => $insert->load('users:name,reg_no','events:id,name'),
                "user" => $user,
                'counts' => $counts
            ], 200);
        }

        // If Limited Participants are Alowed in Event
        $participantExists = Event_User_List::with('participants:qr_url,reg_no')
        ->where('event_id', $req->events)
        ->whereHas('participants',function($query) use ($req) {
            $query->where('qr_url', $req->qr_url);
            $query->orWhere('reg_no', $req->qr_url);
        })
        ->first();

        if ($participantExists) {
            $regNo = $participantExists->first()->reg_no;

            // If hadis than insert attendence into healing event
            if($req->events == 2){
                Attendence::create([
                    'event_id' => 1,
                    'date' => $req->date,
                    'reg_no' => $regNo,
                ]);
            }

            $insert = Attendence::create([
                'event_id' => $req->events,
                'date' => $req->date,
                'reg_no' => $regNo,
            ]);

            $counts = $this->Count($req->events, $req->date);

            return response()->json([
                'status'=> true,
                'message' => 'Attendance Added Successfully',
                "data" => $insert->load('users:name,reg_no','events:id,name'),
                "user" => $user,
                'counts' => $counts
            ], 200);
        }
        
        return response()->json([
            'status'=> false,
            'message' => 'You are not allowed to enter',
            'user' => $user,
        ], 200);
    } // End Method



    // User Count
    public function Count($eventId, $date){
        $attendance = Attendence::join('user__infos as ui', 'ui.reg_no', '=', 'attendences.reg_no')
        ->where('attendences.event_id', $eventId)
        ->where('attendences.date', $date)
        ->selectRaw("
            SUM(CASE WHEN ui.gender = 'Male'   AND ui.qt_status = 'Graduate'   THEN 1 ELSE 0 END) as male_graduate,
            SUM(CASE WHEN ui.gender = 'Male'   AND ui.qt_status = 'Pro-master' THEN 1 ELSE 0 END) as male_prograduate,
            SUM(CASE WHEN ui.gender = 'Female' AND ui.qt_status = 'Graduate'   THEN 1 ELSE 0 END) as female_graduate,
            SUM(CASE WHEN ui.gender = 'Female' AND ui.qt_status = 'Pro-master' THEN 1 ELSE 0 END) as female_prograduate
        ")
        ->first();
        
        $temp = Attendence_Temp::where('event_id',$eventId)->where('date',$date)->count();

        return [
            'male_graduate' => $attendance->male_graduate ?? 0,
            'male_pro' => $attendance->male_prograduate ?? 0,
            'female_graduate' => $attendance->female_graduate ?? 0,
            'female_pro' => $attendance->female_prograduate ?? 0,
            'temp' => $temp,
        ];
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



    // // User Count
    // public function Count(Request $req){
    //     $attendance = Attendence::join('user__infos as ui', 'ui.reg_no', '=', 'attendences.reg_no')
    //     ->where('attendences.event_id', $req->events)
    //     ->where('attendences.date', $req->date)
    //     ->selectRaw("
    //         SUM(CASE WHEN ui.gender = 'Male'   AND ui.qt_status = 'Graduate'   THEN 1 ELSE 0 END) as male_graduate,
    //         SUM(CASE WHEN ui.gender = 'Male'   AND ui.qt_status = 'Pro-master' THEN 1 ELSE 0 END) as male_prograduate,
    //         SUM(CASE WHEN ui.gender = 'Female' AND ui.qt_status = 'Graduate'   THEN 1 ELSE 0 END) as female_graduate,
    //         SUM(CASE WHEN ui.gender = 'Female' AND ui.qt_status = 'Pro-master' THEN 1 ELSE 0 END) as female_prograduate
    //     ")
    //     ->first();
        
    //     $temp = Attendence_Temp::where('event_id',$req->events)->where('date',$req->date)->count();

    //     return response()->json([
    //         'status' => true,
    //         'male_graduate' => $attendance->male_graduate ?? 0,
    //         'male_pro' => $attendance->male_prograduate ?? 0,
    //         'female_graduate' => $attendance->female_graduate ?? 0,
    //         'female_pro' => $attendance->female_prograduate ?? 0,
    //         'temp' => $temp,
    //     ], 200);
    // } // End Method




    // Upload Data from excel file to Database
    public function UploadData(Request $req){
        $req->validate([
            'events' => 'required|exists:events,id',
            'file' => 'required|file|mimes:xlsx'
        ]);
        set_time_limit(3600);

        $filePath = $req->file('file')->getRealPath();
        $data = readXlsxRaw($filePath);
        
        $count = 0;
        $isHeader = true;
        $insertData = [];
        foreach ($data as $key => $item) {
            // Skip header
            if ($isHeader) {
                $isHeader = false;
                continue;
            }


            if (!empty($item[1]) && is_numeric($item[1])) {
                // Try to convert numeric values to dates
                $date = excelDateToPhp((float)$item[1]);
                // Only replace if it looks like a valid date
                if ($date !== $item[1]) {
                    $item[1] = $date;
                }
            }

            $exists = Attendence::where('event_id',$req->events)->where('reg_no',$item[2])->where('date',$item[1])->first();

            if(!$exists){
                // Insert into insertData array
                $insertData[] = [
                    'event_id' => $req->events,
                    'date' => $item[1],
                    'reg_no' => $item[2],
                ];
                $count++;
            }
        }


        // Bulk insert
        DB::transaction(function () use ($insertData) {
            if (!empty($insertData)) {
                foreach (array_chunk($insertData, 10000) as $chunk) {
                    Attendence::insert($chunk);
                }
            }
        });

        if($count > 0){
            return response()->json([
                'status' => true,
                'message' => 'Excel Data Uploded Successfully',
            ], 200);
        }
        else{
            return response()->json([
                'status' => true,
                'message' => 'You have already uploaded this excel file.',
            ], 200);
        }
    } // End Method
}
