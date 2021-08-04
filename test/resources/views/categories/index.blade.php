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
            <a href="{{route('categories.create')}}">
                <button class="px-4 py-2 text-white bg-green-500 hover:bg-green-700">카테고리 등록</button>
            </a>
        </div>
        <div class="text-right" name="total_cat"><font size=4>총 카테고리 <b>{{$categories->total()}}</b>개</font></div>
        <div class = "container">
            <table class="table">

                <thead>
                    <tr>
                        <th><center>카테고리 번호</th>
                        <th><center>카테고리명</th>
                        <th><center>사용여부</th>
                        <th><center>수정일</th>
                        <th><center>관리</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td><center>{{$cat -> id}}</td>
                        <td><center>{{$cat -> name}}</td>
                        @if($cat->usable == true)
                            <td><center>사용</td>
                        @else
                            <td><center>미사용</td>
                        @endif
                        <td><center>{{$cat -> updated_at -> format('Y-m-d h:m:s')}}</td>
                        <td><center><a href="{{route('categories.edit', $cat->id)}}"><button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700">수정</button></a>
                        <form action="/categories/{{$cat->id}}/delete" method="post" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-700" name="del_btn" id="del_btn" 
                                    onclick="return confirm('{{$cat->name}} 카테고리를 삭제하시겠습니까?')">삭제</button></td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        
        <div class = "container">
              <center>{!! $categories->links('vendor.pagination.custom') !!} <!--Custom Pagination-->
        </div>

        <!-- <div class="w-full mt-8">
            @foreach($categories as $cat)
                <table class="w-3/4 mx-auto text-lg">
                    <thead>
                        <tr>
                            <td class="w-1/4"></td>
                            <td class="w-2/4"></td>
                            <td class="w-1/4"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b mt-2">
                            <td class="w-1/4 text-center">{{$cat -> id}}</td>
                            <td class="w-2/4"><a href="{{route('categories.show', $cat -> id)}}">{{$cat -> title}}</a></td>
                            <td class="w-1/4 text-center">{{$cat -> created_at -> format('Y-m-d')}}</td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div> -->
    </section>

@stop