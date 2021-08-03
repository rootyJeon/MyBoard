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
            <a href="{{route('brands.create')}}"><button class="px-4 py-2 text-white bg-green-500 hover:bg-green-700">브랜드 등록</button></a>
        </div>
        <div class="text-right" name="totla_brand"><font size=4>총 브랜드 <b>{{$brands->total()}}</b>개</font></div>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th><center>브랜드 번호</th>
                        <th><center>한글명</th>
                        <th><center>영문명</th>
                        <th><center>수정일</th>
                        <th><center>관리</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                    <tr>
                        <td><center>{{$brand->id}}</td>
                        <td><center>{{$brand->kor_name}}</td>
                        <td><center>{{$brand->eng_name}}</td>
                        <td><center>{{$brand->updated_at}}</td>
                        <td><center><a href="{{route('brands.edit', $brand->id)}}"><button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700">수정</button></a>
                        <form action="/brands/{{$brand->id}}/delete" method="post" class="inline-block">
                            @csrf
                            @method('DELETE')
                                <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-700" name="del_btn" id="del_btn"
                                        onclick="return confirm('{{$brand->kor_name}}({{$brand->eng_name}})을 삭제하시겠습니까?')">삭제</button></td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="container">
            <center>{!! $brands->links('vendor.pagination.custom') !!}</center>
        </div>

    </section>
@stop