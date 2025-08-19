<?php

namespace App\Http\Controllers\API\Backend\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use ZipArchive;

use App\Models\User_Info;
use App\Models\Temp_User;
use App\Models\Branch;

class UserInfoController extends Controller
{
    // Show All User Information
    public function Show(Request $req){
        $data = User_Info::with('branchs')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert User Information
    public function Insert(Request $req){
        $req->validate([
            'reg_no' => 'required|unique:user__infos,reg_no',
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|numeric',
            'dob' => 'nullable|date',
            'qt_status' => 'required|in:Graduate,Pro-master',
            'branch'=> 'required|exists:branches,id',
            'call'=>'nullable|in:Call,Not to call',
            'color'=> 'nullable|in:Red,Green,Yellow'
        ]);

        $data = null;

        DB::transaction(function () use ($req, &$data) {
            if ($req->dob) {
                // Calculate age from DOB
                $dob = \Carbon\Carbon::parse($req->dob);
                $age = $dob->age;
            } else {
                // Calculate DOB from Age (approximate)
                $age = (int) $req->age;
                $dob = now()->subYears($age)->format('Y-m-d');
            }

            $id = GenerateSLNo() + 0;
            // Calling UserHelper Functions
            $imageName = StoreUserImage($req, $id);

            $insert = User_Info::create([
                'sl' => $id,
                'qr_url' => $req->qr_url,
                'u_id' => $req->u_id,
                'reg_no' => $req->reg_no,
                'name' => $req->name,
                'phone' => $req->phone,
                'duplicate' => $req->duplicate == 'on' ? 1:0,
                'gender' => $req->gender,
                'age' => $age,
                'dob' => $dob,
                'occupation' => $req->occupation,
                'qt_status' => $req->qt_status,
                'quantum' => $req->quantum == 'on' ? 1:0,
                'quantier' => $req->quantier == 'on' ? 1:0,
                'ardentier' => $req->ardentier == 'on' ? 1:0,
                'branch' => $req->branch,
                'job_status' => $req->job_status == 'on' ? 1:0,
                'psyche_certificate' => $req->psyche_certificate == 'on' ? 1:0,
                'sp' => $req->sp == 'on' ? 1:0,
                'group' => $req->group,
                'call' => $req->call,
                'sms' => $req->sms == 'on' ? 1:0,
                'color' => $req->color,
                'barcode' => $req->barcode == 'on' ? 1:0,
                'new_barcode' => $req->new_barcode,
                'new_barcode_sl' => $req->new_barcode_sl,
                'barcode_delivery' => $req->barcode_delivery == 'on' ? 1:0,
                'image' => $imageName
            ]);

            $data = User_Info::with('branchs')->findOrFail($insert->id);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'User Information Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method
    

    public function Update(Request $req)
    {
        $data = User_Info::findOrFail($req->id);
        
        $req->validate([
            'reg_no' => ['required',Rule::unique('user__infos', 'reg_no')->ignore($data->id)],
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|numeric',
            'dob' => 'nullable|date',
            'qt_status' => 'required|in:Graduate,Pro-master',
            'branch'=> 'required|exists:branches,id',
            'call'=>'nullable|in:Call,Not to call',
            'color'=> 'nullable|in:Red,Green,Yellow'
        ]);

        

        if ($req->dob) {
            // Calculate age from DOB
            $dob = \Carbon\Carbon::parse($req->dob);
            $age = $dob->age;
        } else {
            // Calculate DOB from Age (approximate)
            $age = (int) $req->age;
            $dob = now()->subYears($age)->format('Y-m-d');
        }
        // dd($data->sl+0);
        $imageName = UpdateUserImage($req, $data->image, null, $data->sl + 0);
        // dd($req->sms);
        $data->update([
            'sl' => $data->sl,
            'qr_url' => $req->qr_url,
            'u_id' => $req->u_id,
            'reg_no' => $req->reg_no,
            'name' => $req->name,
            'phone' => $req->phone,
            'duplicate' => $req->duplicate == 'on' ? 1:0,
            'gender' => $req->gender,
            'age' => $age,
            'dob' => $dob,
            'occupation' => $req->occupation,
            'qt_status' => $req->qt_status,
            'quantum' => $req->quantum == 'on' ? 1:0,
            'quantier' => $req->quantier == 'on' ? 1:0,
            'ardentier' => $req->ardentier == 'on' ? 1:0,
            'branch' => $req->branch,
            'job_status' => $req->job_status == 'on' ? 1:0,
            'psyche_certificate' => $req->psyche_certificate == 'on' ? 1:0,
            'sp' => $req->sp == 'on' ? 1:0,
            'group' => $req->group,
            'call' => $req->call,
            'sms' => $req->sms == 'on' ? 1:0,
            'color' => $req->color,
            'barcode' => $req->barcode == 'on' ? 1:0,
            'new_barcode' => $req->new_barcode,
            'new_barcode_sl' => $req->new_barcode_sl,
            'barcode_delivery' => $req->barcode_delivery == 'on' ? 1:0,
            'image' => $imageName
        ]);

        $updatedData = User_Info::with('branchs')->findOrFail($req->id);

        return response()->json([
            'status' => true,
            'message' => 'User info updated successfully',
            'updatedData' => $updatedData
        ], 200);
    }

    public function Delete(Request $req)
    {
        User_Info::findOrFail($req->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'User info deleted successfully',
        ], 200);
    }


    // Get Participants
    public function GetParticipants(Request $req){
        $page = $req->input('page', 1);
        $perPage = 30;

        $query = User_Info::query()
            // ->with('branch')
            ->select('id', 'name', 'reg_no','phone','gender','branch')
            ->whereNotIn('reg_no',is_array($req->reg_no) ? $req->reg_no : [])
            ->when($req->search, function ($q) use ($req) {
                $q->where(function ($sub) use ($req) {
                    $sub->where('name', 'like', $req->search."%")
                        ->orWhere('reg_no', 'like', $req->search."%");
                });
            })
            ->orderBy('name');
            
            
        // (2-1)*20
        $total = $query->count();
        $data = $query->skip(($page - 1) * $perPage)->take($perPage)->with('branchs')->get();
        $list = "";

        if($page == 1){
            $list .= '<table style="border-collapse: collapse;width: 100%;overflow-x: auto;">
                        <thead>
                            <th>Sl</th>
                            <th>Reg No</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Gender</th>
                        </thead>
                        <tbody>';
        }

        if($data->count() > 0){
            foreach($data as $index => $item) {
                $list .= '<tr class="addData" tabindex="' . (($page - 1) * $perPage + $index) . '" data-reg_no="'.$item->reg_no.'" data-id="'.$item->id.'" data-name="'.$item->name.'" data-phone="'.$item->phone.'" data-gender="'.$item->gender.'">
                            <td>'.(($page - 1) * $perPage + $index +1).'</td>
                            <td>'.$item->reg_no.'</td>
                            <td>'.$item->name.'</td>
                            <td>'.$item->phone.'</td>
                            <td>'.$item->gender.'</td>
                        </tr>';
            }
        }
        else{
            $list .= '<tr><td colspsn="20">No Data Found</td></tr>';
        }

        if($page == 1){
            $list .= "  </tbody>
                    </table>";
        }

        return response()->json([
            'list' => $list,
            'hasMore' => ($page * $perPage) < $total
        ]);
    } // End Method



    // Get User Regno
    public function GetRegno(Request $req){
        $data = User_Info::with('branchs')
        ->select('reg_no','id','name','phone','gender','qt_status','branch','image')
        ->where('reg_no',$req->reg_no)->first();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Upload User Data
    public function UploadData(Request $req){
        $req->validate([
            'file' => 'required|file|mimes:xlsx'
        ]);

        $filePath = $req->file('file')->getRealPath();
        $rows = readXlsxRaw($filePath);
        
        $isHeader = true;
        foreach ($rows as $key => $rowData) {
            // Skip header
            if ($isHeader) {
                $isHeader = false;
                continue;
            }
            
            // dd($rowData);
            $sl = GenerateTempSLNo() + 0;

            if ($rowData[7]) {
                // Calculate DOB from Age (approximate)
                $age = (int) $rowData[7];
                $dob = now()->subYears($age)->format('Y-m-d');
            } else {
                // Calculate DOB from Age (approximate)
                $age = null;
                $dob = null;
            }

            // Insert into temp__users
            Temp_User::create([
                'sl' => $sl,
                'qr_url' => !empty($rowData[0]) ? $rowData[0] : null,
                'u_id' => !empty($rowData[1]) ? $rowData[1] : null,
                'reg_no' => $rowData[2],
                'name' => $rowData[3],
                'phone' => $rowData[4],
                'duplicate' => !empty($rowData[5]) ? $rowData[2] : 0,
                'gender' => $rowData[6],
                'age' => $age,
                'dob' => $dob,
                'occupation' => !empty($rowData[9]) ? $rowData[9] : null,
                'qt_status' => $rowData[10],
                'quantum' => !empty($rowData[11]) ? $rowData[11] : 0,
                'quantier' => !empty($rowData[12]) ? $rowData[12] : 0,
                'ardentier' => !empty($rowData[13]) ? $rowData[13] : 0,
                'branch' => !empty($rowData[14]) ? $rowData[14] : null,     
                'job_status' => !empty($rowData[15]) ? $rowData[15] : 0,
                'psyche_certificate' => !empty($rowData[16]) ? $rowData[16] : 0,
                'sp' => !empty($rowData[17]) ? $rowData[17] : 0,
                'group' => !empty($rowData[18]) ? $rowData[18] : null,
                'call' => !empty($rowData[19]) ? $rowData[19] : null,
                'sms' => !empty($rowData[20]) ? $rowData[20] : 0,
                'color' => !empty($rowData[21]) ? $rowData[21] : null,
                'barcode' => !empty($rowData[22]) ? $rowData[22] : 0,
                'new_barcode' => !empty($rowData[23]) ? $rowData[23] : null,
                'new_barcode_sl' => !empty($rowData[24]) ? $rowData[24] : null,
                'barcode_delivery' => !empty($rowData[25]) ? $rowData[25] : 0,
                'first_attend' => !empty($rowData[26]) ? $rowData[26] : null,
                'last_attend' =>  !empty($rowData[27]) ? $rowData[27] : null,
            ]);
        };

        $count = $this->moveTempUsers();

        if($count > 0){
            return response()->json([
                'status' => true,
                'message' => 'Excel Data Inserted successfully',
                'count' => $count
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'No unique data in Excel File',
        ], 200);

        
    } // End Method



    public function moveTempUsers(){
        // Step 1: Get only unique reg_no from Temp_User that are not in User_Info
        $existingRegNos = User_Info::pluck('reg_no')->toArray();

        $validTempUsers = Temp_User::whereNotIn('reg_no', $existingRegNos)
            ->get()
            ->unique('reg_no'); // keep unique reg_no only

        if($validTempUsers->count() > 0){
            // Step 2: Delete duplicates from Temp_User
            Temp_User::whereIn('reg_no', $existingRegNos)->delete();

            

            // Step 2: Get distinct branch names from Temp_User
            $branchNames = Temp_User::pluck('branch')
                ->map(fn($branch) => strtolower(rtrim($branch)))
                ->unique()
                ->values();

            // Step 3: Get already existing branches in Branch table
            $existingBranches = Branch::pluck('branch')->map(fn($branch) => strtolower(rtrim($branch)))->toArray();

            // Step 4: Find new branches that are not in Branch table
            $newBranches = $branchNames->diff($existingBranches);

            // dd($newBranches);
            // Step 5: Insert new branches into Branch table
            foreach ($newBranches as $branchName) {
                Branch::create(['branch' => ucwords($branchName)]);
            }

            // Step 3: Map branch name to branch_id
            $branches = Branch::pluck('id', 'branch')->mapWithKeys(
                fn($id, $name) => [strtolower(rtrim($name)) => $id]
            );

            foreach ($validTempUsers as $user) {
                // dd($user->branch);
                User_Info::create([
                    'sl' => GenerateSLNo() + 0,
                    'qr_url' => $user->qr_url,
                    'u_id' => $user->u_id,
                    'reg_no' => $user->reg_no,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'duplicate' => $user->duplicate,
                    'gender' => $user->gender,
                    'age' => $user->age,
                    'dob' => $user->dob,
                    'occupation' => $user->occupation,
                    'qt_status' => $user->qt_status,
                    'quantum' => $user->quantum,
                    'quantier' => $user->quantier,
                    'ardentier' => $user->ardentier,
                    'branch' => $branches[strtolower(rtrim($user->branch))] ?? null,
                    'job_status' => $user->job_status,
                    'psyche_certificate' => $user->psyche_certificate,
                    'sp' => $user->sp,
                    'group' => $user->group,
                    'call' => $user->call,
                    'sms' => $user->sms,
                    'color' => $user->color,
                    'barcode' => $user->barcode,
                    'new_barcode' => $user->new_barcode,
                    'new_barcode_sl' => $user->new_barcode_sl,
                    'barcode_delivery' => $user->barcode_delivery,
                    'first_attend' => $user->first_attend,
                    'last_attend' =>  $user->last_attend,
                ]);
            }
        }
        Temp_User::truncate();
        return $validTempUsers->count();
        
    } // End Method



    
}
