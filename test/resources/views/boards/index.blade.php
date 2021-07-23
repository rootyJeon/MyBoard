@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto mt-8 ">
        <div class="flex w-full justify-between">
            <div class="flex-initial text-2xl text-green-500">메뉴1</div>
            <div class="flex-initial text-2xl text-green-500">메뉴2</div>
            <div class="flex-initial text-2xl text-green-500">메뉴3</div>
            <div class="flex-initial text-2xl text-green-500">메뉴4</div>
            <div class="flex-initial">
                <a href="{{route('boards.create')}}">
                    <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700">입력</button>
                </a>
            </div>
        </div>
        <div class="w-full mt-8">
            @foreach($boards as $board)
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
                            <td class="w-1/4 text-center">{{$board -> id}}</td>
                            <td class="w-2/4"><a href="{{route('boards.show', $board -> id)}}">{{$board -> title}}</a></td>
                            <td class="w-1/4 text-center">{{$board -> created_at -> format('Y-m-d')}}</td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
    </section>
@stop