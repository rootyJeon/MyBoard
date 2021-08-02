<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class BrandsController extends Controller
{
    public function index(){
        $brands = Brand::orderByDesc('id')->paginate(5);
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
            'kor_name' => 'required|unique:brands,kor_name,NULL,id,deleted_at,NULL'
        ]);
        if(!$validator->passes()){
            return response()->json(['success' => -1]);
        }

        $validator = Validator::make($request->only('eng_name'), [
            'eng_name' => 'required|unique:brands,eng_name,NULL,id,deleted_at,NULL'
        ]);
        if(!$validator->passes()){
            return response()->json(['success' => 0]);
        }

        Brand::create([
            'kor_name' => $request->kor_name,
            'eng_name' => $request->eng_name,
            'introduction' => $request->introduction,
            'cnt' => 0,
            'board_id' => 10
        ]);
        return response()->json(['success' => 1]);
    }

    public function update(Request $request, $id){
        $isKorRepeated = false;
        $isEngRepeated = false;
        $isIntroRepeated = false;

        $contmp = Brand::where('id', $id) -> first();

        if($request->kor_name == $contmp['kor_name']) $isKorRepeated = true;
        if($request->eng_name == $contmp['eng_name']) $isEngRepeated = true;
        if($request->introduction == $contmp['introduction']) $isIntroRepeated = true;

        if($isKorRepeated && $isEngRepeated && $isIntroRepeated){
            return response()->json(['success' => -3]);
        }else if(!$isKorRepeated){
        
            $validator = Validator::make($request->only('kor_name'), [
                'kor_name' => 'required|unique:brands,kor_name,NULL,id,deleted_at,NULL'
            ]);
            if(!$validator->passes()){
                return response()->json(['success' => -2]);
            }

        }else if(!$isEngRepeated){

            $validator = Validator::make($request->only('eng_name'), [
                'eng_name' => 'required|unique:brands,eng_name,NULL,id,deleted_at,NULL'
            ]);
            if(!$validator->passes()){
                return response()->json(['success' => -1]);
            }
    
        }else if(!$isIntroRepeated){

            $validator = Validator::make($request->only('introduction'), [
                'introduction' => 'required|unique:brands,introduction,NULL,id,deleted_at,NULL'
            ]);
            if(!$validator->passes()){
                return response()->json(['success' => 0]);
            }

        }

        Brand::where('id', $id)
               ->update([
                   'kor_name' => $request->kor_name,
                   'eng_name' => $request->eng_name,
                   'introduction' => $request->introduction,
        ]);
        return response()->json(['success' => 1]);
    }

    public function destroy($id){
        $brand = Brand::where('id', $id) -> first();
        $brand -> delete();
        return redirect()->route('brands.index');
    }
}
