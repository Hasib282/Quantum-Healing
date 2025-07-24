<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetEmail;
use Illuminate\Support\Str;

use App\Models\User_Info;

class ForgetPasswordController extends Controller
{
    // Show Send Email Form
    public function ForgotPassord(){
        return view('auth.forgotPassword');
    } // End Method


    // Show Reset Form
    public function ResetPassword(Request $req){
        $token = $req->token;
        $passwordReset = DB::connection('mysql')->table('password_reset_tokens')->where('email', $req->email)->first();

        if (!$passwordReset) {
            return redirect()->route('login')->withErrors(['message' => 'Your Password reset token is expired.']);
        }

        return view('auth.resetPassword')->with( ['token' => $token, 'email' => $req->email] );
    } // End Method
}
