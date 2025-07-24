<?php

namespace App\Http\Controllers\API\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Login_User;

class SuperAdminController extends Controller
{
    // Show All SuperAdmins
    public function Show(Request $req){
        $data = Login_User::on('mysql')->where('user_role', 1)->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert SuperAdmins
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:mysql.login__users,user_phone',
            "email" => 'required|email|unique:mysql.login__users,user_email',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = null;

        DB::transaction(function () use ($req, &$data) {
            // Calling UserHelper Functions
            $id = GenerateLoginUserId(1, "SA");
            $imageName = StoreUserImage($req, $id);

            $insert = Login_User::on('mysql')->create([
                "user_id" => $id,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "user_role" => 1,
                "password" => Hash::make($req->password),
                "image" => $imageName,
            ]);

            $data = Login_User::on('mysql')->findOrFail($insert->id);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'SuperAdmin Details Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update SuperAdmins
    public function Update(Request $req){
        $data = Login_User::on('mysql')->where('user_role', 1)->findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('mysql.login__users', 'user_phone')->ignore($data->id)],
            "email" => ['required','email',Rule::unique('mysql.login__users', 'user_email')->ignore($data->id)],
        ]);

        DB::transaction(function () use ($req, $data) {
            // Calling UserHelper Functions
            $imageName = UpdateUserImage($req, $data->image, null, $data->user_id);

            $data->update([
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "image" => $imageName,
                "updated_at" => now(),
            ]);
        });

        $updatedData = Login_User::on('mysql')->where('user_role', 1)->findOrFail($req->id);

        return response()->json([
            'status'=>true,
            'message' => 'SuperAdmin Details Updated Successfully',
            "updatedData" => $updatedData,
        ], 200); 
    } // End Method



    // Delete SuperAdmins
    public function Delete(Request $req){
        $data = Login_User::on('mysql')->where('user_role', 1)->findOrFail($req->id);
        if($data->image){
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        return response()->json([
            'status'=> true,
            'message' => 'SuperAdmin Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete SuperAdmins Status
    public function DeleteStatus(Request $req){
        $data = Login_User::on('mysql')->where('user_role', 1)->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Login_User::on('mysql')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'SuperAdmin Details Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method
}
