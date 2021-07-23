<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function News(){
        $News = \App\Models\News::all(); // App 의 Models에서 News를 가져오는데 모든 콜롬을 가져오는 것!
        return view('index', compact('News'));
    }
}
