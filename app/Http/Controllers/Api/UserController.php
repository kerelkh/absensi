<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request) {
        $user = $request->user();
        $userDetail = UserDetail::where('user_id' , $request->user()->id)->first();

        $data = [
            'user' =>
            $user,
            'user_detail' =>
            $userDetail,
        ];

        return response()->json([
            'code' => 200,
            'data' => $data
        ], 200);
    }
    public function getUserDetail(Request $request) {
        $userDetail = UserDetail::where('user_id' , $request->user()->id)->first();

        return response()->json([
            'user_detail' => $userDetail
        ], 200);
    }

    public function getAbsenToday(Request $request) {
        $absenToday = Absen::where('nip', $request->user()->nip)->whereDate('created_at', Carbon::today())->first();

        return response()->json([
            'absen_today' => $absenToday ?? NULL,
        ], 200);
    }
}
