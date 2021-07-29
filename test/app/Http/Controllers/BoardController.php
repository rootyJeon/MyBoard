<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    public function index(){
        $boards = Board::orderByDesc('id')->paginate(5);
        return view('boards.index', compact('boards')); // 내림차순으로 boards에 저장
    }
    
    public function create(){
        return view('boards.create');
    }

    // public function store(Request $request){
    //     $validation = $request -> validate([
    //         'title' => 'required',
    //         'story' => 'required'
    //     ]);

    //     $board = new Board();
    //     $board -> title = $validation['title'];
    //     $board -> story = $validation['story'];
    //     $board -> save();

    //     return redirect() -> route('boards.index');
    // }
    
    public function show($id){
        $board = Board::where('id', $id) -> first(); // 넘겨받은 id 값이 같은 글을 찾아 show.blade.php 파일로 넘겨주기
        return view('boards.show', compact('board'));
    }

    
    public function edit($id){
        $board = Board::where('id', $id) -> first();
        return view('boards.edit', compact('board'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->only('name'), [
            'name' => 'required|unique:boards,name,NULL,id,deleted_at,NULL'
        ]);

        if(!$validator->passes()){
            return response()->json(['success' => false]);
        }
        
        $use = $request->use;
        $usable = false;
        if($use == true){
            $usable = true;
        }

        Board::create([
            'name' => $request->name,
            'usable' => $usable,
        ]);
        return response()->json(['success' => true]);
    }

    public function not_usable(Request $request){

        $use = $request->use;
        $not_use = $request->not_use;

        if($use == true && $not_use == true){
            return response()->json(['success' => true]);
        }
        if($use == false && $not_use == false){
            return response()->json(['success' => false]);
        }
        return -1;
    }

    public function is_usable(Request $request){

        $use = $request->use;
        $not_use = $request->not_use;

        if($use == false && $not_use == false){
            return response()->json(['success' => false]);
        }
        if($use == true && $not_use == true){
            return response()->json(['success' => true]);
        }
        return -1;
    }

    public function usable_status(Request $request, $id){
        $category = Board::where('id', $id) -> first();
        return $category['usable'];
    }
    
    public function update(Request $request, $id){

        $validator = Validator::make($request->only('name'), [
            'name' => 'required|unique:boards,name,NULL,id,deleted_at,NULL'
        ]);
        
        $category = Board::where('id', $id)->first(); // 와이씨 뭐야 first 안해서 안돌아간거야?
        $use = $request->use;
        $is_usable = false;
        if($use == true){
            $is_usable = true;
        }

        if(!$validator->passes() && $is_usable == $category['usable']){
                return response()->json(['success' => false]);
        }
        Board::where('id', $id)
               ->update([
                    'name' => $request->name,
                    'usable' => $is_usable
        ]);

        // $category->name = $request->name;
        // $category->usable = $is_usable;
        // $category -> save();
        return response()->json(['success' => true]);
    }

    public function destroy($id){
        $board = Board::where('id', $id) -> first();
        $board -> delete();
        return redirect()->route('boards.index');
    }
}