<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOpdRequest;
use App\Models\Opd;
use App\Services\MenusService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterController extends Controller
{
    protected $data = [];

    public function index(Request $request) {
        //check permission
        if(!PermissionService::can('users')){
            abort(403, 'This page is forbidden');
        };

        $this->data['title'] = 'Master Data';

        $MENUS = new MenusService();
        $this->data['menus'] = $MENUS->getMenu();
        return view('masters.index', [
            'datas' => $this->data
        ]);
    }

    public function storeOpd(StoreOpdRequest $request) {
        //check permission
        if(!PermissionService::can('users')){
            abort(403, 'This page is forbidden');
        };

        DB::beginTransaction();
        try{
            $result = Opd::create([
                'slug' => Str::slug(strtolower($request->opd_name)),
                'opd_name' => $request->opd_name,
                'opd_address' => $request->opd_address,
                'opd_longitude' => $request->opd_longitude,
                'opd_latitude' => $request->opd_latitude,
                'distance' => $request->opd_distance
            ]);

            if($result) {
                DB::commit();
                return response()->json(['status'=> "Success", 'message' => 'Success create new OPD'], 201);
            }

            return response()->json(['status'=> "Failed", 'message' => 'Failed create OPD'], 409);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed create new OPD.'],417);
        }
    }

    public function getOpds(Request $request){
        //check permission
        if(!PermissionService::can('users')){
            abort(403, 'This page is forbidden');
        };

        $opds = Opd::all();
        $data = [];
        foreach($opds as $key=>$opd) {
            $newData = [
                'no' => $key+1,
                'opd_name' => ucwords($opd->opd_name),
                'opd_address' => $opd->opd_address,
                'opd_longitude' => $opd->opd_longitude,
                'opd_latitude' => $opd->opd_latitude,
                'opd_distance' => $opd->distance,
                'edit' => "<button data-opd-slug='$opd->slug' class='show-user p-1 rounded bg-blue-500 hover:bg-blue-600 text-gray-200 hover:text-white shadow-lg' ><i class='fa-solid fa-eye'></i></button>"
            ];
            array_push($data, $newData);
        }

        return response()->json(['data' => $data]);
    }
}
