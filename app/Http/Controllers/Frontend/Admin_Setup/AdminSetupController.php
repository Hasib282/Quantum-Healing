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
}
