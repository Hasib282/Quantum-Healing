<?php

namespace App\Http\Controllers\Frontend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /////////////////////////// --------------- Roles Table Methods start ---------- //////////////////////////
    // Show All Roles
    public function ShowRoles(Request $req){
        $name = "User Role";
        $js = 'admin_setup/users/roles';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method


    

    
    /////////////////////////// --------------- Super Admin Methods start---------- //////////////////////////
    // Show Super Admins
    public function ShowSuperAdmins(Request $req){
        $name = "Super Admin";
        $js = "super_admin";
        if ($req->ajax()) {
            return view('users.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('users.main', compact('name', 'js'));
        }
    } // End Method
    
    
    
    
    
    /////////////////////////// --------------- Admin Methods start---------- //////////////////////////
    // Show Admins
    public function ShowAdmins(Request $req){
        $name = "Admin";
        $js = "admin";
        if ($req->ajax()) {
            return view('users.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('users.main', compact('name', 'js'));
        }
    } // End Method
}
