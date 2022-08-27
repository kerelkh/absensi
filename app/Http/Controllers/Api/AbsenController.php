<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AbsenController extends Controller
{
    public function absenMasuk(Request $request) {
        //check valid
        if($request->user()->useronopd ?? false) {
            if($request->user()->useronopd->valid == 0) {
                return response()->json([
                    'message' => 'Akun user belum tervalidasi.'
                ], 200);
            }
        }else{
            return response()->json([
                'message' => 'Akun user belum terkait dengan OPD manapun.'
            ], 200);
        }

        $absenToday = Absen::where('nip', $request->user()->nip)->whereDate('created_at', Carbon::today())->where('absen_jenis', 0)->first();

        //check if absen masuk already exist
        if($absenToday ?? false) {
            return response()->json(['message' => 'Sudah absen masuk', 'absen' => true]);
        }

        //check validation here
        $validator = Validator::make($request->only('longitude', 'latitude', 'avatar'), [
            'longitude' => ['required'],
            'latitude' => ['required'],
            // 'photo' => ['required']
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        //check if user is super
        $isSuper = $request->user()->useronopd->is_super;

        // check distance here
        // $lat1 = -3.6624580830263196;
        // $long1 = 102.57108801123447;
        $lat1 = $request->user()->useronopd->opd->opd_latitude;
        $long1 = $request->user()->useronopd->opd->opd_longitude;

        // $lat2 = -3.662105879601268;z
        // $long2 = 102.57035663033236;
        $checkDistance = $this->getDistanceCoordinate($request->latitude, $request->longitude, $lat1, $long1);

        if(!$isSuper) {
            $rangeDistance = $request->user()->useronopd->opd->distance;
            if($checkDistance > ($rangeDistance / 1000)) {
                return response()->json([
                    'message' => 'Anda berada diluar lokasi absen'
                ], 401);
            }
        }

        //store file photo here
        if($request->hasFile('avatar')){
            $filepath = $this->storeFile($request, $request->file('avatar'));
        }

        //

        $absen = Absen::create([
            'nip' => $request->user()->nip,
            'opd_name' => $request->user()->useronopd->opd->opd_name,
            'name' => $request->user()->name,
            'absen_time' => now(),
            'absen_jenis' => 0,
            'absen_longitude' => $request->longitude,
            'absen_latitude' => $request->latitude,
            'pangkat' => $request->user()->userDetail->pangkat,
            'jabatan' => $request->user()->userDetail->jabatan,
            'jarak' => $checkDistance * 1000,
            'photo' => $filepath ?? '-',
        ]);

        if($absen) {
            return response()->json(['message' => 'Absen Berhasil'], 200);
        }

        return response()->json(['message'=> 'Absen Gagal']);

    }

    public function absenPulang(Request $request) {
        //check valid
        if($request->user()->useronopd ?? false) {
            if($request->user()->useronopd->valid == 0) {
                return response()->json([
                    'message' => 'Akun user belum tervalidasi.'
                ], 200);
            }
        }else{
            return response()->json([
                'message' => 'Akun user belum terkait dengan OPD manapun.'
            ], 200);
        }

        $absenMasuk = Absen::where('nip', $request->user()->nip)->whereDate('created_at', Carbon::today())->where('absen_jenis', 0)->first();

        if(!$absenMasuk) {
            return response()->json(['message' => 'Anda belum absen masuk', 'absen' => true]);
        }

        $absenToday = Absen::where('nip', $request->user()->nip)->whereDate('created_at', Carbon::today())->where('absen_jenis', 1)->first();

         //check if absen pulang already exist
         if($absenToday ?? false) {
            return response()->json(['message' => 'Sudah absen pulang', 'absen' => true]);
        }

         //check validation here
         $validator = Validator::make($request->only('longitude', 'latitude', 'avatar'), [
            'longitude' => ['required'],
            'latitude' => ['required'],
            // 'photo' => ['required']
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        //check if user is super
        $isSuper = $request->user()->useronopd->is_super;

        // check distance here
        // $lat1 = -3.6624580830263196;
        // $long1 = 102.57108801123447;
        $lat1 = $request->user()->useronopd->opd->opd_latitude;
        $long1 = $request->user()->useronopd->opd->opd_longitude;

        // $lat2 = -3.662105879601268;z
        // $long2 = 102.57035663033236;
        $checkDistance = $this->getDistanceCoordinate($request->latitude, $request->longitude, $lat1, $long1);

        if(!$isSuper) {
            $rangeDistance = $request->user()->useronopd->opd->distance;
            if($checkDistance > ($rangeDistance / 1000)) {
                return response()->json([
                    'message' => 'Anda berada diluar lokasi absen'
                ], 401);
            }
        }


        //store file photo here
        if($request->hasFile('avatar')){
            $filepath = $this->storeFile($request, $request->file('avatar'));
        }

        $absen = Absen::create([
            'nip' => $request->user()->nip,
            'opd_name' => $request->user()->useronopd->opd->opd_name,
            'name' => $request->user()->name,
            'absen_time' => now(),
            'absen_jenis' => 1,
            'absen_longitude' => $request->longitude,
            'absen_latitude' => $request->latitude,
            'pangkat' => $request->user()->userDetail->pangkat,
            'jabatan' => $request->user()->userDetail->jabatan,
            'jarak' => $checkDistance * 1000,
            'photo' => $filepath ?? '-',
        ]);

        if($absen) {
            return response()->json(['message' => 'Absen Berhasil'], 200);
        }

        return response()->json(['error'=> 'Absen Gagal']);
    }

    public function storeFile($request, $file) {
        $img = Image::make($file)->resize(null, 300, function($constraint) {
            $constraint->aspectRatio();
        });
        $filename = 'user' . $request->user()->id . now()->format("YMdHis") . "file." . $file->extension();
        $img->save(storage_path('app/public/files/'.$filename));

        $filepath = '';
        if($img){
            $filepath = "files/" . $filename;
            return $filepath;
        }

        return 0;
    }

    function getDistanceCoordinate($latitude1, $longitude1, $latitude2, $longitude2) {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $distance = $distance * 1.609344;

        return (round($distance,2));
    }

    // public function deleteFile($request){
    //     Storage::delete('public/' . $activity->file);
    // }
}
