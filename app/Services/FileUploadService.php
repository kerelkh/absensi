<?php

namespace App\Services;

class FileUploadService {
    public static function storeAvatar($id, $file) {
        $filename = 'user' . $id . now()->format("YMdHis") . "avatar." . $file->extension();
        $path = $file->storeAs('public/avatars', $filename);
        $filepath = '';
        if($path){
            $filepath = "avatars/" . $filename;

            return $filepath;
        }

        return 0;
    }
}
