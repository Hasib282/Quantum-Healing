<?php

namespace App\Http\Controllers\API\Backend\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User_Info;

class UserInfoController extends Controller
{
    public function show(Request $req)
    {
        $name = "User Info";
        if ($req->ajax()) {
            return view('user_info.ajaxBlade', compact('name'));
        }
        return view('user_info.main', compact('name'));
    }

    public function showData(Request $req)
    {
        $data = User_Info::get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }

    public function add(Request $req)
    {
        $req->validate([
            'sl' => 'required|integer',
            'reg_no' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'gender' => 'required|string',
            'qt_status' => 'required|string',
        ]);

        User_Info::create([
            'sl' => $req->sl,
            'qr_url' => $req->qr_url,
            'u_id' => $req->u_id,
            'reg_no' => $req->reg_no,
            'name' => $req->name,
            'phone' => $req->phone,
            'duplicate' => $req->duplicate ?? 0,
            'gender' => $req->gender,
            'age' => $req->age,
            'dob' => $req->dob,
            'occupation' => $req->occupation,
            'qt_status' => $req->qt_status,
            'quantum' => $req->quantum ?? 0,
            'quantier' => $req->quantier ?? 0,
            'ardentier' => $req->ardentier ?? 0,
            'branch' => $req->branch,
            'job_status' => $req->job_status ?? 0,
            'psyche_certificate' => $req->psyche_certificate ?? 0,
            'sp' => $req->sp ?? '0',
            'group' => $req->group,
            'call' => $req->call,
            'sms' => $req->sms ?? 0,
            'color' => $req->color,
            'barcode' => $req->barcode ?? 0,
            'new_barcode' => $req->new_barcode,
            'new_barcode_sl' => $req->new_barcode_sl,
            'barcode_delivery' => $req->barcode_delivery ?? 0,
            'first_attend' => $req->first_attend,
            'last_attend' => $req->last_attend,
            'status' => $req->status ?? 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User info added successfully',
        ], 200);
    }

    public function edit(Request $req)
    {
        $data = User_Info::findOrFail($req->id);

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'sl' => 'required|integer',
            'reg_no' => 'required|string',
            'name' => 'required|string',
            'gender' => 'required|string',
            'qt_status' => 'required|string',
        ]);

        User_Info::findOrFail($req->id)>update([
            'sl' => $req->sl,
            'qr_url' => $req->qr_url,
            'u_id' => $req->u_id,
            'reg_no' => $req->reg_no,
            'name' => $req->name,
            'phone' => $req->phone,
            'duplicate' => $req->duplicate ?? 0,
            'gender' => $req->gender,
            'age' => $req->age,
            'dob' => $req->dob,
            'occupation' => $req->occupation,
            'qt_status' => $req->qt_status,
            'quantum' => $req->quantum ?? 0,
            'quantier' => $req->quantier ?? 0,
            'ardentier' => $req->ardentier ?? 0,
            'branch' => $req->branch,
            'job_status' => $req->job_status ?? 0,
            'psyche_certificate' => $req->psyche_certificate ?? 0,
            'sp' => $req->sp ?? '0',
            'group' => $req->group,
            'call' => $req->call,
            'sms' => $req->sms ?? 0,
            'color' => $req->color,
            'barcode' => $req->barcode ?? 0,
            'new_barcode' => $req->new_barcode,
            'new_barcode_sl' => $req->new_barcode_sl,
            'barcode_delivery' => $req->barcode_delivery ?? 0,
            'first_attend' => $req->first_attend,
            'last_attend' => $req->last_attend,
            'status' => $req->status ?? 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User info updated successfully',
        ], 200);
    }

    public function delete(Request $req)
    {
        User_Info::findOrFail($req->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'User info deleted successfully',
        ], 200);
    }
}
