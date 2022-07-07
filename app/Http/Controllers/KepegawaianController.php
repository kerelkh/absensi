<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KepegawaianController extends Controller
{
    public function index(Request $request) {
        return view('adminkepegawaian.index');
    }
}
