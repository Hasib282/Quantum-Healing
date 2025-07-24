<?php

namespace App\Http\Controllers\API\Backend\Users\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Role;

class RoleController extends Controller
{
    // Show All User Roles
    public function Show(Request $req){
        $data = Role::on('mysql')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert User Roles
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql.roles,name',
        ]);

        $insert = Role::on('mysql')->create([
            "name" => $req->name,
        ]);

        $data = Role::on('mysql')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'User Role Added Successfully',
            "data" => $data,
        ], 200);
    } // End Method



    // Update User Roles
    public function Update(Request $req){
        $data = Role::on('mysql')->findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('mysql.roles', 'name')->ignore($data->id)],
        ]);

        $update = $data->update([
            "name" => $req->name
        ]);

        $updatedData = Role::on('mysql')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'User Role Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete User Roles
    public function Delete(Request $req){
        Role::on('mysql')->whereNotIn('id', ['1'])->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'User Role Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete User Roles Status
    public function DeleteStatus(Request $req){
        $data = Role::on('mysql')->whereNotIn('id', ['1'])->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Role::on('mysql')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'User Role Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Roles
    public function Get(){
        $data = Role::on('mysql')
        ->whereNotIn('id', ['1'])
        ->select('id','name')
        ->orderBy('name')
        ->get();

        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    } // End Method
}
