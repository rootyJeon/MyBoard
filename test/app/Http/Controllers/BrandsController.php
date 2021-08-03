<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class BrandsController extends Controller
{
    public function index(){
        $brands = Brand::orderByDesc('id')->paginate(5); // 내림차순으로 5개씩 pagination
        return view('brands.index', compact('brands'));
    }

    public function create(){
        return view('brands.create');
    }

    public function edit($id){
        $brand = Brand::where('id', $id)->first();
        return view('brands.edit', compact('brand'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->only('kor_name'), [
            'kor_name' => 'required|unique:brands,kor_name,NULL,id,deleted_at,NULL' // 소프트 딜리트를 고려한 한글명 유효성 검사
        ]);
        if(!$validator->passes()){
            return response()->json(['success' => -1]);
        }

        $validator = Validator::make($request->only('eng_name'), [
            'eng_name' => 'required|unique:brands,eng_name,NULL,id,deleted_at,NULL' // 소프트 딜리트를 고려한 영문명 유효성 검사
        ]);
        if(!$validator->passes()){
            return response()->json(['success' => 0]);
        }

        Brand::create([ // 한글명과 영문명 유효성 검사 모두 통과 시 새로운 브랜드로 등록
            'kor_name' => $request->kor_name,
            'eng_name' => $request->eng_name,
            'introduction' => $request->introduction,
            'cnt' => 0, // 추후 하위 상품과의 link를 고려해 미리 만들어둠
        ]);
        return response()->json(['success' => 1]);
    }

    public function update(Request $request, $id){ // 브랜드를 수정하는 함수
        $isKorRepeated = false;
        $isEngRepeated = false;
        $isIntroRepeated = false;

        $contmp = Brand::where('id', $id) -> first();

        if($request->kor_name == $contmp['kor_name']) $isKorRepeated = true; // 57~59행은 입력값에 변화가 있는지 없는지 확인하는 boolean 체크
        if($request->eng_name == $contmp['eng_name']) $isEngRepeated = true;
        if($request->introduction == $contmp['introduction']) $isIntroRepeated = true;

        if($isKorRepeated && $isEngRepeated && $isIntroRepeated){ // 만약 모든 입력값이 동일하다면 수정된 사항이 없는 케이스
            return response()->json(['success' => -3]);
        }else if(!$isKorRepeated){ // 그렇지 않고 변화된 값이 있는데 그것이 한글명이라면
        
            $validator = Validator::make($request->only('kor_name'), [
                'kor_name' => 'required|unique:brands,kor_name,NULL,id,deleted_at,NULL' // 한글명에 대한 유효성 검증 진행
            ]);
            if(!$validator->passes()){
                return response()->json(['success' => -2]); // 통과하지 못했다면 한글명에서 중복 발생
            }

        }else if(!$isEngRepeated){

            $validator = Validator::make($request->only('eng_name'), [
                'eng_name' => 'required|unique:brands,eng_name,NULL,id,deleted_at,NULL' // 한글명이 정상이라면 영문명에 대한 유효성 검증 진행
            ]);
            if(!$validator->passes()){
                return response()->json(['success' => -1]); // 통과하지 못했다면 영문명에서 중복 발생
            }
    
        }else if(!$isIntroRepeated){

            $validator = Validator::make($request->only('introduction'), [
                'introduction' => 'required|unique:brands,introduction,NULL,id,deleted_at,NULL' // 영문명까지 통과했다면 소개문구에 대한 유효성 검증 진행
            ]);
            if(!$validator->passes()){
                return response()->json(['success' => 0]); // 통과하지 못했다면 소개문구에서 중복 발생
            }

        }

        Brand::where('id', $id) // 이상의 세 번 검증동안 유효성 검증을 통과했다면 정상적으로 수정
               ->update([
                   'kor_name' => $request->kor_name,
                   'eng_name' => $request->eng_name,
                   'introduction' => $request->introduction,
        ]);
        return response()->json(['success' => 1]);
    }

    public function destroy($id){ // 브랜드를 삭제하는 함수
        $brand = Brand::where('id', $id) -> first();
        $brand -> delete();
        return redirect()->route('brands.index');
    }
}
