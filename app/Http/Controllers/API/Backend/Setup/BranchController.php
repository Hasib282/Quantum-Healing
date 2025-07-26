<?php

namespace App\Http\Controllers\Api\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    // Show All Branchs
    public function Show(Request $req){
        $data = Branch::get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Branchs
    public function Insert(Request $req){
        $req->validate([
            'branch' => 'required|string|max:255',
            'short' => 'required|string|max:100'
        ]);

        $insert = Branch::create([
            'branch' => $req->branch,
            'short' => $req->short
        ]);

        $data = Branch::findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Branch Added Successfully',
            "data" => $data,
        ], 200);
    } // End Method



    // Update Branchs
    public function Update(Request $req){
        $data = Branch::findOrFail($req->id);

        $req->validate([
            'branch' => 'required|string|max:255',
            'short' => 'required|string|max:100'
        ]);

        $update = $data->update([
            'branch' => $req->branch,
            'short' => $req->short
        ]);

        $updatedData = Branch::findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Branch Updated successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Branch
    public function Delete(Request $req){
        Branch::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Branch Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Branch Status
    public function DeleteStatus(Request $req){
        $data = Branch::findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Branch::on('mysql')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Branch Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Branchs
    public function Get(){
        $data = Branch::on('mysql')
        ->orderBy('branch')
        ->get();

        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    } // End Method
}
