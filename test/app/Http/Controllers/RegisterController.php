<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function auth_store(Request $request)
    {
        $validator = Validator::make($request->only('password'), [ // 비밀번호 8자리에 대한 유효성 검사
            'password' => 'required|min:8'
        ]);
        if(!$validator->passes()){ // 통과하지 못할 경우 return
            return response()->json(['success' => -2]);
        }

        $validator = Validator::make($request->only('password'), [
            'password' => 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/' // 비밀번호 regex 검증
        ]);
        if(!$validator->passes()){
            return response()->json(['success' => -1]);
        }

        $validator = Validator::make($request->only('password', 'password_confirmation'), [ // password_confirmation도 불러 비밀번호와 비밀번호 확인이 일치한는지 검증
            'password' => 'confirmed'
        ]);
        if(!$validator->passes()){
            return response()->json(['success' => 0]);
        }

        User::create([ // 모든 검증을 통과하였으므로 관리자 정상 등록
           'email' => $request->input('email'),
           'password' => Hash::make($request->input('password')),               
           'name' => $request->input('name')
        ]);

        return response()->json(['success'=>1]);
        // return response()->json(['error'=>$validator->errors()]);
    }

    public function email_check(Request $request)
    {
        $validator = Validator::make($request->only('email'), [ // 이메일 양식 유효성 검증
            'email' => 'required|email'
        ]);

        if(!$validator -> passes()){ // 통과하지 못할 경우 return
            return response()->json(['success' => -1]);
        }

        $validator = Validator::make($request->only('email'), [ // 이메일 중복 검증
            'email' => 'required|unique:users'
        ]);

        if(!$validator ->passes()){
            return response()->json(['success' => 0]);
        }

        return response()->json(['success' => 1]); // 정상 케이스에 대한 return
    }
    /*
    public function password_check(Request $request){
        $validator = Validator::make($request->only('password'), [
            'password' => 'required|confirmed'
        ]);

        if(!$validator -> passes()){
            return 0;
        }
        return 1;
    }
    */
}


/*
        $validation = $request -> validate([
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed',
            'name' => 'required',
        ]);
        

        User::create([
            'email' => $validation['email'],
            'password' => Hash::make($validation['password']),
            'name' => $validation['name'],
        ]);

        return redirect() -> route('boards.index');


        // prototype
        public function store2(Request $request)
        {
            $validator = Validator::make($request->only('email'), [
                'email' => 'required|unique:users'
            ]);

            if(!$validator ->passes()){
                return response()->json(['error' => $validator->errors()]);
            }
            return response()->json(['success'=>'right!']);
        }


                $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed',
                'email' => 'required|email|min:8',
                'name' => 'required',
            ]);

            if ($validator->passes()) {

                // Store Data in DATABASE from HERE
                User::create([
                    'email' => $request->input('email'),
                    'password' => Hash::make($validator['password']),
                    'name' => $request->input('name')
                ]);

                //return response()->json(['success'=>'Added new records.']);
                return redirect() -> route('boards.index');
            }

            // return response()->json(['error'=>$validator->errors()]);
            return redirect() -> route('auth.register.index');
*/