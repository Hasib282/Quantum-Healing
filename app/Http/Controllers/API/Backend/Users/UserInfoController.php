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
        set_time_limit(3600);

        $filePath = $req->file('file')->getRealPath();
        $data = readXlsxRaw($filePath);
        // dd($data);
        $isHeader = true;
        $insertData = [];
        foreach ($data as $key => $item) {
            // Skip header
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            if (!empty($item[8]) && is_numeric($item[8])) {
                $date = excelDateToPhp((float)$item[8]);       // Try to convert numeric values to dates
                if ($date !== $item[8]) {                      // Only replace if it looks like a valid date
                    $item[8] = $date;
                }
            }

            if ($item[1]) {
                // Calculate DOB from Age (approximate)
                $age = (int) $item[1];
                $dob = !empty($item[8]) ? $item[8] : now()->subYears($age)->format('Y-m-d');
            } else {
                // Calculate DOB from Age (approximate)
                $age = null;
                $dob = !empty($item[8]) ? $item[8] : null;
            }

            // Insert into insertData array
            $insertData[] = [
                'gender' => $item[0],
                'age' => $age,
                'occupation' => !empty($item[2]) ? $item[2] : null,
                'qt_status' => $item[3],
                'name' => $item[4],
                'branch' => !empty($item[5]) ? $item[5] : null,  
                'reg_no' => $item[6],
                'phone' => $item[7],
                'dob' => $dob,
            ];
        };


        if (empty($insertData)) {
            return response()->json([
                'status' => false,
                'message' => 'No data found in file.'
            ], 200);
        }


        // DB::transaction(function () use ($insertData) {
        //     if (!empty($insertData)) {
        //         foreach (array_chunk($insertData, 1500) as $chunk) {
        //             Temp_User::insert($chunk);
        //         }
        //     }

        //     $count = $this->moveTempUsers();
        // });


        // if($count > 0){
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Excel Data Inserted successfully',
        //         'count' => $count
        //     ], 200);
        // }

        // return response()->json([
        //     'status' => false,
        //     'message' => 'No unique data in Excel File',
        // ], 200);


        $count = 0;

        DB::transaction(function () use ($insertData, &$count) {
            // Step 1: Remove already existing reg_no
            $regNos = array_column($insertData, 'reg_no');
            $existing = User_Info::whereIn('reg_no', $regNos)->pluck('reg_no')->toArray();

            $filteredData = array_filter($insertData, function ($row) use ($existing) {
                return !in_array($row['reg_no'], $existing);
            });

            if (empty($filteredData)) {
                return response()->json([
                    'status' => false,
                    'message' => 'No unique data in Excel File',
                ], 200);
            }

            // Step 2: Handle branches
            $branchNames = collect($filteredData)
                ->pluck('branch')
                ->filter()
                ->map(fn($b) => strtolower(trim($b)))
                ->unique();

            $existingBranches = Branch::pluck('branch')->map(fn($b) => strtolower(trim($b)))->toArray();

            $newBranches = $branchNames->diff($existingBranches);
            if ($newBranches->isNotEmpty()) {
                $branchInsert = [];
                foreach ($newBranches as $branchName) {
                    $branchInsert[] = ['branch' => ucwords($branchName)];
                }
                Branch::insert($branchInsert);
            }

            $sl = GenerateSLNo() + 0;
            // Step 3: Get branch mapping
            $branches = Branch::pluck('id', DB::raw('LOWER(TRIM(branch)) as branch'));

            // Step 4: Replace branch names with branch IDs
            $finalData = collect($filteredData)->map(function ($user) use ($branches, &$sl) {
                $user['branch'] = $user['branch']
                    ? $branches[strtolower(trim($user['branch']))] ?? null
                    : null;
                $user['sl'] = $sl;
                $user['image'] = 'qt_img/'.$sl.'.jpeg';
                $sl++;
                return $user;
            })->toArray();

            $count = count($finalData);

            // Step 5: Bulk Insert in chunks
            foreach (array_chunk($finalData, 1500) as $chunk) {
                User_Info::insert($chunk);
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Excel Data Inserted successfully',
            'count' => $count
        ], 200);
    } // End Method
}
