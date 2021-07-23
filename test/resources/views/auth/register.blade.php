@extends('layouts.app')

@section('section')
    <div class="w-2/3 mx-auto mt-16">
        <form action="/auth/register" method="post" class="w-1/2 mx-auto" id="frm">
            @csrf
            <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 관 리 자 등 록</p>
            <center>
            <p>
                <label for="email" class="inline-block w-1/4 text-right mr-4">이메일</label>
                <input type="email" id="email" name="email"
                       class="outline-none border border-blue-400 rounded-lg pl-1 w-1/3"/>
                       <div class="check_font" id="mailcheck"></div>
            </p>
            <p class="mt-4">
                <label for="password" class="inline-block w-1/4 text-right mr-4">비밀번호</label>
                <input type="password" id="password" name="password"
                       class="outline-none border border-blue-400 rounded-lg pl-1 w-1/3"/>
                       <div class="check_font" id="passwordcheck"></div>
            </p>
            <p class="mt-4">
                <label for="password_confirmation" class="inline-block w-1/4 text-right mr-4">비밀번호 확인</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="outline-none border border-blue-400 rounded-lg pl-1 w-1/3"/>
            </p>
            <p class="mt-4">
                <label for="name" class="inline-block w-1/4 text-right mr-4">이름</label>
                <input type="text" id="name" name="name"
                       class="outline-none border border-blue-400 rounded-lg pl-1 w-1/3"/>
                       <div class="check_font" id="namecheck"></div>
            </p>
            <p class="mt-8">
                <input type="button" value="가입" 
                       class="bg-blue-500 hover:bg-blue-700 px-4 py-1 text-lg text-white rounded-lg outline-none" id="btn">
                <input type="button" class="bg-red-500 hover:bg-red-700 px-4 py-1 ml-4 text-lg text-white rounded-lg outline-none"
                        onclick="window.location.href = '{{route('home')}}'" value="취소">
            </p>
            </center>
        </form>
    </div>

    <script>
        $(function(){
            var isEmail = 0;
            // 이메일 msg
            $("#email").keyup(function(e){
                e.preventDefault();

                var form = $("#frm")[0];            // id="frm" 안에 있는 모든 내용을 가져온다.
                var formData = new FormData(form);  // 파일을 비동기 방식으로 전송하기 위해서 formData 사용

                // console.log(formData);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/email_check",
                    type: "post",
                    enctype: "multipart/form-data",
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) { 
                        var email = $('#email').val();
                        //console.log(data);
                        
                        if(data == -1){
                            $("#mailcheck").text("올바른 이메일 형식이 아닙니다");
                            $("#mailcheck").css("color", "red");
                        }

                        if(data == 0){
                            $("#mailcheck").text("이미 등록된 이메일입니다");
                            $("#mailcheck").css("color", "red");
                        }

                        if(data == 1){
                            $("#mailcheck").text("사용할 수 있는 이메일입니다");
                            $("#mailcheck").css("color", "green");
                            isEmail = 1;
                        }

                        if(email == ""){
                            $("#mailcheck").text("이메일을 입력하세요");
                            $("#mailcheck").css("color", "red");
                        }
                    },
                    error: function (request, status, error) {
                        // 통신에 문제가 발생했을 때 함수를 실행
                        console.log('오류 발생!');
                    }
                });
            })

            // ajax 통한 저장 :: 이메일 ajax 한번, 나머지 정보 db 타야하므로 ajax 두번
            $("#btn").click(function(){             // 여기서 btn의 type이 submit이면 충돌나네?!
                var form = $("#frm")[0];            // id="frm" 안에 있는 모든 내용을 가져온다.
                var formData = new FormData(form);  // 파일을 비동기 방식으로 전송하기 위해서 formData 사용

                var pwd=$("#password").val();
                var pwd_cfm=$("#password_confirmation").val();
                var name=$('#name').val();
                
                //console.log(isEmail);
                $('#passwordcheck').text("");
                $('#namecheck').text("");

                if(name==""){
                    $('#namecheck').text("이름을 입력하세요");
                    $('#namecheck').css("color", "red");
                }
                if(pwd==""){
                    $('#passwordcheck').text("비밀번호를 입력하세요");
                    $('#passwordcheck').css("color", "red");
                }else if(pwd != pwd_cfm){
                    $('#passwordcheck').text("비밀번호가 같지 않습니다");
                    $('#passwordcheck').css("color", "red");
                }else if(pwd.length < 8){
                    $('#passwordcheck').text("비밀번호는 8자리 이상이여야 합니다");
                    $('#passwordcheck').css("color", "red");
                }else if(isEmail == 1){
                    console.log(isEmail);
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "/auth_store",
                        type: "post",
                        enctype: "multipart/form-data",
                        cache: false,
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            console.log('정상 작동!');
                            window.location.href='{{route('login')}}';
                        },
                        error: function (request, status, error) {
                            // 통신에 문제가 발생했을 때 함수를 실행
                            console.log('오류 발생!');
                        }
                    });
                }else{
                    alert("가입할 수 없는 이메일입니다");
                }
            })

        });
    </script>
    <!-- axios -->
@stop