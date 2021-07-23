@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto mt-16">
        <div class="border-b border-gray-300 mb-8 pl-1 pb-2 text-xl font-bold">
                {{$board -> title}}
        </div>
        <div class="text-lg">
            {{$board -> story}}
        </div>
        <div class="mt-8">
            <a href="{{route('boards.edit', $board->id)}}">
                <button class="px-4 py-1 text-white text-lg bg-blue-500 hover:bg-blue-700">수정</button></a>
            <form action="/boards/{{$board->id}}" method="post" class="inline-block">
                @csrf
                @method('DELETE')
                <button class="px-4 py-1 text-white text-lg bg-red-500 hover:bg-red-700">삭제</button>
            </form>
        </div>
    </section>
@stop