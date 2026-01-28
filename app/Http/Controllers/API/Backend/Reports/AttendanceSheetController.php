<?php

namespace App\Http\Controllers\API\Backend\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

use App\Models\Event;
use App\Models\Event_User_List;
use App\Models\User_Info;
use App\Models\Attendence;

class AttendanceSheetController extends Controller
{
    // Show All Client Return Details Statement
    public function Show(Request $req){
        $req->validate([
            'events' => 'required',
            'from' => 'required',
            'to' => 'required'
        ]);

        $event = Event::findOrFail($req->events);

        if($event->all == 1){
            $users = User_Info::select('reg_no', 'name','gender','qt_status')->get();
        }
        else{
            $users = Event_User_List::with('participant:reg_no,name,gender,qt_status')
            ->where('event_id', $req->events)
            ->get()
            ->pluck('participant');
        }

        $dates = Attendence::where('event_id', $req->events)
        ->whereBetween('date', [$req->from, $req->to])
        ->distinct()
        ->orderBy('date', 'asc')
        ->pluck('date');

        $data = Attendence::select('date','reg_no','event_id')
        ->where('event_id', $req->events)
        ->whereBetween('date', [$req->from, $req->to])
        ->get()
        ->groupBy(['reg_no', 'date']);

        return response()->json([
            'status'=> true,
            'users' => $users,
            'dates' => $dates,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Client Return Details Report
    public function Print(Request $req){
        $req->validate([
            'events' => 'required',
            'from' => 'required',
            'to' => 'required'
        ]);

        $event = Event::findOrFail($req->events);

        if($event->all == 1){
            $users = User_Info::select('reg_no', 'name','gender','qt_status')->get();
        }
        else{
            $users = Event_User_List::with('participant:reg_no,name,gender,qt_status')
            ->where('event_id', $req->events)
            ->get()
            ->pluck('participant');
        }

        $dates = Attendence::where('event_id', $req->events)
        ->whereBetween('date', [$req->from, $req->to])
        ->distinct()
        ->orderBy('date', 'asc')
        ->pluck('date');

        $data = Attendence::select('date','reg_no','event_id')
        ->where('event_id', $req->events)
        ->whereBetween('date', [$req->from, $req->to])
        ->get()
        ->groupBy(['reg_no', 'date']);
        
        $pdf = Pdf::loadView('report.attendance_sheet.print', compact('users','dates','data','event'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
