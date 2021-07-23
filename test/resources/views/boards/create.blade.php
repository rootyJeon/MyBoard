@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <div class="w-full text-2xl text-green-500 mt-8">글쓰기</div>
        <form action="/boards" method="post" class="mt-8 w-full">
            @csrf
            <p>
                <label for="title" class="text-xl">제목 : </label>
                <input type="text" id="title" name="title"
                       class="outline-none border border-blue-400 w-1/2 pl-1 py-1 rounded-lg">
            </p>
            <p class="mt-4">
                <label for="story" class="text-xl">내용</label>
                <textarea id="story" name="story"
                          class="outline-none border border-blue-400 w-full h-64 mt-2 rounded-lg resize-none"></textarea>
            </p>

            <p class="mt-8">
                <input type="submit" value="작성" 
                class="px-4 py-1 bg-green-500 hover:bg-green-700 text-lg text-white">
                <input type="button" value="취소" onclick="history.back()"
                       class="px-4 py-1 ml-6 bg-red-500 hover:bg-red-700 text-lg text-white">
            </p>
        </form>
    </section>
@stop