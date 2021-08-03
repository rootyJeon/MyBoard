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
        return response()->json([$arr]);
    }

}
