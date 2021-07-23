<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function Food(){
        $foods = [
            'Chicken',
            'Pie'
        ];
        return view('index', compact('foods'));
    }
}