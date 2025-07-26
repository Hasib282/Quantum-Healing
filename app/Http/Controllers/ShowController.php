<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowController extends Controller
{
     public function showEvent(Request $req){
        $name = "Event";
        if($req->ajax()){
            return view('event.ajaxBlade',compact('name'));
        } 
        return view('event.main',compact('name'));
    }

    public function showBranch(Request $req){
        $name = "Branch";
        if($req->ajax()){
            return view('branch.ajaxBlade',compact('name'));
        } 
        return view('branch.main',compact('name'));
    }
}
