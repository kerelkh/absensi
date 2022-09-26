<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\MenusService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $data = [];

    public function index() {
        //check permission
        if(!PermissionService::can('dashboard')){
            abort(403, 'This page is forbidden');
        };

        $this->data['title'] = 'Dashboard';

        $MENUS = new MenusService();
        $this->data['menus'] = $MENUS->getMenu();
        $this->data['roles'] = Role::all();
        $this->data['superadmins'] = User::where('role_id', 1)->get();

        return view('dashboard.index', [
            'datas' => $this->data
        ]);
    }
}
