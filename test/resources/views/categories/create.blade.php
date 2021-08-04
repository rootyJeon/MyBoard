@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
        <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 카 테 고 리 &nbsp 등 록</p>
        </center>

        <form action="/categories" method="post" class="mt-8 w-full" id="frm">
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

            $("#reg").click(function(){ // 등록 버튼이 눌린다면
                var form = $("#frm")[0];
                var formData = new FormData(form);

                var name = $("#name").val();
                // console.log(name);

                $.ajax({ // 유효성 검사 후 등록하는 함수
                    headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: "/categories/store", // 하... web.php의 prefix가 categories이니 url도 맞춰줘야한다..
                    type: "post",
                    enctype: "multipart/form-data",
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        // console.log(data);
                        if(data['success']){ // 카테고리명이 중복되지 않는다면
                            window.location.href="{{route('categories.index')}}"; // 카테고리 페이지로 이동한다
                        }else{ // 카테고리명이 중복되었다면 중복 사실 alert
                            alert("중복된 카테고리명입니다");
                        }
                    },
                    error:function(data){
                        console.log("오류!");
                    }
                });

            })

            // 여기부턴 radio button을 몰라서 checkbox 만으로 turn off 기능을 구현했다가 아직 radio button으로 업데이트를 못한 안타까운 구간입니다..
            // 이 구현상에서는 ajax 방식이 두번 돌아가게 되면서 느리다는 문제점이 있다.
            $('#not_use').click(function(){ // 미사용 체크박스 클릭시
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
                        if(data['success']){ // 한쪽이 체크되면 다른 한쪽이 체크되는 방식, .prop를 통해 반대쪽 박스를 체크시켰다.
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

            $('#use').click(function(){ // 사용 버튼 클릭 시 미사용 박스와 동일한 방식으로 작동된다. 한 쪽에서 클릭이 되면 반대쪽 박스를 체크시켜주는 기능
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

        });

    </script>
@stop