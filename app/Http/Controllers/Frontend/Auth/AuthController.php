<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Show Login Page
    public function login(Request $req){
        return view('auth.login');
    } // End Method

    
    // Show Dashboard
    public function Dashboard(){
        return view('layouts.layout');
    } // End Method
}
