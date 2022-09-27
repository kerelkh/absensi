<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateDetailUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use App\Services\FileUploadService;
use App\Services\MenusService;
use App\Services\PermissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected $data = [];

    public function index(Request $request) {
        //check permission
        if(!PermissionService::can('users')){
            abort(403, 'This page is forbidden');
        };

        $this->data['title'] = 'Users';

        $MENUS = new MenusService();
        $this->data['menus'] = $MENUS->getMenu();
        $this->data['roles'] = Role::all();

        return view('users.index', [
            'datas' => $this->data
        ]);
    }

    public function getUser(Request $request, $username) {
        //check permission
        if(!PermissionService::can('create-user')){
            return response()->json(['status' => 'forbidden', 'message' => "You don't have permission"], 403);
        }

        $user = User::with(['role','userdetail','shift'])->where('username', $username)->first();

        if($user){
            return response()->json(['user' => $user]);
        }

        return response()->json(['stats' => 'failed', 'message' => 'Data not found'], 404);
    }

    public function changePasswordAllUser(ChangePasswordRequest $request) {
        //check permission
        if(!PermissionService::can('create-user')){
            return response()->json(['status' => 'forbidden', 'message' => "You don't have permission"], 403);
        }

        try{
            $result = User::where('username', $request->username)?->update([
                'password' => Hash::make($request->password),
            ]);

            if($result) {
                return response()->json(['status'=> "Success", 'message' => 'Success change password user'], 201);
            }

            return response()->json(['status'=> "Failed", 'message' => 'Failed change password user'], 409);

        }catch(\Exception $e) {
            return response()->json(['message' => 'Failed change password user.'],417);

        }
    }

    public function getUsers(Request $request) {
        //check permission
        if(!PermissionService::can('create-user')){
            return response()->json(['status' => 'forbidden', 'message' => "You don't have permission"], 403);
        }

        if($request->role ?? false){
            if(Auth::user()->role->id == 2) {
                $users = User::where('role_id', $request->role)->where('role_id', '>', 2)->where('role_id', '!=', 5)->orderBy('created_at', 'desc')->get();
            }else{
                $users = User::where('role_id', $request->role)->orderBy('created_at','desc')->get();
            }
        }else{
            if(Auth::user()->role->id == 2) {
                $users = User::where('role_id', '>', 2)->where('role_id', '!=', 5)->orderBy('created_at', 'desc')->get();
            }else{
                $users = User::orderBy('created_at','desc')->get();
            }
        }
        $data = [];
        foreach($users as $key=>$user) {
            $new = [
                'no' => $key+1,
                'username' => $user->username,
                'role' => $user->role->role_name,
                'validation' => ($user->validation == 1) ? '<span class="bg-green-400 p-1 rounded-lg text-white shadow">valid</span>' : '<span class="bg-red-400 p-1 rounded-lg text-white shadow">No valid</span>',
                'last_seen' => $user->last_seen ? Carbon::parse($user->last_seen)->diffForHumans() : '-',
                'edit' => "<button data-user='$user->username' data-role='$user->role_id' class='show-user p-1 rounded bg-blue-500 hover:bg-blue-600 text-gray-200 hover:text-white shadow-lg' ><i class='fa-solid fa-eye'></i></button>"
            ];
            array_push($data, $new);
        }

        return response()->json(['data' => $data], 200);
    }

    public function store(StoreUserRequest $request) {
        //check permission
        if(!PermissionService::can('create-user')){
            return response()->json(['status' => 'forbidden', 'message' => "You don't have permission"], 403);
        }

        DB::beginTransaction();
        try{
            $result = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => $request->role,
                'gender' => $request->gender,
                'validation' => ($request->role != 6) ? '1' : '0',
                'created_by' => Auth::user()->username,
            ]);

            if($result) {
                if($request->role == 6) {
                    UserDetail::create([
                        'user_id' => $result->id,
                    ]);
                }

                DB::commit();
                return response()->json(['status'=> "Success", 'message' => 'Success create new user'], 201);
            }

            return response()->json(['status'=> "Failed", 'message' => 'Failed create user'], 409);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed create new user.'],417);
        }
    }

    public function updateDetail(Request $request) {
        //check permission
        if(!PermissionService::can('create-user')){
            return response()->json(['status' => 'forbidden', 'message' => "You don't have permission"], 403);
        }

        $user = User::where('username', $request->user_id)->where('role_id', 6)->first();

        if(!$user){
            return response()->json(['message' => 'User not found.'],404);
        }

        $validated = $request->validate([
            'name' => ['min:3', 'max:50', 'regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/'],
            'nik' => ['size:16', Rule::unique('user_details', 'nik')->ignore($user->id, 'user_id')],
            'nip' => ['size:18', Rule::unique('user_details', 'nip')->ignore($user->id, 'user_id')],
            'email' => [Rule::unique('user_details', 'email')->ignore($user->id, 'user_id')],
            'rank' => ['integer'],
            'position' => ['min:3', 'max:255'],
            'photo' => ['image'],
        ]);

        DB::beginTransaction();
        try{
            $userDetail = UserDetail::where('user_id', $user->id)->first();
            if($request->hasFile('photo')){
                if($userDetail->photo != null) {
                    Storage::delete('public/' . $userDetail->photo);
                }

                $photoFile = FileUploadService::storeAvatar($user->id, $request->file('photo'));
            }

            $userDetail->update([
                'name' => $validated['name'] ?? '',
                'nik' => $validated['nik'] ?? '',
                'nip' => $validated['nip'] ?? '',
                'email' => $validated['email'] ?? '',
                'rank_id' => $validated['rank'] ?? '',
                'position' => $validated['position'] ?? '',
                'photo' => $photoFile ?? $userDetail->photo,
            ]);

            DB::commit();
            return response()->json(['status'=> "Success", 'message' => 'Success update detail user'], 202);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed create new user.'],417);
        }
    }
}
