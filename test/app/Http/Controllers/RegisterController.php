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
        /*
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',
            'email' => 'required|email|min:8',
            'name' => 'required',
        ]);
        */

        // Store Data in DATABASE from HERE
        User::create([
           'email' => $request->input('email'),
           'password' => Hash::make($request->input('password')),               
           'name' => $request->input('name')
        ]);

        return 1;
        //return response()->json(['success'=>'Added new records.']);
        // return response()->json(['error'=>$validator->errors()]);
        //return 0;
    }

    public function email_check(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email'
        ]);

        if(!$validator -> passes()){
            return -1;
        }

        $validator = Validator::make($request->only('email'), [
            'email' => 'required|unique:users'
        ]);

        if(!$validator ->passes()){
            return 0;
        }

        return 1;
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