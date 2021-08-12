@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
            <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 카 테 고 리 &nbsp 수 정</p>
        </center>

        <form action="/categories/{{$category->id}}" method="post" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="number" class="inline-block w-2/5 text-right mr-4">카테고리 번호</label>
                <input type="text" id="number" name="number" value="{{$category->id}}" disabled
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>
            
            <p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">카테고리명</label>
                <input type="text" id="name" name="name" value="{{$category->name}}"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p>
            
            <p class="mt-4">
                <label for="usable" class="inline-block w-2/5 text-right mr-4">사용여부</label>
                <input type="checkbox" id="use" name="use" 
                       class="outline-none border border-blue-400 w-1/8 pl-1 py-1 rounded-lg">&nbsp사용&emsp;&emsp;&emsp;&emsp;</input>
                <input type="checkbox" id="not_use" name="not_use"
                       class="outline-none border border-blue-400 w-1/8 pl-1 py-1 rounded-lg">&nbsp미사용</input>
            </p>

            <p class="mt-4">
                <center>
                <input type="button" value="수정" id="update"
                class="px-4 py-1 bg-green-500 hover:bg-green-700 text-lg text-white">
                <input type="button" value="취소" onclick="history.back()"
                       class="px-4 py-1 ml-6 bg-red-500 hover:bg-red-700 text-lg text-white">
                </center>
            </p>
        </form>
    </section>

    <script>
        $(function(){

            var form = $("#frm")[0];
            var formData = new FormData(form);

            $.ajax({ // db에 저장된 값이 0인지 1인지에 따라 체크해줄 박스를 결정하는 ajax 
                    headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: '/categories/{{$category->id}}/usable_status',
                    type: 'get',
                    enctype: false,
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        // console.log(data);
                        if(data == 1){ // db에 저장된 값이 1이라면
                            $("#use").prop("checked", true); // 사용 체크박스에 체크
                        }else{ // db에 저장된 값이 0이라면
                            $("#not_use").prop("checked", true); // 미사용 체크박스에 체크
                        }
                    },
                    error:function(data){
                        console.log("오류!");
                    }
            });

            $('#not_use').click(function(){
                var form = $("#frm")[0];
                var formData = new FormData(form);

                $.ajax({
                    headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: "/categories/not_usable",
                    type: "post",
                    enctype: "multipart/form-data",
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        // console.log(data);
                        if(data['success']){
                            $("#use").prop("checked", false);
                        }else{
                            $("#use").prop("checked", true);
                        }
                    },
                    error:function(data){
                        console.log("오류!");
                    }
                });
            })

            $('#use').click(function(){
                var form = $("#frm")[0];
                var formData = new FormData(form);

                $.ajax({
                    headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: "/categories/is_usable",
                    type: "post",
                    enctype: "multipart/form-data",
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        // console.log(data);
                        if(data['success']){
                            $("#not_use").prop("checked", false);
                        }else{
                            $("#not_use").prop("checked", true);
                        }
                    },
                    error:function(data){
                        console.log("오류!");
                    }
                });
            })

            $("#update").click(function(){ // 수정하는 함수
                var form = $("#frm")[0];
                var formData = new FormData(form);

                var usable = "미사용"; //129행~ 136행은 138행의 confirm을 하기 위한 코드. ajax 통신 전 상태를 받아오기 위함이다
                if($("#use").is(":checked")){
                    usable = "사용";
                }
                var o_usable = "미사용";
                if("{{$category->usable}}"){
                    o_usable = "사용";
                }

                var op = confirm("{{$category->name}} " + o_usable + "에서 " + $("#name").val() + " " + usable + "(으)로 수정하시겠습니까?");
                if(op){ // 수정에 동의하면 수정하는 통신 시작
                    $.ajax({
                    headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: '/categories/{{$category->id}}/update',
                    type: 'post',
                    enctype: false,
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        // console.log(data);
                        if(data['success']){ // 카테고리 유효성을 통과하여 정상적으로 저장될 경우
                            window.location.href="{{route('categories.index')}}"; //카테고리 게시판으로 이동
                        }else{ // 유효성 검증에서 통과하지 못한 경우 중복 alert
                            alert("이미 존재하는 카테고리입니다");
                        }
                    },
                    error:function(data){
                        console.log("오류!");
                    }
                    });
                }

            })

        });
    </script>
@stop



    <!-- <section class="w-2/3 mx-auto mt-16">
        <form action="/categories/{{$category -> id}}" method="post">
            @method('PUT')
            @csrf
            <p>
                <label for="name" class="text-xl">카테고리명 : </label>
                <input type="text" id="name" name="name" value="{{$category -> name}}"
                       class="outline-none border border-blue-400 w-1/2 pl-1 py-1 rounded-lg">
            </p>
            <p class="mt-4">
                <label for="usable" class="text-xl">사용 여부</label>
                <textarea id="usable" name="usable"
                          class="outline-none border border-blue-400 w-full h-64 mt-2 rounded-lg resize-none">{{$category -> usable}}</textarea>
            </p>
            <p class="mt-8">
                <input type="submit" value="수정"
                       class="px-4 py-1 bg-green-500 hover:bg-green-700 text-lg text-white">
                <input type="button" value="취소" onclick="history.back()"
                       class="px-4 py-1 ml-6 bg-red-500 hover:bg-red-700 text-lg text-white">
            </p>
        </form>
    </section> -->