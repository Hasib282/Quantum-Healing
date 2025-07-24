<?php

namespace App\Http\Controllers\API\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Login_User;
use App\Models\User_Info;

class AdminController extends Controller
{
    // Show All Admins
    public function Show(Request $req){
        if(Auth::user()->user_role == 1) {
            $data = User_Info::on('mysql_second')
            ->with('Store')
            ->where('user_role', 2)
            ->get();
        }
        else{
            $data = User_Info::on('mysql_second')
            ->with('Store')
            ->where('company_id', Auth::user()->company_id)
            ->where('user_role', 2)
            ->get();
        }

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Admins
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:mysql.login__users,user_phone',
            "email" => 'required|email|unique:mysql.login__users,user_email',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'company' => 'required|exists:mysql.company__details,company_id',
        ]);

        $data = null;

        DB::transaction(function () use ($req, &$data) {
            // Calling UserHelper Functions
            $adminId = GenerateLoginUserId(2, 'AD');
            $id = GenerateUserId(2, 'AD');
            $imageName = StoreUserImage($req, $id);

            Login_User::on('mysql')->create([
                "user_id" => $adminId,
                "company_user_id" => $id,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "user_role" =>  2,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "store_id" =>  $req->store,
                "company_id" =>  $req->company,
            ]);
            
            
            $insert = User_Info::on('mysql_second')->create([
                "user_id" => $id,
                "login_user_id" => $adminId,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "user_role" =>  2,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "store_id" =>  $req->store,
                "company_id" =>  $req->company,
            ]);

            $data = User_Info::on('mysql_second')->with('Store')->findOrFail($insert->id);
        });

        return response()->json([
            'status'=> true,
            'message' => 'Admin Details Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Admins
    public function Update(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role', 2)->findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('mysql.login__users', 'user_phone')->ignore($data->login_user_id, 'user_id' )],
            "email" => ['required','email',Rule::unique('mysql.login__users', 'user_email')->ignore( $data->login_user_id, 'user_id')],
        ]);


        DB::transaction(function () use ($req, $data) {
            $login_user = Login_User::on('mysql')->where('user_role', 2)->where('user_id', $data->login_user_id)->first();
            // Calling UserHelper Functions
            $imageName = UpdateUserImage($req, $data->image, $login_user->company_id, $data->user_id);

            $login_user->update([
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "image" => $imageName,
                "updated_at" => now(),
            ]);

            
            $data->update([
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "image" => $imageName,
                "updated_at" => now(),
            ]);
        });

        $updatedData = User_Info::on('mysql_second')->where('user_role', 2)->with('Store')->findOrFail($req->id);

        return response()->json([
            'status'=>true,
            'message' => 'Admin Details Updated Successfully',
            "updatedData" => $updatedData,
        ], 200); 
    } // End Method



    // Delete Admins
    public function Delete(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role', 2)->findOrFail($req->id);
        if($data->image){
            Storage::disk('public')->delete($data->image);
        }
        Login_User::on('mysql')->where('user_id',$data->login_user_id)->delete();
        $data->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Admin Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Admins Status
    public function DeleteStatus(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role', 2)->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        Login_User::on('mysql')->where('user_id',$data->login_user_id)->update(['status' => $data->status == 0 ? 1 : 0]);

        $updatedData = User_Info::on('mysql_second')->with('Store')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Admin Details Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method
}
