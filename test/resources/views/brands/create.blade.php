@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
        <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp브 랜 드 &nbsp 등 록</p>
        </center>

        <form action="/brands" method="post" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="kor_name" class="inline-block w-2/5 text-right mr-4">한글명</label>
                <input type="text" id="kor_name" name="kor_name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
                <div class="font_size w-4/2 text-middle" id="korcheck"></div>
            </p><br>

            <p>
                <label for="eng_name" class="inline-block w-2/5 text-right mr-4">영문명</label>
                <input type="text" id="eng_name" name="eng_name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
                <div class="font_size w-4/2 text-middle" id="engcheck"></div>
            </p><br>

            <p>
                <label for="introduction" class="inline-block w-2/5 text-right mr-4">소개문구</label>
                <textarea style="overflow-x:hidden; overflow-y:auto;" id="introduction" name="introduction" rows="8"
                          class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg resize-none"></textarea>
                <div class="font_size w-4/2 text-middle" id="introcheck"></div>
            </p><br>
            
            <p>
                <center>
                <input type="button" value="등록" id="reg" style="width:190pt"
                       class="ml-11 bg-green-500 hover:bg-green-700 text-lg text-white rounded-lg"></input><br><br>
                <input type="button" value="취소" id="reg" style="width:190pt" onclick=history.back();
                       class="ml-11 bg-red-500 hover:bg-red-700 text-lg text-white rounded-lg"></input>
                </center>
            </p>
        </form>
    </section>

    <script>
        $(function(){
            
            $("#reg").click(function(){ // 브랜드 등록 버튼 클릭 시
                var form = $("#frm")[0];
                var formData = new FormData(form);

                $.ajax({ // 브랜드를 새로 등록하는 ajax
                    headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: "/brands/store",
                    type: "post",
                    cache: false,
                    dataType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        console.log($("#kor_name").val());
                        $op = data['success'];
                        if($op == 1){ // 입력값들이 유효성 검증을 정상 통과했을 경우
                            alert($("#kor_name").val() + "(" + $("#eng_name").val() + ")이(가) 정상적으로 등록되었습니다"); // 정상 등록 alert 후
                            window.location.href="{{route('brands.index')}}" // 브랜드 게시판으로 이동
                        }
                        if($op == 0){ // 유효성 검증 중 영문명에서 중복 발생 시
                            alert("동일한 영문명이 존재합니다");
                        }
                        if($op == -1){ // 유효성 검증 중 한글명에서 중복 발생 시
                            alert("동일한 브랜드가 존재합니다");
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

<!-- textarea에서 resize-none이랑 rows 잘 기억하자! -->