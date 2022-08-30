<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Models\Opd;
use App\Models\UserOnOpd;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KepegawaianController extends Controller
{
    public function index(Request $request) {

        return view('adminkepegawaian.index');
    }

    public function users(Request $request) {
        return view('adminkepegawaian.users', [
            'users' => User::where('role_id', 6)->filter(['search' => $request->query('search')  ?? false])->orderBy('created_at', 'desc')->paginate(12),
        ]);
    }

    public function formUser(Request $request) {
        $pangkats = [
            'Juru Muda / Ia',
            'Juru Muda Tingkat I / Ib',
            'Juru / Ic',
            'Juru Tingkat I / Id',
            'Pengatur Muda / IIa',
            'Pengatur Muda Tingkat I / IIb',
            'Pengatur / IIc',
            'Pengatur Tingkat I / IId',
            'Penata Muda / IIIa',
            'Penata Muda Tingkat I/ IIIb',
            'Penata / IIIc',
            'Penata Tingkat I / IIId',
            'Pembina / IVa',
            'Pembina Tingkat I / IVb',
            'Pembina Muda / IVc',
            'Pembina Madya / IVd',
            'Pembina Utama / IVe',


        ];

        return view('adminkepegawaian.add', [
            'opds' => Opd::all(),
            'pangkats' => $pangkats
        ]);
    }

    public function storeUser(Request $request) {
        $validate = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'email' => ['required', 'unique:users,email'],
            'nip' => ['required', 'size:18', 'unique:users,nip'],
            'password' => ['required', 'min:3', 'max:25'],
            'nik' => ['required', 'size:16', 'unique:user_details,nik'],
            'pangkat' => ['required', 'min:3', 'max:50'],
            'jabatan' => ['required', 'min:3', 'max:50']
        ]);
        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'nip' => $validate['nip'],
            'password' => Hash::make($validate['password']),
            'role_id' => 6,
            'avatar' => '',
        ]);

        //avatar
        $avatarFile = '';
        if($request->hasFile('avatar')){
            $avatarFile = $this->storeAvatar($user->id, $request->file('avatar'));
            $user->avatar = $avatarFile;
            $user->save();
        }


        $result = UserDetail::create([
            'nik' => $validate['nik'],
            'pangkat' => $validate['pangkat'],
            'jabatan' => $validate['jabatan'],
            'user_id' => $user->id,
        ]);

        if($result) {
            return redirect('/admin/kepegawaian/adduser')->with('success', 'User berhasil ditambah');
        }

        return back()->with('error', 'Gagal menambah user.');
    }

    public function showEdit(Request $request, String $email) {
        $user = User::where('email', $email)->where('role_id', 6)->first();
        if(!$user) {
            return redirect('/admin/kepegawaian/users')->with('error', 'data tidak ditemukan');
        }
        return view('adminkepegawaian.edit', [
            'user' => $user,
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
            return redirect('/admin/kepegawaian/' . $user->email. '/edit')->with('success', 'Update Berhasil');
        }

        return back()->with('error', 'Update Gagal.');
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
            if($user->role_id == 3) {
                return redirect('/admin/kepegawaian/admins/' . $email . '/edit')->with('success', 'Update Password Berhasil.');
            }
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
            'jabatan' => ['required', 'min:2', 'max:50'],
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

    public function admins(Request $request) {

        return view('adminkepegawaian.admins', [
            'admins' => User::where('role_id', 3)->filter(['search' => $request->query('search')])->orderBy('created_at', 'desc')->paginate(5)
        ]);
    }

    public function formAdmin(Request $request) {
        return view('adminkepegawaian.addAdmin', [
            'opds' => Opd::all(),
        ]);
    }

    public function storeNewAdmin(Request $request) {
        $validate = $request->validate([
            'name' => ['required', 'min:3' ,'max:50'],
            'email' => ['required', 'unique:users,email'],
            'nip' => ['required', 'size:18', 'unique:users,nip'],
            'password' => ['required', 'min:3', 'max:25'],
            'opd' => ['required']
        ]);

        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'nip' => $validate['nip'],
            'password' => Hash::make($validate['password']),
            'role_id' => 3
        ]);

        if($user){
            //check opd
            if($request->opd ?? false) {
                UserOnOpd::create([
                    'is_super' => 1,
                    'user_id' => $user->id,
                    'opd_id' => $request->opd,
                    'valid' => 1
                ]);
            }

            return redirect('/admin/kepegawaian/admins')->with('success', 'Berhasil manambah Admin Dinas');
        }

        return back()->with('error', 'Gagal Menambag Admin Dinas.');
    }

    public function showEditAdmin(Request $request, String $email) {

        $admin = User::where('email' ,$email)->first();

        return view('adminkepegawaian.editAdmin', [
            'admin' => $admin,
            'opds' => Opd::all(),
        ]);
    }

    public function storeUpdateAdmin(Request $request, String $email) {
        $admin = User::where('email' , $email)->first();
        $getUserOnOpd = UserOnOpd::where('user_id', $admin->id)->first();

        $validate = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'email' => ['required', 'email:rfc,dns', 'unique:users,email,' . $admin->id],
            'nip' => ['required', 'size:18'],
        ]);

        //check same
        if($admin->name == $validate['name'] &&
            $admin->email == $validate['email'] &&
            $admin->nip == $validate['nip']) {
                if($getUserOnOpd ?? false){
                    if($getUserOnOpd->opd_id == $request->opd){
                        return back()->with('error', 'Gagal update, tidak ada perubahan data.');
                    }
                }else{
                    if($request->opd == NULL){
                        return back()->with('error', 'Gagal update, tidak ada perubahan data.');
                    }
                }
            }

        $admin->name = $validate['name'];
        $admin->email = $validate['email'];
        $admin->nip = $validate['nip'];

        if($getUserOnOpd ?? false){
            if($request->opd ?? false){
                //update useronopd
                $getUserOnOpd->update([
                    'opd_id' => $request->opd,
                ]);

            }else{
                //delete useronopd
                $getUserOnOpd->delete();
            }
        }else{
            if($request->opd ?? false) {
                UserOnOpd::create([
                    'valid' => 1,
                    'is_super' => 1,
                    'user_id' => $admin->id,
                    'opd_id' => $request->opd
                ]);
            }
        }

        $result = $admin->update();

        if($result) {
            return redirect('/admin/kepegawaian/admins/'. $admin->email. '/edit')->with('success', 'Berhasil Update Admin Dinas.');
        }

        return back()->with('error', 'Gagal update Admin Dinas.');
    }

    public function deleteAdmin(Request $request, String $email) {
        $admin = User::where('email', $email)->where('role_id', 3)->first();
        if($admin) {
            $result = $admin->delete();
            return redirect('/admin/kepegawaian/admins')->with('success', 'Admin has been deleted.');
        }

        return back()->with('error', 'Failed delete admin.');
    }

    public function storeAvatar($id, $file) {
        $filename = 'user' . $id . now()->format("YMdHis") . "avatar." . $file->extension();
        $path = $file->storeAs('public/avatars', $filename);
        $filepath = '';
        if($path){
            $filepath = "avatars/" . $filename;

            return $filepath;
        }

        return 0;
    }

    public function news(Request $request) {
        if($request->input('search')){
            $newses = News::where('title', 'LIKE', '%' . $request->search . '%')->orWhere('content', 'LIKE' , '%' . $request->search . '%')->orderBy('created_at', 'desc')->paginate(5)->withQueryString();
        }else{
            $newses = News::orderBy('created_at', 'desc')->paginate(5)->withQueryString();
        }
        return view('adminkepegawaian.news', [
            'newses' => $newses,
        ]);
    }

    public function storeNews(Request $request) {
        $validate = $request->validate([
            'title' => ['required', 'unique:news,title'],
            'content' => ['required'],
            'image' => ['required', 'image']
        ]);

        $filename = $this->storeImage($request->file('image'));

        $news = News::create([
            'slug' => Str::slug($validate['title']),
            'title' => $validate['title'],
            'content' => $validate['content'],
            'image' => $filename,
        ]);

        if($news) {
            return redirect('/admin/kepegawaian/news')->with('success', 'Berita berhasil di Simpan.');
        }

        return back()->with('error', 'Berita gagal di simpan.');
    }

    public function storeImage($file) {
        $filename = 'image' . now()->format("YMdHis") . "news." . $file->extension();
        $path = $file->storeAs('public/news', $filename);
        $filepath = '';
        if($path){
            $filepath = "news/" . $filename;

            return $filepath;
        }

        return 0;
    }

    public function editNews(Request $request, $slug) {
        $news = News::where("slug", $slug)->first();

        return view('adminkepegawaian.editNews', [
            'news' => $news,
        ]);
    }

    public function updateNews(Request $request, $slug) {
        $news = News::where('slug', $slug)->first();
        if(!$news) { return back()->with('error', 'Berita tidak ada.'); }
        $validate = $request->validate([
            'title' => ['required', Rule::unique('news')->ignore($news->id)],
            'content' => ['required']
        ]);

        //checksame
        if($request->title == $news->title && $request->content == $news->content && $request->file('image') == NULL){
            return back()->with('error', 'No change in data.');
        }

        $news->slug = Str::slug($validate['title']);
        $news->title = $validate['title'];
        $news->content = $validate['content'];

        if($request->hasFile('image')){
            //delete image
            $result = Storage::delete('/public/' .$news->image);
            if($result) {
                $news->image = $this->storeImage($request->file('image'));
            }
        }

        $result = $news->save();

        if($result) {
            return redirect('/admin/kepegawaian/news/' . $news->slug . '/edit')->with('success', 'Update Success');
        }

        return back()->with('error', 'Berita gagal update.');
    }
}
