<?php

namespace App\Http\Controllers\Frontend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /////////////////////////// --------------- Permission Main Head Methods start ---------- //////////////////////////
    // Show All PermissionMainheads
    public function ShowPermissionMainheads(Request $req){
        $name = "Permission Main Head";
        $js = 'admin_setup/permission/permission_mainheads';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method
    
    
    
    
    
    /////////////////////////// --------------- Permissions Methods start ---------- //////////////////////////
    // Show All Permissions
    public function ShowPermissions(Request $req){
        $name = "Permissions";
        if ($req->ajax()) {
            return view('admin_setup.permission.permissions.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.permission.permissions.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Copmany Type Permission Methods Start ---------- //////////////////////////
    // Show Copmany Type Permission
    public function ShowCompanyTypePermissions(Request $req){
        $name = "Copmany Type Permission";
        if ($req->ajax()) {
            return view('admin_setup.permission.company_type_permission.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.permission.company_type_permission.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Company Permission Methods Start ---------- //////////////////////////
    // Show Company Permission
    public function ShowCompanyPermissions(Request $req){
        $name = "Company Permission";
        if ($req->ajax()) {
            return view('admin_setup.permission.company_permission.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.permission.company_permission.main', compact('name'));
        }
    } // End Method
    
    
    
    
    
    /////////////////////////// --------------- User Permission Methods Start ---------- //////////////////////////
    // Show User Permission
    public function ShowUserPermissions(Request $req){
        $name = "User Permission";
        if ($req->ajax()) {
            return view('admin_setup.permission.user_permission.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.permission.user_permission.main', compact('name'));
        }
    } // End Method
}
