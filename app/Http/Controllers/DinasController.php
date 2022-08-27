<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\User;
use App\Models\Absen;
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

        $absens = Absen::whereDate('created_at', now()->format('Y-m-d'))->orderBy('created_at', 'desc')->paginate(20);


        return view('admindinas.index', [
            'validateUsers' => $validateUsers ?? NULL,
            'nonValidateUsers' => $nonValidateUsers ?? NULL,
            'absens' => $absens
        ]);
    }

    public function updateValidAbsen(Request $request, $id){
        $absen = Absen::where('id', $id)->first();
        $absen->valid = $absen->valid ? 0 : 1;
        $result = $absen->save();
        if($result) {
            return back()->with('success', 'Berhasil validasi absen');
        }

        return back()->with('error', 'Gagal validasi absen.');
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

    public function detailUser(Request $request, String $email) {
        $user = User::where('email', $email)->first();
        if(!$user) { return back()->with('error', 'there is no such user.'); }

        if($request->date){
            $arrDate = explode("-", $request->date);
            $absens = Absen::whereMonth('created_at', $arrDate[1])->where('opd_name', $user->useronopd->opd->opd_name)->get();
        }else{
            $absens = Absen::where('nip', $user->nip)->where('opd_name', $user->useronopd->opd->opd_name)->get();
        }

        return view('admindinas.detailUser', [
            'absens' => $absens,
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
            return redirect('/admin/dinas/searchuser')->with('success', 'Ambil Pegawai Berhasil');
        }

        return back()->with('error', 'Gagal Ambil Pegawai');

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
