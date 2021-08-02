@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
            <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 브 랜 드 &nbsp 수 정</p>
        </center>

        <form action="/brands/{{$brand->id}}" method="post" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="number" class="inline-block w-2/5 text-right mr-4">브랜드 번호</label>
                <input type="text" id="number" name="number" value="{{$brand->id}}" disabled
                    class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>
            <p>
                <label for="kor_name" class="inline-block w-2/5 text-right mr-4">한글명</label>
                <input type="text" id="kor_name" name="kor_name" class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg" value="{{$brand->kor_name}}">
            </p><br>
            <p>
                <label for="eng_name" class="inline-block w-2/5 text-right mr-4">영문명</label>
                <input type="text" id="eng_name" name="eng_name" class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg" value="{{$brand->eng_name}}">
            </p><br>
            <p>
                <label for="introduction" class="inline-block w-2/5 text-right mr-4">소개문구</label>
                <textarea style="overflow-x:hidden; overflow-y:auto;" id="introduction" name="introduction" rows="8" 
                        class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg resize-none">{{$brand->introduction}}</textarea>
            </p><br>
            <p>
                <center>
                    <input type="button" value="수정" style="width:190pt" id="update_btn" name="update_btn"
                           class="ml-11 bg-green-500 hover:bg-green-700 text-lg text-white rounded-lg"><br><br>
                    <input type="button" value="취소" style="width:190pt" id="cancel" name="cancel" onclick=history.back();
                           class="ml-11 bg-red-500 hover:bg-red-700 text-lg text-white rounded-lg">
                </center>
            </p>
        </form>
    </section>

    <script>
        $(function(){

            $("#update_btn").click(function(){
                var form = $("#frm")[0];
                var formData = new FormData(form);

                $.ajax({
                    headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: '/brands/{{$brand->id}}/update',
                    type: "post",
                    cache: false,
                    enctype: "multipart/form-data",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(data){
                        console.log(data);
                        var op = data['success'];
                        if(op == 1){
                            alert("{{$brand->kor_name}}({{$brand->eng_name}})에서 " + $("#kor_name").val() + "(" + $("#eng_name").val() + ") (으)로 수정되었습니다");
                            window.location.href="{{route('brands.index')}}";
                        }else if(op == 0){
                            alert("이미 존재하는 소개문구입니다.");
                        }else if(op == -1){
                            alert("이미 존재하는 영문명입니다.");
                        }else if(op == -2){
                            alert("이미 존재하는 한글명입니다.");
                        }else{
                            alert("변경사항이 없습니다.");
                        }
                    },
                    error: function(data){
                        console.log("오류!");
                    }
                });
            })

        });
    </script>
@stop