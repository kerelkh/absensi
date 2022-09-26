<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermissionService {
    public static function can($action) {
        $permissions = explode(",", Auth::user()->role->permission->can ?? '');
        if(in_array($action,$permissions) || Auth::user()->role->id == 1) {
            return true;
        }

        return false;
    }
}
