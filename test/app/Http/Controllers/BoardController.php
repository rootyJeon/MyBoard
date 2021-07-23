<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;

class BoardController extends Controller
{
    public function index(){
        return view('boards.index', ['boards' => Board::all()->sortDesc()]); // 내림차순으로 boards에 저장
    }
    
    public function create(){
        return view('boards.create');
    }

    public function store(Request $request){
        $validation = $request -> validate([
            'title' => 'required',
            'story' => 'required'
        ]);

        $board = new Board();
        $board -> title = $validation['title'];
        $board -> story = $validation['story'];
        $board -> save();

        return redirect() -> route('boards.index');
    }

    
    public function show($id){
        $board = Board::where('id', $id) -> first(); // 넘겨받은 id 값이 같은 글을 찾아 show.blade.php 파일로 넘겨주기
        return view('boards.show', compact('board'));
    }

    
    public function edit($id){
        $board = Board::where('id', $id) -> first();
        return view('boards.edit', compact('board'));
    }
    
    public function update(Request $request, $id){
        $validation=$request->validate([
            'title' => 'required',
            'story' => 'required'
        ]);
        $board = Board::where('id', $id) -> first();
        $board->title=$validation['title'];
        $board->story=$validation['story'];
        $board->save();
        return redirect() -> route('boards.show', $id);
    }

    public function destroy($id){
        $board = Board::where('id', $id) -> first();
        $board -> delete();
        return redirect() -> route('boards.index');
    }
}