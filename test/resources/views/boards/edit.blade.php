@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
            <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 카 테 고 리 &nbsp 수 정</p>
        </center>

        <form action="/boards/{{$board->id}}" method="post" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="number" class="inline-block w-2/5 text-right mr-4">카테고리 번호</label>
                <input type="text" id="number" name="number" value="{{$board->id}}" disabled
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p>
            <br><p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">카테고리명</label>
                <input type="text" id="name" name="name" value="{{$board->name}}"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p>
            <p class="mt-4">
                <label for="usable" class="inline-block w-2/5 text-right mr-4">사용여부</label>
                <input type="checkbox" id="use" name="use" 
                       class="outline-none border border-blue-400 w-1/8 pl-1 py-1 rounded-lg">&nbsp사용&emsp;&emsp;&emsp;&emsp;</input>
                <input type="checkbox" id="not_use" name="not_use"
                       class="outline-none border border-blue-400 w-1/8 pl-1 py-1 rounded-lg">&nbsp미사용</input>
            </p>

            <p class="mt-8">
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

            $.ajax({
                    headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: '/boards/{{$board->id}}/usable_status',
                    type: 'get',
                    enctype: false,
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        console.log(data);
                        if(data == 1){
                            $("#use").prop("checked", true);
                        }else{
                            $("#not_use").prop("checked", true);
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
                    url: "/boards/not_usable",
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
                    url: "/boards/is_usable",
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

            $("#update").click(function(){
                var form = $("#frm")[0];
                var formData = new FormData(form);

                var usable = "미사용";
                if($("#use").is(":checked")){
                    usable = "사용";
                }
                var o_usable = "미사용";
                if("{{$board->usable}}"){
                    o_usable = "사용";
                }

                var op = confirm("{{$board->name}} " + o_usable + "에서 " + $("#name").val() + " " + usable + "(으)로 수정하시겠습니까?");
                if(op){
                    $.ajax({
                    headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: '/boards/{{$board->id}}/update',
                    type: 'post',
                    enctype: false,
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        // console.log(data);
                        if(data['success']){
                            window.location.href="{{route('boards.index')}}";
                        }else{
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
        <form action="/boards/{{$board -> id}}" method="post">
            @method('PUT')
            @csrf
            <p>
                <label for="name" class="text-xl">카테고리명 : </label>
                <input type="text" id="name" name="name" value="{{$board -> name}}"
                       class="outline-none border border-blue-400 w-1/2 pl-1 py-1 rounded-lg">
            </p>
            <p class="mt-4">
                <label for="usable" class="text-xl">사용 여부</label>
                <textarea id="usable" name="usable"
                          class="outline-none border border-blue-400 w-full h-64 mt-2 rounded-lg resize-none">{{$board -> usable}}</textarea>
            </p>
            <p class="mt-8">
                <input type="submit" value="수정"
                       class="px-4 py-1 bg-green-500 hover:bg-green-700 text-lg text-white">
                <input type="button" value="취소" onclick="history.back()"
                       class="px-4 py-1 ml-6 bg-red-500 hover:bg-red-700 text-lg text-white">
            </p>
        </form>
    </section> -->