<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Auth Controllers
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Auth\ForgetPasswordController;

use App\Http\Controllers\Frontend\Admin_Setup\UsersController;
use App\Http\Controllers\Frontend\Admin_Setup\AdminSetupController;
use App\Http\Controllers\API\Backend\Users\UserInfoController;


Route::get('/link', function(){
    Artisan::call('storage:link');
});

Route::get('/layout', function () {
    return view('layouts.layout');
});

Route::get('/search', function () {
    return view('search');
});

Route::controller(UserInfoController::class)->group(function(){
    Route::get('/user_info/get/participants','GetParticipants');
}); // End Branch Routes

// *************************************** Login Controller Routes Start *************************************** //
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'Login')->name('login');
    Route::get('/dashboard', 'Dashboard')->name('dashboard');
});


// *************************************** Forget Password Controller Routes Start *************************************** //
Route::controller(ForgetPasswordController::class)->group(function () {
    Route::get('/forgotpassword', 'ForgotPassord')->name('forgotPassword');
    Route::get('/resetpassword', 'ResetPassword')->name('resetPassword');
});

/////-----/////-----/////-----/////-----/////-----///// Admin Setup Routes Start /////-----/////-----/////-----/////-----/////-----/////

Route::prefix('/admin')->group(function () {
    // *************************************** User Routes Start *************************************** //
    Route::prefix('/users')->group(function () {
        Route::controller(UsersController::class)->group(function () {
            ///////////// --------------- Role routes ----------- ///////////////////
            Route::get('/roles', 'ShowRoles')->name('show.roles');
            

            ///////////// --------------- Admin Routes ----------- ///////////////////
            Route::get('/admins', 'ShowAdmins')->name('show.admins');


            ///////////// --------------- Super Admin Routes ----------- ///////////////////
            Route::get('/superadmins', 'ShowSuperAdmins')->name('show.superAdmins');


            ///////////// --------------- Users Routes ----------- ///////////////////
            Route::get('/user_info', 'ShowUsers')->name('show.users');
        }); // End Users Controller
    }); // End User Route



    Route::controller(AdminSetupController::class)->group(function(){
        ///////////// --------------- Event routes ----------- ///////////////////
        Route::get('/events','ShowEvent')->name('show.event');



        ///////////// --------------- Branch routes ----------- ///////////////////
        Route::get('/branches','ShowBranch')->name('show.branch');



        ///////////// --------------- Attendance routes ----------- ///////////////////
        Route::get('/attendance','ShowAttendance')->name('show.attendance');
        
        
        
        ///////////// --------------- Event User routes ----------- ///////////////////
        Route::get('/event_users','ShowEventUser')->name('show.eventUsers');
    });
});