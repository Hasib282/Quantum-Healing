<?php

namespace App\Http\Controllers\Frontend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSetupController extends Controller
{
    /////////////////////////// --------------- Event Methods start---------- //////////////////////////
    // Show Event
    public function ShowEvent(Request $req){
        $name = "Event";
        $js = "admin_setup/event";
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        return view('common_modals.single_input.main', compact('name','js'));
    } // End Method



    /////////////////////////// --------------- Branch Table Methods start ---------- //////////////////////////
    // Show All Branch
    public function ShowBranch(Request $req){
        $name = "Branch";
        $js = 'admin_setup/branch';
        if ($req->ajax()) {
            return view('setup.branch.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('setup.branch.main', compact('name', 'js'));
        }
    } // End Method
    
    
    
    /////////////////////////// --------------- EventUser Table Methods start ---------- //////////////////////////
    // Show All EventUser
    public function ShowEventUser(Request $req){
        $name = "Event User";
        $js = 'admin_setup/event_user';
        if ($req->ajax()) {
            return view('setup.event_user.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('setup.event_user.main', compact('name', 'js'));
        }
    } // End Method



      /////////////////////////// --------------- attendance Table Methods start ---------- //////////////////////////
    // Show All EventUser
    public function ShowAttendance(Request $req){
        $name = "Attendance";
        $js = 'admin_setup/attendance';
        if ($req->ajax()) {
            return view('setup.attendance.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('setup.attendance.main', compact('name', 'js'));
        }
    } // End Method


    public function ShowPracticeEventUser(Request $req){
        $name = "Practice Event User";
        $js = 'admin_setup/practice_event_user'; // new JS file
        if ($req->ajax()) {
            return view('setup.event_user_practice.ajaxBlade', compact('name', 'js'));
        } else {
            return view('setup.event_user_practice.main', compact('name', 'js'));
        }
    }
    
}
