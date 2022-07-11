<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOnOpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DinasController extends Controller
{
    public function index(Request $request) {
        return view('admindinas.index');
    }

    public function users(Request $request) {
        if(Auth::user()->useronopd ?? false){
            $users = User::where('role_id', 6)->filterOpd(['id' => Auth::user()->useronopd->opd_id])->filter(['search' => $request->query('search')])->orderBy('updated_at', 'desc')->paginate(5);
        }
        return view('admindinas.users', [
            'users' => $users ?? NULL,
        ]);
    }

    public function showUser(Request $request, String $email) {
        if(!Auth::user()->useronopd ?? false){
            return back()->with('error', 'Kamu tidak memiliki access.');
        }
        $user  = User::where('email', $email)->filterOpd(['id' => Auth::user()->useronopd->opd_id])->first();

        if(!$user) {
            return back()->with('error', 'User tidak ada.');
        }

        return view('admindinas.show', [
            'user' => $user
        ]);
    }

    public function updateValidation(Request $request, String $email) {
        //check same
        $user = User::where('email', $email)->first();

        $userOnOpd = UserOnOpd::where('user_id', $user->id)->first();

        if($userOnOpd->valid == $request->valid){
            return back()->with('error', 'Gagal update, tidak ada perubahan.');
        }

        $userOnOpd->valid = $request->valid;
        $result = $userOnOpd->update();

        if($result) {
            return redirect('/admin/dinas/' . $user->email. '/edit')->with('success', 'Update Berhasil');
        }

        return back()->with('error', 'Update Gagal.');
    }
}
