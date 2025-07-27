<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Auth Controllers
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ForgetPasswordController;

// Users Controllers
use App\Http\Controllers\API\Backend\Users\Setup\RoleController;
use App\Http\Controllers\API\Backend\Users\AdminController;
use App\Http\Controllers\API\Backend\Users\SuperAdminController;
use App\Http\Controllers\API\Backend\Users\UserInfoController;






// Setup Controllers
use App\Http\Controllers\API\Backend\Setup\EventController;
use App\Http\Controllers\API\Backend\Setup\BranchController;
use App\Http\Controllers\API\Backend\Setup\EventUserController;


// *************************************** Forget Password Controller Routes Start *************************************** //
Route::controller(ForgetPasswordController::class)->group(function () {
    Route::post('/forgotpassword', 'ForgotPassword');
    Route::post('/resetpassword',  'ResetPassword');
});

Route::post('/login', [AuthController::class, 'Login'])->middleware(['web']);


// Route::middleware(['auth:sanctum', ApiValidUser::class, CheckPermission::class])->group(function () {
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'Logout'])->middleware(['web']);

    /////-----/////-----/////-----/////-----/////-----///// Admin Setup Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/admin')->group(function () {
        // *************************************** User Routes Start *************************************** //
        Route::prefix('/users')->group(function () {
            ///////////// --------------- Role Routes ----------- ///////////////////
            Route::controller(RoleController::class)->group(function () {
                Route::get('/roles', 'Show');
                Route::post('/roles', 'Insert');
                Route::put('/roles', 'Update');
                Route::delete('/roles', 'Delete');
                Route::delete('/roles/delete', 'DeleteStatus');
                Route::get('/roles/get', 'Get');
            });



            ///////////// --------------- Super Admin Routes ----------- ///////////////////
            Route::controller(SuperAdminController::class)->group(function () {
                Route::get('/superadmins', 'Show');
                Route::post('/superadmins', 'Insert');
                Route::put('/superadmins', 'Update');
                Route::delete('/superadmins', 'Delete');
                Route::delete('/superadmins/delete', 'DeleteStatus');
            });
            

            ///////////// --------------- Admin Routes ----------- ///////////////////
            Route::controller(AdminController::class)->group(function () {
                Route::get('/admins', 'Show');
                Route::post('/admins', 'Insert');
                Route::put('/admins', 'Update');
                Route::delete('/admins', 'Delete');
                Route::delete('/admins/delete', 'DeleteStatus');
            });

             ///////////// --------------- User_info Routes ----------- ///////////////////

            Route::controller(UserInfoController::class)->group(function () {
                Route::get('/user_info', 'Show');
                Route::post('/user_info', 'Insert');
                Route::put('/user_info', 'Update');
                Route::delete('/user_info', 'Delete');
                Route::get('/user_info/get/conductors','GetConductors');
                Route::get('/user_info/get/participants','GetParticipants');
            });
        }); // End User Routes



        // *************************************** Event Routes Start *************************************** //
        Route::controller(EventController::class)->group(function(){
            Route::get('/events','Show');
            Route::post('/events','Insert');
            Route::put('/events','Update');
            Route::delete('/events','Delete');
            Route::get('/events/get','Get');
        }); // End Event Routes



        // *************************************** Branch Routes Start *************************************** //
        Route::controller(BranchController::class)->group(function(){
            Route::get('/branches','Show');
            Route::post('/branches','Insert');
            Route::put('/branches','Update');
            Route::delete('/branches','Delete');
            Route::get('/branches/get','Get');
        }); // End Branch Routes
        
        
        
        // *************************************** Event Users Routes Start *************************************** //
        Route::controller(EventUserController::class)->group(function(){
            Route::get('/event_users','Show');
            Route::post('/event_users','Insert');
            Route::put('/event_users','Update');
            Route::delete('/event_users','Delete');
            Route::get('/event_users/get','Get');
        }); // End Branch Routes
    });
});


