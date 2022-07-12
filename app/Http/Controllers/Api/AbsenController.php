<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $absenToday = Absen::where('nip', $request->user()->nip)->whereDate('created_at', Carbon::today())->first();

        //check if absen masuk already exist
        if($absenToday ?? false) {
            if($absenToday->absen_masuk != null){
                return response()->json([
                    'error' => 'User Sudah absen masuk hari ini.'
                ]);
            }
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

        // check distance here
        $lat1 = -3.6624580830263196;
        $long1 = 102.57108801123447;

        $lat2 = -3.662105879601268;
        $long2 = 102.57035663033236;
        $checkDistance = $this->getDistanceCoordinate($lat1, $long1, $lat2, $long2);

        if($checkDistance > 0.1) {
            return response()->json([
                'error' => 'Jarak Lebih dari 1 km'
            ], 401);
        }


        //store file photo here
        if($request->hasFile('avatar')){
            $filepath = $this->storeFile($request, $request->file('file'));
        }

        //

        if(!$absenToday) {
            $absen = Absen::create([
                'nip' => $request->user()->nip,
                'absen_masuk' => now(),
                'absen_longitude' => $request->longitude,
                'absen_latitude' => $request->latitude,
                'pangkat' => $request->user()->userDetail->pangkat,
                'jabatan' => $request->user()->userDetail->jabatan,
                'jarak' => $checkDistance * 1000,
                'photo' => $filepath ?? '-',
            ]);
        }else{
            $absenToday->absen_masuk = now();
            $absenToday->absen_longitude = $request->longitude;
            $absenToday->absen_latitude = $request->latitude;
            $absenToday->jarak = $checkDistance * 1000;
            $absenToday->photo = $filepath ?? '-';
            $absen = $absenToday->update();
        }

        if($absen) {
            return response()->json(['message' => 'Absen Berhasil'], 200);
        }

        return response()->json(['error'=> 'Absen Gagal']);

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

        $absenToday = Absen::where('nip', $request->user()->nip)->whereDate('created_at', Carbon::today())->first();

         //check if absen pulang already exist
         if($absenToday ?? false) {
            if($absenToday->absen_pulang != null){
                return response()->json([
                    'error' => 'User Sudah absen pulang hari ini.'
                ]);
            }
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

        // check distance here
        $lat1 = -3.6624580830263196;
        $long1 = 102.57108801123447;

        $lat2 = -3.662105879601268;
        $long2 = 102.57035663033236;
        $checkDistance = $this->getDistanceCoordinate($lat1, $long1, $lat2, $long2);

        if($checkDistance > 0.1) {
            return response()->json([
                'error' => 'Jarak Lebih dari 1 km'
            ], 401);
        }


        //store file photo here
        if($request->hasFile('avatar')){
            $filepath = $this->storeFile($request, $request->file('file'));
        }

        if(!$absenToday) {
            $absen = Absen::create([
                'nip' => $request->user()->nip,
                'absen_pulang' => now(),
                'absen_longitude' => $request->longitude,
                'absen_latitude' => $request->latitude,
                'pangkat' => $request->user()->userDetail->pangkat,
                'jabatan' => $request->user()->userDetail->jabatan,
                'photo' => 'test',
            ]);
        }else{
            $absenToday->absen_pulang = now();
            $absenToday->absen_longitude = $request->longitude;
            $absenToday->absen_latitude = $request->latitude;
            $absen = $absenToday->update();
        }

        if($absen) {
            return response()->json(['message' => 'Absen Berhasil'], 200);
        }

        return response()->json(['error'=> 'Absen Gagal']);
    }

    public function storeFile($request, $file) {
        $filename = 'user' . $request->user()->id . now()->format("YMdHis") . "file." . $file->extension();
        $path = $file->storeAs('public/files', $filename);
        $filepath = '';
        if($path){
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
