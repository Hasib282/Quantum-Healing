<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Login_User;
use App\Models\User_Info;
use Illuminate\Support\Facades\Cache;


// --------------------------------------- Get Transaction Type Data -------------------------------- //
// This Helper Function is for Getting Transaction Type Data 
if (!function_exists('GetTranType')) {
    function GetTranType($type) {
        $segments = [
            'admin' => 2,
            'transaction' => 1,
            'hr' => 3,
            'inventory' => 5,
            'pharmacy' => 6,
            'hospital' => 7, 
            'hotel' => 8,
        ];

        return $segments[$type] ?? null;
    }
}





// --------------------------------------- Get Auth User Data -------------------------------- //
// This Helper Function is for Getting Login User Data 
if (!function_exists('UserData')) {
    function UserData() {
        return Auth::user();
    }
}

// This Helper Function is for Getting Login User Role 
if (!function_exists('UserRole')) {
    function UserRole() {
        return Auth::user()->user_role;
    }
}

// This Helper Function is for Getting Login User Company
if (!function_exists('UserCompany')) {
    function UserCompany() {
        return Auth::user()->company_id;
    }
}

// This Helper Function is for Getting Login User Store 
if (!function_exists('UserStore')) {
    function UserStore() {
        return Auth::user()->store_id;
    }
}

// This Helper Function is for Getting Login User Store 
if (!function_exists('UserPermissions')) {
    function UserPermissions() {
        $userPermissions = Cache::get("permission_ids_". Auth::user()->user_id);
        if(!$userPermissions){
            $user_data = Auth::user();
            $userPermissions = Cache::rememberForever("permission_ids_". Auth::user()->user_id, function () use ($user_data) {
                return $user_data->permissions->pluck('id')->unique()->toArray();
            });
        }
        return $userPermissions;
    }
}



// --------------------------------------- Generate User IDs -------------------------------- //
// This Helper Function is for Creating Custom User Ids 
if (!function_exists('GenerateUserId')) {
    function GenerateUserId($role, $prefix) {
        $latestId = User_Info::on('mysql_second')->select('user_id')->where('user_role', $role)->orderBy('user_id','desc')->first();
        return $id = $latestId ? $prefix . str_pad((intval(substr($latestId->user_id, 2)) + 1), 9, '0', STR_PAD_LEFT) : $prefix .'000000001';
    }
}



// This Helper Function is for Creating Custom Login User Ids 
if (!function_exists('GenerateLoginUserId')) {
    function GenerateLoginUserId($role, $prefix) {
        $latestId = Login_User::on('mysql')->select('user_id')->where('role', $role)->orderBy('user_id', 'desc')->first();
        return $latestId ? $prefix . str_pad((intval(substr($latestId->user_id, 2)) + 1), 9, '0', STR_PAD_LEFT) : $prefix . '000000001';
    }
}




// --------------------------------------- Store Images -------------------------------- //
// This Helper Function is for Creating and Storing Image Name
if (!function_exists('StoreUserImage')) {
    function StoreUserImage($req, $id) {
        if ($req->hasFile('image') && $req->file('image')->isValid()) {
            if(Str::startsWith($id, 'CO')) {
                $imageName = $id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                return $req->file('image')->storeAs('company/logos', $imageName);
            }
            else if(Str::startsWith($id, 'SA')){
                $imageName = $id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                return $req->file('image')->storeAs('super_admin_profiles', $imageName);
            }
            else if(Str::startsWith($id, 'AD')) {
                $imageName = '('. $req->company . ')'.$id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                return $req->file('image')->storeAs('company/'. strtolower($req->company) . '/admin', $imageName);
            }
            else if(Str::startsWith($id, 'EM')) {
                $imageName = '('. $req->company . ')'.$id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                return $req->file('image')->storeAs('company/'. strtolower($req->company) . '/employees', $imageName);
            }




            else if(Str::startsWith($id, 'CL')) {
                $imageName = '('. $req->company . ')'.$id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                return $req->file('image')->storeAs('clients', $imageName);
            }
            else if(Str::startsWith($id, 'SU')) {
                $imageName = '('. $req->company . ')'.$id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                return $req->file('image')->storeAs('suppliers', $imageName);
            }
        }
        return null;
    }
}



// This Helper Function is for Updating and Storing Image Name
if (!function_exists('UpdateUserImage')) {
    function UpdateUserImage($req, $current_image, $company_id, $user_id) {
        if($req->image != null){
            $req->validate([
                "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            //process the image name and store it to storage/app/public/profiles directory
            if ($req->hasFile('image') && $req->file('image')->isValid()) {
                if($current_image){
                    Storage::disk('public')->delete($current_image);
                }
                

                if(Str::startsWith($user_id, 'CO')) {
                    $imageName = $user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    return $req->file('image')->storeAs('company/logos', $imageName);
                }
                else if(Str::startsWith($user_id, 'SA')){
                    $imageName = $user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    return $req->file('image')->storeAs('super_admin_profiles', $imageName);
                }
                else if(Str::startsWith($user_id, 'AD')) {
                    $imageName = '('. $company_id . ')'.$user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    return $req->file('image')->storeAs('company/'. strtolower($company_id) . '/admin', $imageName);
                }
                else if(Str::startsWith($user_id, 'EM')) {
                    $imageName = '('. $company_id . ')'.$user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    return $req->file('image')->storeAs('company/'. strtolower($company_id) . '/employees', $imageName);
                }




                else if(Str::startsWith($user_id, 'CL')) {
                    $imageName = '('. $company_id . ')'.$user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    return $req->file('image')->storeAs('clients', $imageName);
                }
                else if(Str::startsWith($user_id, 'SU')) {
                    $imageName = '('. $company_id . ')'.$user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    return $req->file('image')->storeAs('suppliers', $imageName);
                }
            }
        }
        else{
            return $current_image;
        }
    }
}