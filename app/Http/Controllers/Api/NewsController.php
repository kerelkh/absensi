<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getNews(Request $request) {
        $newses = News::orderBy('created_at', 'desc')->get();
        return response()->json(['message' => 'success', 'data' => $newses]);
    }
}
