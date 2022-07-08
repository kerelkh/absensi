<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd;
use App\Models\UserOnOpd;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KepegawaianController extends Controller
{
    public function index(Request $request) {

        return view('adminkepegawaian.index');
    }

    public function users(Request $request) {
        return view('adminkepegawaian.users', [
            'users' => User::where('role_id', 6)->filter(['search' => $request->query('search')  ?? false])->paginate(5),
        ]);
    }

    public function showEdit(Request $request, String $email) {
        return view('adminkepegawaian.edit', [
            'user' => User::where('email', $email)->first(),
            'opds' => Opd::all()
        ]);
    }

    public function storeEdit(Request $request, String $email) {
        //checkSame
        $user = User::where('email', $email)->first();
        if($user->name == $request->name &&
            $user->email == $request->email &&
            $user->nip == $request->nip) {
                return back()->with('error', 'Gagal Update, Tidak ada data yang diubah');
            }

        //validator
        $validate = $request->validate([
            'email' => ['required', 'email:rfc,dns', 'unique:users,email,' . $user->id],
            'name' => ['required', 'min:3', 'max:50'],
            'nip' => ['required', 'size:18']
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;

        $result = $user->update();

        if($result){
            return redirect('/admin/kepegawaian/' . $user->email . '/edit')->with('success', 'Update berhasil');
        }

        return back()->with('error', 'Gagal Update, Hubungi administrator');

    }

    public function updateOpd(Request $request, String $email) {
        $user = User::where('email', $email)->first();

        //checkIfUser has OPD or NOT
        $getUserOnOpd = UserOnOpd::where('user_id', $user->id)->first();

        //checkSame
        if($getUserOnOpd){
            if($getUserOnOpd->opd_id == $request->opd){
                return back()->with('error', 'Gagal update, tidak ada perubahan');
            }
        }else{
            if($getUserOnOpd == $request->opd){
                return back()->with('error', 'Gagal update, tidak ada perubahan');
            }
        }

        //if not same then create if not have opd or update if opd
        if($getUserOnOpd){
            //update
           if($request->opd == NULL) {
                $result = $getUserOnOpd->delete();

                if($result) {
                    return redirect('/admin/kepegawaian/' . $email . '/edit')->with('success', 'Update OPD Berhasil');
                }

                return back()->with('error', 'Gagal Update OPD');
           }else{
                $getUserOnOpd->opd_id = $request->opd;
                $result = $getUserOnOpd->update();

                if($result) {
                    return redirect('/admin/kepegawaian/' . $email . '/edit')->with('success', 'Update OPD Berhasil');
                }

                return back()->with('error', 'Gagal Update OPD');
           }
        }

        $result = UserOnOpd::create([
            'valid' => 0,
            'is_super' => 0,
            'user_id' => $user->id,
            'opd_id' => $request->opd
        ]);

        if($result) {
            return redirect('/admin/kepegawaian/' . $email . '/edit')->with('success', 'Update OPD Berhasil');
        }

        return back()->with('error', 'Gagal Update OPD');

    }

    public function updatePassword(Request $request, String $email) {

        $validate = $request->validate([
            'password' => ['required', 'min:3', 'max:25', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        $user = User::where('email', $email)->first();

        $user->password = Hash::make($request->password);

        $result = $user->update();

        if($result) {
            return redirect('/admin/kepegawaian/' . $email . '/edit')->with('success', 'Update Password Berhasil.');
        }

        return back()->with('error', 'Gagal Update Password');
    }

    public function updateDetail(Request $request, String $email) {

        $user = User::where('email', $email)->first();

        $userDetail = UserDetail::where('user_id', $user->id)->first();
        $validate = $request->validate([
            'nik' => ['required', 'size:16', 'unique:user_details,nik,' . $userDetail->id],
            'pangkat' => ['required', 'min:2', 'max:50'],
            'jabatan' => ['required', 'min:2', 'max:50']
        ]);

        //checksame
        if($userDetail->nik == $request->nik &&
            $userDetail->pangkat == $request->pangkat &&
            $userDetail->jabatan == $request->jabatan){
                return back()->with('error', 'Gagal Update Detail, Tidak ada perubahan');
            }

        $result = $userDetail->update([
            'nik' => $validate['nik'],
            'pangkat' => $validate['pangkat'],
            'jabatan' => $validate['jabatan'],
        ]);

        if($result) {
            return redirect('/admin/kepegawaian/'. $user->email .'/edit')->with('success', 'Update Detail Success');
        }

        return back()->with('error', 'Gagal Update Detail.');

    }
}
