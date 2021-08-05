<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @file     ExController.php
 * @brief    컨트롤러 기본 틀 예제파일
 * @author   이지윤
 * @date     2021.08.04
 * @see      {참고사항(없을경우 공란)}
**/
class ExampleController extends Controller
{
    public function index(){

        return view('example');
    }

    
}