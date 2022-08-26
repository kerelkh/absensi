<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\User;
use App\Models\UserOnOpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class DinasController extends Controller
{
    public function index(Request $request) {
        if(Auth::user()->useronopd ?? false){
        $validateUsers = User::where('role_id', 6)->filterOpd(['id'=> Auth::user()->useronopd->opd_id])->filterValid(['valid'=> 'valid'])->count();
        $nonValidateUsers = User::where('role_id', 6)->filterOpd(['id'=> Auth::user()->useronopd->opd_id])->filterValid(['valid'=> 'not-valid'])->count();
        }


        return view('admindinas.index', [
            'validateUsers' => $validateUsers ?? NULL,
            'nonValidateUsers' => $nonValidateUsers ?? NULL,
        ]);
    }

    public function users(Request $request) {
        if(Auth::user()->useronopd ?? false){
            $users = User::where('role_id', 6)->filterOpd(['id' => Auth::user()->useronopd->opd_id])->filter(['search' => $request->query('search')])->orderBy('updated_at', 'desc')->paginate(5);
        }
        return view('admindinas.users', [
            'users' => $users ?? NULL,
        ]);
    }

    public function searchUser(Request $request) {
        $useronopd = UserOnOpd::select('user_id')->get();
        $users = User::where('role_id', 6)->filter(['search' => $request->query('search')  ?? false])->whereNotIn('id', $useronopd)->orderBy('created_at', 'desc')->paginate(9);
        return view('admindinas.search', [
            'users' => $users
        ]);
    }

    public function showUser(Request $request, String $email) {
        if(!Auth::user()->useronopd ?? false){
            return back()->with('error', 'Kamu tidak memiliki access.');
        }
        // $user  = User::where('email', $email)->filterOpd(['id' => Auth::user()->useronopd->opd_id])->first();
        $user  = User::where('email', $email)->first();

        if(!$user) {
            return back()->with('error', 'User tidak ada.');
        }
        return view('admindinas.show', [
            'user' => $user,
        ]);
    }

    public function updateOpd(Request $request, String $email) {
        $user = User::where('email', $email)->first();
        $currentOpd = Auth()->user()->useronopd->opd->id;

        //checkIfUser has OPD or NOT
        $getUserOnOpd = UserOnOpd::where('user_id', $user->id)->first();

        //if not same then create if not have opd or update if opd
        if($getUserOnOpd){
            //delete
            $result = $getUserOnOpd->delete();
        }

        $result = UserOnOpd::create([
            'valid' => 0,
            'is_super' => 0,
            'user_id' => $user->id,
            'opd_id' => $currentOpd
        ]);

        if($result) {
            return redirect('/admin/dinas/searchuser')->with('success', 'Update OPD Berhasil');
        }

        return back()->with('error', 'Gagal Update OPD');

    }

    public function deleteFromOpd(Request $request, String $email){
        $user = User::where('email', $email)->first();
        $result = UserOnOpd::where('user_id', $user->id)->delete();

        if($result) {
            return redirect('/admin/dinas/users')->with('success', 'User berhasil dikeluarkan dari opd.');
        }

        return back()->with('error', 'Gagal Mengeluarkan User dari OPD.');
    }
}
