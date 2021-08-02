@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
            <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 상 품 &nbsp 등 록</p>
        </center>

        <form action="/products" method="post" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="kor_name" class="inline-block w-2/5 text-right mr-4">상품명</label>
                <input type="text" id="kor_name" name="kor_name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
                <div class="font_size w-4/2 text-middle" id="korcheck"></div>
            </p><br>
            <p>
                <label for="kor_name" class="inline-block w-2/5 text-right mr-4">카테고리</label>
                <input type="text" id="kor_name" name="kor_name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
                <div class="font_size w-4/2 text-middle" id="korcheck"></div>
            </p><br>
            <p>
                <label for="kor_name" class="inline-block w-2/5 text-right mr-4">브랜드</label>
                <input type="text" id="kor_name" name="kor_name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
                <div class="font_size w-4/2 text-middle" id="korcheck"></div>
            </p><br>
            <p>
                <label for="kor_name" class="inline-block w-2/5 text-right mr-4">정가</label>
                <input type="text" id="kor_name" name="kor_name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
                <div class="font_size w-4/2 text-middle" id="korcheck"></div>
            </p><br>
            <p>
                <label for="kor_name" class="inline-block w-2/5 text-right mr-4">판매가</label>
                <input type="text" id="kor_name" name="kor_name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
                <div class="font_size w-4/2 text-middle" id="korcheck"></div>
            </p><br>
            <p>
                <center>
                <input type="button" value="등록" id="reg" style="width:190pt"
                       class="ml-11 bg-green-500 hover:bg-green-700 text-lg text-white rounded-lg"></input><br><br>
                <input type="button" value="취소" id="reg" style="width:190pt" onclick=history.back();
                       class="ml-11 bg-red-500 hover:bg-red-700 text-lg text-white rounded-lg"></input>
                </center>
            </p>
        </form>
    </section>
@stop