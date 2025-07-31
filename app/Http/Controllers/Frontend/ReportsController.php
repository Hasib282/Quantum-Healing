<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /////////////////////////// --------------- Attedance Statement Methods start ---------- //////////////////////////
    // Show All Attedance Statement
    public function ShowAttendanceStatement(Request $req){
        $name = "Attedance Statement";
        $js = 'reports/attendance_statement';
        if ($req->ajax()) {
            return view('report.attendance_statement.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('report.attendance_statement.main', compact('name', 'js'));
        }
    } // End Method
}
