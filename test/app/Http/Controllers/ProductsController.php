<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Category_product;

class ProductsController extends Controller
{

    public function index(){
        $products = Product::orderByDesc('id')->paginate(8);
        return view('products.index', compact('products'));
    }

    public function search(Request $request){
        $names = explode(',', $request->name);
        // $query = $this->where('name', 'LIKE', "%{$request->name}%");
        $keyword = $request->keyword;
        $status = $request->status;
        $price = $request->price;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $date = $request->date;
        $min_date = $request->min_date;
        $max_date = $request->max_date;

        $query = Product::query();

        foreach($names as $name){
            $query = $query->orWhere($keyword, 'LIKE', "%{$name}%");
        }
        if($status != null) $query = $query->whereIn('status', $status); // 하아...씨.. 왜 또 쿼리가 다른건데?!
        if($min_price != null) $query = $query->where($price, '>=', $min_price);
        if($max_price != null) $query = $query->where($price, '<=', $max_price);
        if($min_date != null) $query = $query->where($date, '>=', $min_date);
        if($max_date != null) $query = $query->where($date, '<=', $max_date);
        if($request->trashed){
            $deleted = Product::onlyTrashed();
            if($status != null) $query = $query->union($deleted);
            else $query = $query = $deleted;
        }
        
        $products = $query->orderByDesc('id')->paginate(8);
        // $products = Product::query()->where('name', 'LIKE', "%{$request->word}%")->orderByDesc('id')->paginate(8);
        return view('products.index', compact('products'));
    }

    public function create(){
        $brands = Brand::orderByDesc('id')->paginate(8);
        $categories = Category::orderByDesc('id')->where('usable', 1)->paginate(8);
        return view('products.create', compact('brands', 'categories'));
    }

    public function add(Request $request){
        $category = $request->only('category');
        return response()->json([$category]);
    }

    public function edit($id){
        $brands = Brand::orderByDesc('id')->paginate(8);
        $categories = Category::orderByDesc('id')->where('usable', 1)->paginate(8);
        $products = Product::where('id', $id)->first();
        return view('products.edit', compact('products', 'brands', 'categories'));
    }

    // public function cat(Request $request){
    //     $arr = $request['arr'];

    //     return response()->json([$arr]);
    // }

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

        $name = $request->file('ex_file')->getClientOriginalName();
        $path = $request->file('ex_file')->storeAs('public/images', $name);

        Product::create([ // 한글명과 영문명 유효성 검사 모두 통과 시 새로운 브랜드로 등록
            'name' => $request->name,
            'status' => $request->status,
            'o_price' => $request->o_price,
            's_price' => $request->s_price,
            'image_name' => $name,
            'image_path' => $path,
            'brand_id' => $request->brand,
        ]);
        
        $arr = $request->arr;
        $id = Product::where('name', $request->name)->first()->id;
        foreach($arr as $value){
            Category_product::create([
                'category_id' => $value,
                'product_id' => $id
            ]);
            // Category::where('id', $key)
            //         ->update([
            //             'product_id' => 1
            //         ]);
        }
        return response()->json(['success' => 1]);
    }

    public function update(Request $request, $id){ // 상품 정보를 수정하는 함수

        Product::where('id', $id)
               ->update([
                   'name' => $request->name,
                   'status' => $request->status,
                   'o_price' => $request->o_price,
                   's_price' => $request->s_price,
                   'brand_id' => $request->brand
        ]);

        if($request->file('ex_file') != null){
            $img_name = $request->file('ex_file')->getClientOriginalName();
            $img_path = $request->file('ex_file')->storeAs('public/images', $img_name);

            Product::where('id', $id)
            ->update([
                'image_name' => $img_name,
                'image_path' => $img_path
            ]);
        }

        $arr = $request->arr;
        if($arr != null){
            sort($arr);
            $idx = Product::where('id', $id)->first()->id;
            Category_product::where('product_id', $idx)->delete();
    
            foreach($arr as $value){
                Category_product::where('product_id', $idx)
                                    ->create([
                                        'category_id' => $value,
                                        'product_id' => $idx
                                    ]);
            }
        }
        return response()->json(['success' => 1]);
    }

    public function status(Request $request, $id){ // 사용인지 미사용인지 확인하는 함수 db 데이터를 받아 넘겨준다
        $product = Product::where('id', $id) -> first();
        $categories_info = Category_product::where('product_id', $id) -> get();
        $category = array();
        foreach($categories_info as $category_info){
            array_push($category, $category_info->category_id);
        }
        return response()->json([
            'status' => $product->status,
            'category' => $category
        ]);
    }

    public function destroy($id){ // 상품을 삭제하는 함수
        $product = Product::where('id', $id) -> first();
        $product -> delete();
        return redirect()->route('products.index');
    }

}
