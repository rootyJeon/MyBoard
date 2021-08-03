@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto mt-8">
        <div class="flex w-full justify-between">
            <div class="flex-initial text-2xl text-yellow-500"><a href="{{route('boards.index')}}">카테고리 메뉴</a></div>
            <div class="flex-initial text-2xl text-yellow-500"><a href="{{route('brands.index')}}">브랜드 메뉴</a></div>
            <div class="flex-initial text-2xl text-yellow-500"><a href="{{route('products.index')}}">상품관리 메뉴</a></div>
            <div class="flex-initial text-2xl text-yellow-500">메뉴4</div>
        </div><br><br>
        <div>
            <button class="px-4 py-2 text-white bg-green-500 hover:bg-green-700"><a href="{{route('products.create')}}">상품 등록</a></button>
        </div>
        <div class="text-right" name="total_products"><font size=4>총 상품수 <b>{{$products->total()}}</b>개<font></div>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th><center>상품번호</th>
                        <th><center>브랜드(한글)</th>
                        <th><center>카테고리</th>
                        <th><center>상품명</th>
                        <th><center>상태</th>
                        <th><center>정가</th>
                        <th><center>판매가</th>
                        <th><center>할인율</th>
                        <th><center>관리</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td><center>{{$product->id}}</td>
                            <td><center>{{$product->brand->kor_name}}</td>
                            <td><center>카테고리</td>
                            <td><center>{{$product->name}}</td>
                            <td><center>{{$product->status}}</td>
                            <td><center>{{$product->o_price}}</td>
                            <td><center>{{$product->s_price}}</td>
                            <td><center>할인율</td>
                            <td><center><button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700">수정</button>
                                        <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-700">삭제</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="container">
            <center>{!! $products->links('vendor.pagination.custom') !!}
        </div>

    </section>

    <script>

    </script>
@stop