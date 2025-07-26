<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ShowController;

// Auth Controllers
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Auth\ForgetPasswordController;

use App\Http\Controllers\Frontend\Admin_Setup\UsersController;


Route::get('/link', function(){
    Artisan::call('storage:link');
});


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

Route::controller(ShowController::class)->group(function(){
    Route::get('/events','showEvent')->name('show');
    Route::get('/branches','showBranch')->name('show');
  
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
        }); // End Users Controller
    }); // End User Route
});