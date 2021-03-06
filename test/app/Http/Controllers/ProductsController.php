<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Support\Facades\Auth;
use Illuminate\Http\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Category_product;
use Illuminate\Validation\Rule;


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
        if($status != null) $query = $query->whereIn('status', $status);
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

    public function add(Request $request){ // ????????? ??????
        $category = $request->only('category');
        return response()->json([$category]);
    }

    public function edit($id){
        $brands = Brand::orderByDesc('id')->paginate(8);
        $categories = Category::orderByDesc('id')->where('usable', 1)->paginate(8);
        $products = Product::where('id', $id)->first();
        if($products == null) return redirect()->route('products.index');
        return view('products.edit', compact('products', 'brands', 'categories'));
    }

    public function store(Request $request){
        dd($request->all());
        try{
            //data ??????
            $data = $request->toArray();

            //data validation
            $rules = array(
                'name' => 'required|unique:products,name,NULL,id,deleted_at,NULL',
                'o_price' => 'required|integer',
                's_price' => 'required|integer'
            );

            $messages = array(
                'name.required' => "???????????? ?????????????????????.",
                'name.unique' => "???????????? ?????????????????????.",
                'o_price.required' => "????????? ?????????????????????.",
                'o_price.integer' => "0????????? ????????? ????????? ??? ????????????.",
                's_price.required' => "???????????? ?????????????????????.",
                's_price.integer' => "0????????? ????????? ????????? ??? ????????????.",
            );

            Validator::make($data, $rules, $messages)->validate();

            $name = $request->file('ex_file')->getClientOriginalName();
            $path = $request->file('ex_file')->storeAs('public/images', $name);

            Product::create([
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
    
            return response()->json([
                'isSuccess' => 'success'
            ]);

        }catch(ValidationException $exception){
            //throw new Exception($exception->validator->messages()->first());
            return response()->json([
                'isSuccess' => 'fail',
                'message' => $exception->validator->messages()->first(),
            ]);
        }
    }

    public function update(Request $request, $id){ // ?????? ????????? ???????????? ??????

        try{
            //data ??????
            $data = $request->toArray();

            //data validation
            $rules = array(
                'name' => [
                    'required',
                    Rule::unique('products', 'name', null, 'id', 'deleted_at', null)->ignore($id),
                ],
                'o_price' => 'required|integer',
                's_price' => 'required|integer',
                'ex_file' => [
                    'exclude_if:status,4',
                    'required',
                ],
            );

            $messages = array(
                'name.required' => "???????????? ?????????????????????.",
                'name.unique' => "???????????? ?????????????????????.",
                'o_price.required' => "????????? ?????????????????????.",
                'o_price.integer' => "0????????? ????????? ????????? ??? ????????????.",
                's_price.required' => "???????????? ?????????????????????.",
                's_price.integer' => "0????????? ????????? ????????? ??? ????????????.",
                'ex_file.required' => "?????? ????????? ?????????????????????.",
            );

            Validator::make($data, $rules, $messages)->validate();

            Product::where('id', $id)
               ->update([
                   'name' => $request->name,
                   'status' => $request->status,
                   'o_price' => $request->o_price,
                   's_price' => $request->s_price,
                   'brand_id' => $request->brand,
            ]);

            if($request->file('ex_file') != null){
                $img_name = $request->file('ex_file')->getClientOriginalName();
                $img_path = $request->file('ex_file')->storeAs('public/images', $img_name);

                Product::where('id', $id)
                ->update([
                    'image_name' => $img_name,
                    'image_path' => $img_path,
                ]);
            }else{
                Product::where('id', $id)
                ->update([
                    'image_name' => null,
                    'image_path' => null,
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
                                            'product_id' => $idx,
                    ]);
                }
            }
    
            return response()->json([
                'isSuccess' => 'success'
            ]);

        }catch(ValidationException $exception){
            //throw new Exception($exception->validator->messages()->first());
            return response()->json([
                'isSuccess' => 'fail',
                'message' => $exception->validator->messages()->first(),
            ]);
        }
    }

    public function status(Request $request, $id){ // ???????????? ??????????????? ???????????? ?????? db ???????????? ?????? ????????????
        $product = Product::where('id', $id) -> first();
        $categories_info = Category_product::where('product_id', $id) -> get();
        $category = array();
        foreach($categories_info as $category_info){
            array_push($category, $category_info->category_id);
        }
        return response()->json([
            'status' => $product->status,
            'category' => $category,
        ]);
    }

    public function destroy($id){ // ????????? ???????????? ??????
        $product = Product::where('id', $id) -> first();
        if($product){
            $product -> delete();
        }
        return redirect()->route('products.index');
    }

}