<!doctype html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.0.0/parsley.min.js" integrity="sha512-83WT9hUVM+iU1MUFfipwr7JcCGriOEmzijo1EiHf30IXsMyMKRTy33uTl1prtJNGc2AlJJxEFVTTIQhai7az3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .parsley-errors-list li{
            list-style: none;
            color:red;
        }
        label, textarea{ /* 구글갓글 만만세 와이씨 무슨 ㅋㅋㅋㅋㅋㅋㅋㅋㅋ */
            display: inline-block;
            vertical-align: top;
        }
        .filebox label {
        display: inline-block;
        padding: .5em .75em;
        color: #fff;
        font-size: inherit;
        line-height: normal;
        vertical-align: middle;
        background-color: #5cb85c;
        cursor: pointer;
        border: 1px solid #4cae4c;
        border-radius: .25em;
        -webkit-transition: background-color 0.2s;
        transition: background-color 0.2s;
        }

        .filebox label:hover {
        background-color: #6ed36e;
        }

        .filebox label:active {
        background-color: #367c36;
        }

        .filebox input[type="file"] {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
        }
    </style>
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ mix('css/tailwind.css') }}" rel="stylesheet">
    <title>@yield('title', '작업중')</title>
</head>
<body>

@section('header')
    <header class="w-2/3 mx-auto mt-16 text-right">
        @guest()
            <a href="{{route('boards.index')}}" class="text-xl"><b>게시판</b></a>
            <a href="{{route('auth.register.index')}}" class="text-xl"><b>&nbsp관리자 등록&nbsp</b></a>
            <a href="{{route('login')}}" class="text-xl"><b>로그인</b></a>
        @endguest

        @auth()
            <span class="text-xl text-blue-500"><font size=2>{{auth()->user()->name}}님 환영합니다 </font></span>
            <a href="{{route('boards.index')}}" class="text-xl"><b>&nbsp메인 게시판</b></a>
            <form action="/auth/logout" method="post" class="inline-block">
                @csrf
                <a href="{{route('auth.logout')}}"><button class="text-xl"><b>로그아웃</b></button></a>
            </form>
        @endauth
    </header>
@show

@section('section')
@show
</body>
</html>