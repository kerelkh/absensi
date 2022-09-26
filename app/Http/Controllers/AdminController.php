<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Rank;
use App\Models\Role;
use App\Services\MenusService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    protected $data = [];

    public function index(Request $request) {
        if(!PermissionService::can('admin')){
            abort(403, 'This page is forbidden');
        };

        $this->data['title'] = 'Admin';

        $MENUS = new MenusService();
        $this->data['menus'] = $MENUS->getMenu();
        $this->data['roles'] = Role::where('id', 3)->orWhere('id', 4)->orWhere('id',6)->get();
        $this->data['ranks'] = Rank::all();

        return view('admin.index', [
            'datas' => $this->data
        ]);
    }
    // public function index(Request $request) {
    //     $opds = Opd::filter(['search' => $request->query('search')  ?? false])->orderBy('created_at', 'desc')->paginate(10);
    //     return view('super.index', [
    //         'opds' => $opds
    //     ]);
    // }

    // public function newOpd(Request $request) {
    //     return view('super.newOpd');
    // }

    // public function storeOpd(Request $request) {
    //     //validate
    //     $validator = $request->validate([
    //         'opd_name' => ['required', 'Regex:/^\w+( \w+)*$/i', 'unique:opds,opd_name'],
    //         'opd_address' => ['required'],
    //         'opd_longitude' => ['required', 'Regex:/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/'],
    //         'opd_latitude' => ['required', 'Regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/'],
    //         'distance' => ['required', 'numeric']
    //     ]);

    //     $newOpd = Opd::create([
    //         'opd_name' => $validator['opd_name'],
    //         'slug' => Str::slug($validator['opd_name']),
    //         'opd_address' => $validator['opd_address'],
    //         'opd_longitude' => $validator['opd_longitude'],
    //         'opd_latitude' => $validator['opd_latitude'],
    //         'distance' => $validator['distance'],
    //     ]);

    //     if($newOpd) {
    //         return redirect('/opd')->with('success', 'New OPD Added.');
    //     }

    //     return back()->with('error', 'Failed add new opd.');
    // }

    // public function edit(Request $request, $slug) {
    //     $opd = Opd::where('slug', $slug)->first();
    //     if(!$opd) { return redirect('/opd')->with('error', 'No Data Found'); }

    //     return view('super.editOpd', [
    //         'opd' => $opd
    //     ]);
    // }

    // public function storeEdit(Request $request, $slug) {
    //     $opd = Opd::where('slug', $slug)->first();
    //     if(!$opd) { return redirect('/opd')->with('error', 'No Data Found'); }

    //     //validate
    //     $validator = $request->validate([
    //         'opd_name' => ['required', 'Regex:/^\w+( \w+)*$/i', Rule::unique('opds')->ignore($opd->id)],
    //         'opd_address' => ['required'],
    //         'opd_longitude' => ['required', 'Regex:/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/'],
    //         'opd_latitude' => ['required', 'Regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/'],
    //         'distance' => ['required', 'numeric']
    //     ]);

    //     //check same
    //     if($opd->opd_name == $request->opd_name &&
    //         $opd->opd_address == $request->opd_address &&
    //         $opd->opd_longitude == $request->opd_longitude &&
    //         $opd->opd_latitude == $request->opd_latitude &&
    //         $opd->distance == $request->distance){
    //             return back()->with('error', 'No data change.');
    //         }

    //     $opd->opd_name = $request->opd_name;
    //     $opd->opd_address = $request->opd_address;
    //     $opd->opd_longitude = $request->opd_longitude;
    //     $opd->opd_latitude = $request->opd_latitude;
    //     $opd->distance = $request->distance;
    //     $opd->slug = Str::slug($request->opd_name);

    //     $result = $opd->save();

    //     if($result) {
    //         return redirect('/opd/' . $opd->slug .'/edit')->with('success', 'Update OPD success.');
    //     }

    //     return back()->with('error', 'Update Failed.');
    // }

    // public function destroyOpd(Request $request, $slug) {
    //     $opd = Opd::where('slug', $slug)->delete();

    //     if($opd) {
    //         return redirect('/opd')->with('success', 'Delete Success.');
    //     }

    //     return back()->with('error', 'Failed to delete');
    // }
}
