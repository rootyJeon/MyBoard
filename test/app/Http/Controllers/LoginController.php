<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        
        /*
        $auth = false;
        $credentials = $request->only('email', 'password');
        dd($credentials);

        if(Auth::attempt($credentials, $request->has('remember'))){
            $auth = true;
        }

        if($request -> ajax()){
            return response()->json([
                'auth'=> $auth,
                'intended' => URL::previous()
            ]);
        }else{
            return redirect() -> intended(URL::route('boards.index'));
        }
        return redirect(URL::route('login'));
        */

        $loginInfo=$request->only(["email", "password"]);
        
        if(auth()->attempt($loginInfo)){
            /*
            response()->json([
                'success' => 'get your data'
            ]);
            */
            return 1; // 성공하면 메인화면
        }else{
            return 0; // 실패하면 로그인화면
        }
        
    }
    
    public function logout(){
        auth() -> logout();
        return redirect() -> route('home');
    }
}

/*
        $loginInfo=$request->only(['email', 'password']);
        if(auth()->attempt($loginInfo)){
            response()->json([
                'success' => 'get your data'
            ]);
            return redirect() -> route('boards.index'); // 성공하면 메인화면
        }else{
            return redirect() -> route('login'); // 실패하면 로그인화면
        }

*/
