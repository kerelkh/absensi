<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


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
        $absenToday = Absen::where('nip', $request->user()->nip)->whereDate('created_at', Carbon::today())->get();

        return response()->json([
            'absen_today' => $absenToday ?? NULL,
        ], 200);
    }

    public function getAbsenThisMonth(Request $request) {
        $absenMonth = Absen::where('nip', $request->user()->nip)->whereMonth('created_at', Carbon::now('m'))->get();

        return response()->json(['message' => 'success', 'data' => $absenMonth]);
    }

    public function getAbsenAll(Request $request) {
        $absen = Absen::where('nip', $request->user()->nip)->get();

        return response()->json(['message' => 'success', 'data' => $absen]);
    }

    public function setPassword(Request $request) {
        $validate = Validator::make($request->all(), [
            'password' => ['required', 'min:3', 'max:25', 'alpha_num'],
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }

        $user = User::whereId($request->user()->id)->first();

        $user->password = Hash::make($request->password);

        $result = $user->save();

        if($result) {
            return response()->json(['message' => 'Berhasil update password']);
        }

        return response()->json(['error' => 'Gagal update password']);
    }

    public function setAvatar(Request $request) {
        $validate = Validator::make($request->all(), [
            'avatar' => ['required', 'image']
        ]);

        if($validate->fails()){
            return response()->json(['message' => 'error', 'error' => $validate->errors()]);
        }

        $user = User::whereId($request->user()->id)->first();

        if($user->avatar != null) {
            Storage::delete('public/' . $user->avatar);
        }

        $filename = $this->storeAvatar($user->id, $request->file('avatar'));
        if($filename) {
            $user->avatar = $filename;
            $user->save();
            return response()->json(['message' => 'berhasil update avatar']);
        }

        return response()->json(['message' => 'gagal update avatar']);

    }

    public function storeAvatar($id, $file) {
        $img = Image::make($file)->resize(null, 300, function($constraint) {
            $constraint->aspectRatio();
        });
        $filename = 'user' . $id . now()->format("YMdHis") . "file." . $file->extension();
        $img->save(storage_path('app/public/avatars/'.$filename));

        $filepath = '';
        if($img){
            $filepath = "avatars/" . $filename;
            return $filepath;
        }

        return 0;
    }
}
