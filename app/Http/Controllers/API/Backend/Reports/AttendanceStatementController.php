<?php

namespace App\Http\Controllers\API\Backend\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Attendence;

class AttendanceStatementController extends Controller
{
    // Show All Client Return Details Statement
    public function Show(Request $req){
        $req->validate([
            'events' => 'required',
            'date' => 'required'
        ]);

        $data = Attendence::with('events:id,name','participants:gender,qt_status,reg_no,phone,name,branch','participants.branchs:id,short')
        ->where('event_id', $req->events)
        ->where('date', $req->date)
        ->whereHas('participants', function ($query) use ($req) {
            $query->where('gender', "Like",  $req->gender ."%");
            $query->where('qt_status', "Like",  $req->qt_status ."%");
        })
        ->get()
        ->sortBy(function ($item) {
            $participant = $item->participants[0]; // or [0]
            return $participant ? [$participant->gender, $participant->qt_status] : ['', ''];
        })->values();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Client Return Details Report
    public function Print(Request $req){
        $req->validate([
            'events' => 'required',
            'date' => 'required'
        ]);

        $data = Attendence::with('events:id,name','participants:gender,qt_status,reg_no,phone,name,branch','participants.branchs:id,short')
        ->where('event_id', $req->events)
        ->where('date', "Like",  $req->date ."%")
        ->whereHas('participants', function ($query) use ($req) {
            $query->where('gender', "Like",  $req->gender ."%");
            $query->where('qt_status', "Like",  $req->qt_status ."%");
        })
        ->get()
        ->sortBy(function ($item) {
            $participant = $item->participants[0]; // or [0]
            return $participant ? [$participant->gender, $participant->qt_status] : ['', ''];
        })
        ->values();
        
        $pdf = Pdf::loadView('report.attendance_statement.print', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
