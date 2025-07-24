<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login_User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function role(){
    //     return $this->belongsTo(Role::class,'role','id');
    // }

    // public function Roles(){
    //     return $this->belongsTo(Role::class,'role','id');
    // }
    
    // public function Company(){
    //     return $this->belongsTo(Company_Details::class,'company_id','company_id');
    // }

    // public function Department(){
    //     return $this->belongsTo(Department::class,'dept_id','id');
    // }

    // public function Location(){
    //     return $this->belongsTo(Location_Info::class,'loc_id','id');
    // }

    // public function Designation(){
    //     return $this->belongsTo(Designation::class,'designation_id','id');
    // }


    // public function Withs(){
    //     return $this->belongsTo(Transaction_With::class,'tran_user_type','id');
    
    // }

    // public function personalDetail()
    // {
    //     return $this->belongsTo(Employee_Personal_Detail::class, 'user_id', 'employee_id');
    // }

    // public function educationDetail()
    // {
    //     return $this->belongsTo(Employee_Education_Detail::class, 'user_id', 'emp_id');
    // }

    // public function educationDetails()
    // {
    //     return $this->hasMany(Employee_Education_Detail::class);
    // }


    // public function trainingDetail()
    // {
    //     return $this->belongsTo(Employee_Training_Detail::class, 'user_id', 'emp_id');
    // }

    // public function experienceDetail()
    // {
    //     return $this->belongsTo(Employee_Experience_Detail::class, 'user_id', 'emp_id');
    // }

    // public function organizationDetail()
    // {
    //     return $this->belongsTo(Employee_Organization_Detail::class, 'user_id', 'emp_id');
    // }

    // ///// client base due find for user_type Login_User Table /////////
    
    // public function transaction()
    // {
    //     return $this->hasMany(Transaction_Main::class, 'tran_user', 'user_id');
    // }


    // // Creating many to many relationship with permission table by creating a pivot table connection
    // public function permissions(){
    //     return $this->belongsToMany(Permission_Head::class, 'permission__users', 'user_id', 'permission_id', 'user_id', 'id');
    // }

    
    // public function role(){
    //     return $this->hasOne(Role::class, 'id', 'user_role');
    // }
    

    // // Check if User has Permission To the Sidebar Main Heads
    // public function hasPermissionMainHead($id){
    //     if ($this->user_role == 1) {
    //         return true;
    //     }

    //     $cacheKey = "permission_mainheads_{$this->user_id}";

    //     $mainheads = Cache::get($cacheKey);

    //     if (!$mainheads) {
    //         $mainheads = $this->permissions->pluck('permission_mainhead')->unique()->toArray();
            
    //         Cache::put($cacheKey, $mainheads, now()->addHours(3000));
    //     }
    //     return in_array($id, $mainheads);
    // }

    // // Check If User has permission to the routes
    // // public function hasPermissionToRoute($route){
    // //     if($this->user_role == 1){
    // //         return true;
    // //     }

    // //     $cacheKey = "route_permissions_{$this->user_id}";

    // //     $permissions = Cache::get($cacheKey);

    // //     // If not cached, fetch from the database and store in cache
    // //     if (!$permissions) {
    // //         $permissions = Permission_User::where('user_id', $this->user_id)
    // //             ->with('permission.routes') // Fetch related routes if needed
    // //             ->get()
    // //             ->flatMap(function ($permission) {
    // //                 return $permission->permission->routes->pluck('route_name');
    // //             })->unique()->toArray();

    // //         Cache::put($cacheKey, $permissions, now()->addHours(3000));
    // //     }
    // //     return in_array($route, $permissions);
    // // } // End Method


    // // Check If User has specific permission id
    // public function hasPermission($id){
    //     if ($this->user_role == 1) {
    //         return true;
    //     }

    //     $cacheKey = "permission_ids_{$this->user_id}";

    //     $permission = Cache::get($cacheKey);

    //     // If not cached, fetch from the database and store in cache
    //     if (!$permission) {
    //         $permission = $this->permissions->pluck('id')->unique()->toArray();

    //         Cache::put($cacheKey, $permission, now()->addHours(3000));
    //     }
    //     return in_array($id, $permission);
    // }
}
