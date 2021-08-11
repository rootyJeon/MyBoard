@extends('layouts.app')

@section('section')
<section class="w-2/3 mx-auto mt-8">
        <div class="flex w-full justify-between">
            <div class="flex-initial text-2xl text-yellow-500"><a href="{{route('categories.index')}}">카테고리 메뉴</a></div>
            <div class="flex-initial text-2xl text-yellow-500"><a href="{{route('brands.index')}}">브랜드 메뉴</a></div>
            <div class="flex-initial text-2xl text-yellow-500"><a href="{{route('products.index')}}">상품관리 메뉴</a></div>
            <div class="flex-initial text-2xl text-yellow-500">메뉴4</div>
        </div><br><br>
        <div>
            <a href="{{route('products.create')}}"><button class="px-4 py-2 text-white bg-green-500 hover:bg-green-700">상품 등록</button></a>
        </div>
        <div class="text-right" name="total_products"><font size=4>총 상품수 <b>{{$products->total()}}</b>개</font></div>
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
                        <th><center>상품사진</th>
                        <th><center>관리</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td><center>{{$product->id}}</td>
                            <td><center>{{$product->brand->kor_name}}</td>
                            <td><center>
                                @foreach($product->category as $cat)
                                    <font size=3>{{$cat->name}}</font>
                                @endforeach
                            </td>
                            <td><center>{{$product->name}}</td>
                            <td><center>
                                <script>
                                    var status="{{$product->status}}";
                                    if(status==1) document.write("판매중");
                                    if(status==2) document.write("일시품절");
                                    if(status==3) document.write("품절");
                                    if(status==4) document.write("판매중지");
                                </script>
                            </td>
                            <td><center><text id="o_price">{{$product->o_price}}</text></td>
                            <td><center><text id="s_price">{{$product->s_price}}</text></td>
                            <td><center>
                                <script>
                                    var o_price="{{$product->o_price}}";
                                    var s_price="{{$product->s_price}}";
                                    var res=(o_price - s_price) * 100 / o_price;
                                    document.write(res.toFixed(1) + "%");
                                </script>
                            </td>
                            <td><center><img src="storage/images/{{$product->image_name}}" alt="" title="" height="120" width="120"/></td>
                            <td><center><a href="{{route('products.edit', $product->id)}}"><button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700">수정</button></a>
                                <form action="/products/{{$product->id}}/delete" method="post">
                                @csrf
                                @method('DELETE')
                                    <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-700" name="del_btn" id="del_btn"
                                            onclick="return confirm('{{$product->name}}을(를) 삭제하시겠습니까?')">삭제</button></td>
                                </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="container">
            <center>{!! $products->links('vendor.pagination.custom') !!}
        </div>

    </section>
@stop