<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Board;
use App\Models\Brand;

class ProductsController extends Controller
{

    public function index(){
        $products = Product::orderByDesc('id')->paginate(8);
        return view('products.index', compact('products'));
    }

    public function create(){
        $brands = Brand::orderByDesc('id')->paginate(8);
        $boards = Board::orderByDesc('id')->where('usable', 1)->paginate(8);
        return view('products.create', compact('brands', 'boards'));
    }

    public function add(Request $request){
        $cat = $request->only('category');
        return response()->json([$cat]);
    }

    public function cat(Request $request){
        $arr = $request['arr'];
        // foreach($arr as $key){
        //     Board::where('id', $key)
        //             ->update([
        //                 'product_id' => 1
        //             ]);
        // }
        return response()->json([$arr]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->only('name'), [
            'name' => 'required|unique:products,name,NULL,id,deleted_at,NULL'
        ]);
        if(!$validator->passes()){
            return response()->json(['success' => -1]);
        }

        $validator = Validator::make($request->only('o_price', 's_price'), [
            'o_price' => 'required|integer',
            's_price' => 'required|integer'
        ]);
        if(!$validator->passes()){
            return response()->json(['success' => 0]);
        }
        dd($request);
        Product::create([ // 한글명과 영문명 유효성 검사 모두 통과 시 새로운 브랜드로 등록
            'name' => $request->name,
            'status' => $request->status,
            'o_price' => $request->o_price,
            's_price' => $request->s_price,
            'image_path' => 1,
            'brand_id' => $request->brand,
        ]);
        return response()->json(['success' => 1]);
    }

}
