<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    // Show all branches
    public function show()
    {
        $data = Branch::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // Add a branch
    public function add(Request $req)
    {
        $req->validate([
            'branch' => 'required|string|max:255',
            'short' => 'required|string|max:100'
        ]);

        Branch::create([
            'branch' => $req->branch,
            'short' => $req->short
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Branch added successfully'
        ], 200);
    }

    // Fetch single branch for edit
    public function edit(Request $req)
    {
        $branch = Branch::findOrFail($req->id);

        return response()->json([
            'status' => true,
            'data' => $branch
        ], 200);
    }

    // Update branch
    public function update(Request $req)
    {
        $req->validate([
            'id' => 'required|exists:branches,id',
            'branch' => 'required|string|max:255',
            'short' => 'required|string|max:100'
        ]);

        Branch::findOrFail($req->id)->update([
            'branch' => $req->branch,
            'short' => $req->short
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Branch updated successfully'
        ], 200);
    }

    // Delete branch
    public function delete(Request $req)
    {
        Branch::findOrFail($req->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Branch deleted successfully'
        ], 200);
    }

    // Search branch
    public function search(Request $req)
    {
        if ($req->option == 0) {
            $data = Branch::where('branch', 'like', '%' . $req->search . '%')
                ->orWhere('short', 'like', '%' . $req->search . '%')
                ->get();
        } elseif ($req->option == 1) {
            $data = Branch::where('branch', 'like', '%' . $req->search . '%')->get();
        } elseif ($req->option == 2) {
            $data = Branch::where('short', 'like', '%' . $req->search . '%')->get();
        } else {
            $data = Branch::all();
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
