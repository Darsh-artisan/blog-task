<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserStatus;
use App\Traits\ImageTrait;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ImageTrait;

    // Show Admin Login Form
    public function showAdminLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:mysql.users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',
            'image' => 'required|mimes:jpeg,png,jpg',
        ]);
        try {
            $input = $request->except('_token', 'image', 'confirm_password', 'password');
            $input['password'] = Hash::make($request->password);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $image_url = $this->addSingleImage('user', 'user_images', $file, $old_image = '');
                $input['image'] = $image_url;
            }

            $user = User::create($input);

            return redirect()->route('admin.login')->with('message', 'User created successfully');
        } catch (\Throwable $th) {

            return redirect()->route('admin.login')->with('error', 'Something with wrong');

        }
    }

    // Authenticate the Admin User
    public function Adminlogin(Request $request)
    {
        try {
            $input = $request->except('_token');
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($input)) {
                $user = Auth::user();
                if(is_object($user)){
                    return redirect()->route('dashboard')->with('message', 'Welcome '. $user->id);

                }
            }

            return back()->with('error', 'Please Enter Valid Email & Password');
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('error', 'Internal server error');
        }

    }

    public function adminVerifyEmail()
    {
        Auth::user()->update(['email_verified_at' => now()]);

        $user = auth()->user();

        $userStatus = UserStatus::where('user_id', $user->id)->first();
        if ($user->role_id != 1) {
            if (!$userStatus) {
                $userStatus = new UserStatus();
                $userStatus->user_id = $user->id;
                $userStatus->user_name = $user->name;
                $userStatus->login_date_time = now();

                $userStatus->save();
            } else {

                $userStatus->update([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'login_date_time' => now(),
                ]);
            }
        }

        return redirect()->route('dashboard')->with('message', 'Welcome ' . $user->name);
    }
}
