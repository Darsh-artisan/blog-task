<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{UserRequest,ProfileRequest};
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ImageTrait;
use Spatie\Permission\Models\Role;
use App\Models\{User, RoleHasPermissions};
use Hash;
use DB;
use Illuminate\Support\Arr;
use Auth;
use App\Models\UserStatus;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    use ImageTrait;

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            // Get all Amenities
            $users = User::get();

            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('image', function ($row)
            {
                $default_image = asset("public/images/uploads/user_images/no-image.png");
                $image = ($row->image) ? asset('public/images/uploads/user_images/'.$row->image) : $default_image;
                $image_html = '';
                $image_html .= '<img class="me-2" src="'.$image.'" width="50" height="50">';
                return $image_html;
            })
            ->addColumn('actions',function($row)
            {
                $user_id = isset($row->id) ? $row->id : '';
                $action_html = '';
                    $action_html .= '<a href="'.route('users.edit',encrypt($user_id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';


                    if($user_id != 1){
                        $action_html .= '<a onclick="deleteUsers(\''.encrypt($user_id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';

                }

                return $action_html;
            })
            ->rawColumns(['usertype','actions','image'])
            ->make(true);
        }
        return view('admin.users.list');
    }

    public function create()
    {

        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {

            try {
                $input = $request->except('_token','image','confirm_password','password');
                $input['password'] = Hash::make($request->password);
                if ($request->hasFile('image'))
                    {
                        $file = $request->file('image');
                        $image_url = $this->addSingleImage('user','user_images',$file, $old_image = '');
                        $input['image'] = $image_url;
                    }

                $user = User::create($input);

                return redirect()->route('users')->with('message','User created successfully');
            } catch (\Throwable $th) {
                dd($th);
                return redirect()->route('users')->with('error','Something with wrong');

            }
    }

    public function edit(Request $request, $id)
    {
       $id = decrypt($id);
       $data = User::where('id',$id)->first();
       return view('admin.users.edit',compact('data','roles'));
    }

    public function update(UserRequest $request)
    {
        try {
            $input = $request->except('_token','id','password','confirm_password','image');
            $id = decrypt($request->id);

            if(!empty($request->password) || $request->password != null)
            {
                $input['password'] = Hash::make($request->password);
            }

                         if ($request->hasFile('image'))
                        {
                            $img = User::where('id',$id)->first();
                            $old_image = $img->image;
                            $file = $request->file('image');
                            $image_url = $this->addSingleImage('user','user_images',$file, $old_image = '');
                            $input['image'] = $image_url;
                        }
                        $user = User::find($id);
                        $user->update($input);

                    return redirect()->route('users')->with('message','User updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error','Something with wrong');
        }
    }

     public function destroy(Request $request)
     {
        try {
            //code...
            $id = decrypt($request->id);

            $user = User::where('id',$id)->first();

            $img = isset($user->image) ? $user->image : '';

            if (!empty($img) && file_exists('public/images/uploads/user_images/'.$img))
            {
                  unlink('public/images/uploads/user_images/'.$img);
            }

            User::where('id',$id)->delete();
            return response()->json([
                'success' => 1,
                'message' => "User delete Successfully..",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

     }

     public function profileEdit($id)
     {
        $data = User::where('id',$id)->first();
        $roles = Role::where('id',$data->role_id)->first();
       return view('admin.profile.edit',compact('data','roles'));

     }

     public function profileUpdate(ProfileRequest $request)
     {
        try {
            $input = $request->except('_token','id','password','confirm_password','image');
            $id = $request->id;

            if(!empty($request->password) || $request->password != null)
            {
                $input['password'] = Hash::make($request->password);
            }

                         if ($request->hasFile('image'))
                        {
                            $img = User::where('id',$id)->first();
                            $old_image = $img->image;
                            $file = $request->file('image');
                            $image_url = $this->addSingleImage('user','user_images',$file, $old_image = '');
                            $input['image'] = $image_url;
                        }
                        $user = User::find($id);
                        $user->update($input);
                        DB::connection('mysql')->table('model_has_roles')->where('model_id',$id)->delete();
                        $role_id = $user->role_id;
                        $roles = Role::where('id',$role_id)->first();
                        $user->assignRole($roles->name);


                    return redirect()->route('profile.edit',Auth::user()->id)->with('message','Profile updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error','Something with wrong');
        }
     }

     public function userStatus(Request $request){

        try {

            if($request->ajax()){
                $userStatus = UserStatus::get();

                return DataTables::of($userStatus)
                      ->addIndexColumn()
                      ->make(true);
            }

            return view('admin.userStatus.userStatus');
        } catch (\Throwable $th) {

           return redirect()->route('userStatus')->with('error','Internal server Error!');
        }
     }


}
