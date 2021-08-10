<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request){

        try {
            
            // data 확인
            $data = $request->toArray();

            // data validation
            $rules = array(
                'title' => 'required',
            );

            $messages = array(
                'title.required' =>  "제목이 누락되었습니다.",
            );

            Validator::make($data, $rules, $messages)->validate();

            return response()->json(array(
                'isSuccess' => 'success'
            ));

        } catch (ValidationException $exception) {
            //throw new Exception($exception->validator->messages()->first());

            return response()->json(array(
                'isSuccess' => 'fail',
                'message' => $exception->validator->messages()->first()
            ));
        }


        // return response()->json(array(
        //     'bookmarks' => BookmarkService::create($request->all())
        // ));

        return response()->json(array(
            'isSuccess' => 'success'
        ));

    }

    
}