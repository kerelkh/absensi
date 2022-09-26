<?php
namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenusService {
    public function getMenu() {
        if(Auth::user()->role->id != 1){
            $permissions = explode(",", Auth::user()->role->permission->can);
            $menus = Menu::whereIn('name', $permissions)->where('flag_menu', 1)->where('flag', 1)->get();
        }else{
            $menus = Menu::where('flag_menu', 1)->where('flag', 1)->get();
        }
        return $menus;
    }
}
