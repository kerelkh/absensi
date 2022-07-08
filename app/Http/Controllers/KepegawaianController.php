<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd;
use App\Models\UserOnOpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KepegawaianController extends Controller
{
    public function index(Request $request) {

        return view('adminkepegawaian.index');
    }

    public function users(Request $request) {
        return view('adminkepegawaian.users', [
            'users' => User::where('role_id', 6)->paginate(5),
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
}
