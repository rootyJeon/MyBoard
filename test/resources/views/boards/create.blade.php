@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
        <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 카 테 고 리 &nbsp 등 록</p>
        </center>

        <form action="/boards" method="post" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">카테고리명</label>
                <input type="text" id="name" name="name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p>
            <p class="mt-4">
                <label for="usable" class="inline-block w-2/5 text-right mr-4">사용여부</label>
                <input type="checkbox" id="use" name="use" checked="checked"
                        class="outline-none border border-blue-400 w-1/8 pl-1 py-1 rounded-lg">&nbsp사용&emsp;&emsp;&emsp;&emsp;</input>
                <input type="checkbox" id="not_use" name="not_use"
                        class="outline-none border border-blue-400 w-1/8 pl-1 py-1 rounded-lg">&nbsp미사용</input>
            </p>

            <p class="mt-8">
                <center>
                <input type="button" value="등록" id="reg"
                class="px-4 py-1 bg-green-500 hover:bg-green-700 text-lg text-white">
                <input type="button" value="취소" onclick="history.back()"
                       class="px-4 py-1 ml-6 bg-red-500 hover:bg-red-700 text-lg text-white">
                </center>
            </p>
        </form>
    </section>

    <script>
        $(function(){

            $("#reg").click(function(){
                var form = $("#frm")[0];
                var formData = new FormData(form);

                var name = $("#name").val();
                console.log(name);

                $.ajax({
                    headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: "/boards/store", // 하... web.php의 prefix가 boards이니 url도 맞춰줘야한다..
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
                            window.location.href="{{route('boards.index')}}";
                        }else{
                            alert("중복된 카테고리명입니다");
                        }
                    },
                    error:function(data){
                        console.log("오류!");
                    }
                });

            })

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

        });

    </script>
@stop