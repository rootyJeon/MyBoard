@extends('layouts.app')

@section('section')
    <div class="w-2/3 mx-auto mt-16">
        <form action="/auth/login" method="post" class="w-1/2 mx-auto" id="frm">
            @csrf
            <center>
            <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 로 그 인</p>
            <p>
                <label for="email" class="inline-block w-1/4 text-right mr-4">이메일</label>
                <input type="email" id="email" name="email" class="outline-none border border-blue-400 rounded-lg pl-1 w-1/3" id="email"/>
            </p>
            <p class="mt-4">
                <label for="password" class="inline-block w-1/4 text-right mr-4" id="password">비밀번호</label>
                <input type="password" id="password" name="password" class="outline-none border border-blue-400 rounded-lg pl-1 w-1/3" id="password"/>
            </p></br>
            <input type="checkbox" name="remember">
                <label for="remember" class="pr-2">이메일 기억하기</label>
                <a href="{{route('auth.register.index')}}" class="pr-2"><u>관리자 등록하기</u></a>
            </br>
            <p class="mt-8">
                <input type="button" value="로그인" id="btnsubmit"
                        class="bg-blue-500 hover:bg-blue-700 px-10 py-1 ml-4 text-lg text-white rounded-lg outline-none">
                <input type="button" class="bg-red-500 hover:bg-red-700 px-4 py-1 ml-4 text-lg text-white rounded-lg outline-none"
                        value="취소" onclick="window.location.href='{{route('home')}}'">
            </p>
            </center>
        </form>
    </div>

    <script>
    $(function(){

        $("#btnsubmit").click(function(){
            var form = $("#frm")[0];            // id="frm" 안에 있는 모든 내용을 가져온다.
            var formData = new FormData(form);  // 파일을 비동기 방식으로 전송하기 위해서 formData 사용
            // form으로 안하니까 통신이 안되네?! 

            var password=$("#password").val();
            var email=$("#email").val();

            $.ajax({
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                url: "/login_attempt",
                type: "post",
                enctype: "multipart/form-data",
                cache: false,
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success:function(data){
                    //console.log(data);
                    if(data==1){
                        window.location.href="{{route('boards.index')}}";
                    }else{
                        window.location.href="{{route('login')}}";
                    }
                },
                error:function(data){
                    console.log("오류!");
                }
            });
        })
    });
    </script>
@stop