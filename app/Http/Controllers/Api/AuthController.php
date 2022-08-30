<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\User;
use App\Models\UserOnOpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //login
    public function login(Request $request) {

        $validate = Validator::make($request->only('email', 'password'), [
            'email' => ['required'],
            'password' => ['required', 'min:3', 'max:25'],
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
        }

        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login Invalid'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token  = $user->createToken('auth_token')->plainTextToken;

        $todayAbsen = Absen::where('nip', $user->nip)->where('created_at', now())->first();
        $getUserOnOpd = UserOnOpd::where('user_id', $user->id)->first();
        $isValid = NULL;
        if($getUserOnOpd ?? false) {
            if($getUserOnOpd->valid == 1) {
                $isValid = 'Tervalidasi';
            }else{
                $isValid = 'Belum Tervalidasi';
            }
        }

        $user = [
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'opd' => [
                'opd_id' => $user->useronopd->opd_id ?? NULL,
                'opd_name' => $user->useronopd->opd_name ?? NULL,
            ],
            'todayAbsen' => $todayAbsen,
            'is_valid' => $isValid,

        ];


        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return response(['message' => 'You have been successfully logged out.'], 200);
    }
}
