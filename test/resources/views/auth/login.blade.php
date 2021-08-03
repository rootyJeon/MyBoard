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
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" class="pr-2">이메일 기억하기</label>
                <a href="{{route('auth.register.index')}}" class="pr-2"><u>관리자 등록하기</u></a>
            </br>
            <p class="mt-8">
                <input type="button" value="로그인" id="loginsubmit"
                        class="bg-blue-500 hover:bg-blue-700 px-10 py-1 ml-4 text-lg text-white rounded-lg outline-none">
                <input type="button" class="bg-red-500 hover:bg-red-700 px-4 py-1 ml-4 text-lg text-white rounded-lg outline-none"
                        value="취소" onclick="window.location.href='{{route('home')}}'">
            </p>
            </center>
        </form>
    </div>

    <script>
    $(function(){

        var userId = getCookie("cookieUserId"); // 쿠키를 얻어와서
        $("#email").val(userId); // 쿠키의 이메일 표시

        if($("#email").val() != ""){ // 쿠키에 만료되지 않은 아이디가 있어 입력됐다면 체크박스가 체크되도록 표시
            $("#remember").attr("checked", true);
        }

        $("#loginsubmit").click(function(){     // 로그인 버튼 클릭시
            var form = $("#frm")[0];            // id="frm" 안에 있는 모든 내용을 가져온다.
            var formData = new FormData(form);  // 파일을 비동기 방식으로 전송하기 위해서 formData 사용
            // form으로 안하니까 통신이 안되네?!

            if($("#remember").is(":checked")){ // ID 기억하기 체크시 쿠키에 저장
                var userId = $("#email").val();
                setCookie("cookieUserId", userId, 7); // 7일동안 쿠키에 저장
            }else{
                deleteCookie("cookieUserId"); // ID 기억하기 체크하지 않을 시 쿠키 삭제
            }

            var password=$("#password").val();
            var email=$("#email").val();

            $.ajax({ // 로그인을 위한 ajax 통신
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
                    if(data['success']==1){
                        window.location.href="{{route('boards.index')}}"; // 로그인 성공시 카테고리 게시판으로 이동
                    }else{
                        alert("아이디 또는 비밀번호가 틀렸습니다");
                        window.location.href="{{route('login')}}"; // 로그인 실패시 다시 로그인 페이지 이동
                    }
                },
                error:function(data){
                    console.log("오류!");
                }
            });
        })

        function setCookie(cookieName, value, exdays){ // 쿠키를 세팅하는 함수
            var exdate = new Date();
            exdate.setDate(exdate.getDate() + exdays);
            var cookieValue = escape(value)+((exdays==null)? "" : "; expires="+exdate.toGMTString());
            document.cookie = cookieName+"="+cookieValue;
        }

        function deleteCookie(cookieName){ // 쿠키를 삭제하는 함수
            var expireDate = new Date();
            expireDate.setDate(expireDate.getDate()-1);
            document.cookie = cookieName+"= "+"; expires="+expireDate.toGMTString();
        }

        function getCookie(cookieName){ // 쿠키를 얻어오는 함수
            cookieName = cookieName + '=';
            var cookieData = document.cookie;
            var start = cookieData.indexOf(cookieName);
            var cookieValue='';
            if(start != -1){
                start += cookieName.length;
                var end = cookieData.indexOf(';', start);
                if(end == -1){
                    end = cookieData.length;
                }
                cookieValue = cookieData.substring(start, end);
            }
            return unescape(cookieValue);
        }

    });
    </script>
@stop