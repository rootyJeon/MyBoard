@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto mt-8">
        <div class="flex w-full justify-between">
            <div class="flex-initial text-2xl text-yellow-500"><a href="{{route('boards.index')}}">카테고리 메뉴</a></div>
            <div class="flex-initial text-2xl text-yellow-500">메뉴2</div>
            <div class="flex-initial text-2xl text-yellow-500">메뉴3</div>
            <div class="flex-initial text-2xl text-yellow-500">메뉴4</div>
        </div>
        <br><div>
                <a href="{{route('boards.create')}}">
                    <button class="px-4 py-2 text-white bg-green-500 hover:bg-green-700">카테고리 등록</button>
                </a>
            </div>
        <br><div class = "container">
            <table class="table">

                <thead>
                    <tr>
                        <th><center>카테고리 번호</th>
                        <th><center>카테고리명</th>
                        <th><center>사용여부</th>
                        <th><center>등록일</th>
                        <th><center>관리</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($boards as $cat)
                    <tr>
                        <td><center>{{$cat -> id}}</td>
                        <td><center><a href="{{route('boards.show', $cat -> id)}}">{{$cat -> name}}</a></td>
                        @if($cat->usable == true)
                            <td><center>사용</td>
                        @else
                            <td><center>미사용</td>
                        @endif
                        <td><center>{{$cat -> created_at -> format('Y-m-d h:m:s')}}</td>
                        <td><center><a href="{{route('boards.edit', $cat->id)}}"><button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700">수정</button></a>
                        <form action="/boards/{{$cat->id}}/delete" method="post" class="inline-block">
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
              <center>{!! $boards->links('vendor.pagination.custom') !!}
        </div>

        <!-- <div class="w-full mt-8">
            @foreach($boards as $cat)
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
                            <td class="w-2/4"><a href="{{route('boards.show', $cat -> id)}}">{{$cat -> title}}</a></td>
                            <td class="w-1/4 text-center">{{$cat -> created_at -> format('Y-m-d')}}</td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div> -->
    </section>

@stop