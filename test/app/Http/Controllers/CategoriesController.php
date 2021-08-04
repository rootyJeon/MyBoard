<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Category::orderByDesc('id')->paginate(5); // 내림차순하며 5개씩 pagination
        return view('categories.index', compact('categories')); // 변수를 배열로 만드는 compact
    }
    
    public function create(){
        return view('categories.create');
    }
    
    // public function show($id){
    //     $category = Category::where('id', $id) -> first(); // 넘겨받은 id 값이 같은 글을 찾아 show.blade.php 파일로 넘겨주기
    //     return view('categories.show', compact('category'));
    // }

    
    public function edit($id){
        $category = Category::where('id', $id) -> first();
        return view('categories.edit', compact('category'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->only('name'), [ // 이름 유효성 검사
            'name' => 'required|unique:categories,name,NULL,id,deleted_at,NULL' // 여기서 unique 작성 시 소프트 딜리트 된 데이터에 대해서도 중복을 확인하므로 다음과 같이 작성
        ]);

        if(!$validator->passes()){
            return response()->json(['success' => false]);
        }
        
        $use = $request->use; // 41행~45행은 사용인지 미사용인지 확인하는 코드
        $usable = false;
        if($use == true){
            $usable = true;
        }

        Category::create([ // 저장
            'name' => $request->name,
            'usable' => $usable,
            'product_id' => 0
        ]);
        return response()->json(['success' => true]);
    }

    public function not_usable(Request $request){

        $use = $request->use;
        $not_use = $request->not_use;

        if($use == true && $not_use == true){ // 미사용을 클릭해서 (사용, 미사용)이 (T, T) 이므로 사용을 F 해줘야함.(F로 바꿔주는 것은 js에서)
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

    public function usable_status(Request $request, $id){ // 사용인지 미사용인지 확인하는 함수 db 데이터를 받아 넘겨준다
        $category = Category::where('id', $id) -> first();
        return $category['usable'];
    }
    
    public function update(Request $request, $id){ // 카테고리를 수정하는 함수

        $validator = Validator::make($request->only('name'), [
            'name' => 'required|unique:categories,name,NULL,id,deleted_at,NULL' // 소프트 딜리트를 고려한 유효성 검사
        ]);
        
        $category = Category::where('id', $id)->first(); // first를 해야 객체를 가져온다
        $use = $request->use;
        $is_usable = false;
        if($use == true){
            $is_usable = true;
        }

        if(!$validator->passes() && $is_usable == $category['usable']){ // 유효성 검증도 통과하지 못했고 사용 미사용도 동일하다면 수정된 것이 없는 케이스이다
                return response()->json(['success' => false]);
        }
        Category::where('id', $id) // 이상의 문제가 모두 없는 경우 수정 가능한 케이스이므로 update 진행
               ->update([
                    'name' => $request->name,
                    'usable' => $is_usable
        ]);

        // $category->name = $request->name;
        // $category->usable = $is_usable;
        // $category -> save(); form 방식
        return response()->json(['success' => true]);
    }

    public function destroy($id){ // 삭제하는 함수
        $category = Category::where('id', $id) -> first();
        $category -> delete();
        return redirect()->route('categories.index');
    }
}