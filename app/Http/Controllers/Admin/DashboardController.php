<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserStatus;

class DashboardController extends Controller
{
    // Dashboard View
    public function index()
    {
        return view('admin.dashboard.dashboard');
    }

    // Admin Logout
    public function adminLogout()
    {

        $user = auth()->user();
        $userStatus = UserStatus::where('user_id',$user->id)->first();
         
        if($user->role_id != 1){
            if(!$userStatus){
                $userStatus = new UserStatus();
                $userStatus->user_id = $user->id;
                $userStatus->user_name = $user->name;
                $userStatus->logout_date_time = now();
                $userStatus->save();
            }else{
                $userStatus->update([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                   'logout_date_time' => now(),
                ]);
            }
        }
        
        Auth::logout();
        session()->flush();
        return redirect()->route('admin.login');
    }
}
