@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
            <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 상 품 &nbsp 수 정</p>
        </center>

        <form action="/products/{{$products->id}}" method="post" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="number" class="inline-block w-2/5 text-right mr-4">상품번호</label>
                <input type="text" id="number" name="number" value="{{$products->id}}" disabled 
                    class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>

            <p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">상품명</label>
                <input type="text" id="name" name="name" value="{{$products->name}}" 
                    class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>

            <p>
                <label for="category" class="inline-block w-2/5 text-right mr-4">카테고리</label>
                <select name="category" id="category" class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg" style="width:180px">
                    <option value="">카테고리 선택</option>
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                <input type="button" value="추가" id="add" style="width:50pt"
                       class="ml-1 bg-yellow-500 hover:bg-yellow-700 text-lg text-white rounded-lg"></input><br>
                <center><font size=2><div class="font_check mx-auto" id="catcheck"></div></font></center>
            </p><br>

            <p>
                <label for="brand" class="inline-block w-2/5 text-right mr-4">브랜드</label>
                <select name="brand" class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg" style="width:260px">
                    @foreach ($brands as $brand)
                        @if($brand->kor_name == $products->brand->kor_name)
                            <option value="{{$brand->id}}" selected="selected">{{$products->brand->kor_name}}({{$products->brand->eng_name}})</option>
                        @else
                            <option value="{{$brand->id}}">{{$brand->kor_name}}({{$brand->eng_name}})</option>
                        @endif
                    @endforeach
                </select>
            </p><br>

            <p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">상태</label>
                <input type="radio" name="status" id="sale" value="1">&nbsp판매중</input>
                <input type="radio" name="status" id="tmpout" value="2">&nbsp일시품절</input>
                <input type="radio" name="status" id="soldout" value="3">&nbsp품절</input>
                <input type="radio" name="status" id="stop" value="4">&nbsp판매중지</input>
            </p><br>

            <p>
                <label for="o_price" class="inline-block w-2/5 text-right mr-4">정가</label>
                <input type="text" id="o_price" name="o_price" value="{{$products->o_price}}"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>

            <p>
                <label for="s_price" class="inline-block w-2/5 text-right mr-4">판매가</label>
                <input type="text" id="s_price" name="s_price" value="{{$products->s_price}}"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>

            <p>
            <center>
                <img src="http://localhost:8000/storage/images/{{$products->image_name}}" id="preview" height="250" width="250" class="ml-11" align="center"/><br>
                <div class="filebox">
                    <label for="ex_file" class="ml-11">상품이미지 등록</label>
                    <input type="file" id="ex_file" name="ex_file" accept=".jpg,.jpeg,.png"/>
                </div>
            </center>
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
        var arr = new Array();

        var form = $("#frm")[0];
        var formData = new FormData(form);

        // $.ajax({
        //     headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
        //     url: '/products/{{$products->id}}/status',
        //     type: 'get',
        //     enctype: false,
        //     cache: false,
        //     dataType: "json",
        //     data: formData,
        //     processData: false,
        //     contentType: false,
        //     success:function(data){

        //     },
        //     error:function(data){
        //         console.log('오류!');
        //     }
        // })

        $.ajax({ // db에 저장된 상태에 따라 라디오 박스를 체크해주는 ajax code 
                headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
                url: '/products/{{$products->id}}/status',
                type: 'get',
                enctype: false,
                cache: false,
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success:function(data){
                    console.log(data);
                    var status = data['status'];
                    var category = data['category'];

                    for(var i=0; i<category.length; ++i){
                        console.log(category[i]);
                        // var val = $("#category option[value=" + category[i] + "]").text();
                        var val = $("#category").find('option[value=' + category[i] + ']').text();
                        console.log(val);
                        var code="<span class='added'>* " + val + " <font color='red'><input type='button' value='&#215;' onclick='$(this).parent().parent().remove(); removeInArr(" + category[i] + ");' class='outline:none;'/></font></span> ";
                        $("#catcheck").append(code);
                        arr.push(String(category[i]));
                        console.log(arr);
                    }

                    if(status==1){
                        $("#sale").prop("checked", true); 
                    }else if(status==2){
                        $("#tmpout").prop("checked", true);
                    }else if(status==3){
                        $("#soldout").prop("checked", true); 
                    }else{
                        $("#stop").prop("checked", true); 
                    }
                },
                error:function(data){
                    console.log("오류!");
                }
        });
        
        $("#add").click(function(){
            var form = $("#frm")[0];
            var formData = new FormData(form);

            $.ajax({
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                url: "/products/add",
                type: "post",
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){
                    // console.log(data[0]);
                    var select = data[0]['category'];
                    var op = jQuery.inArray(select, arr);

                    if(arr.length > 2){
                        alert("카테고리를 3개 이상 고를 수 없습니다");
                    }else if(select == null){
                        alert("카테고리를 선택해주세요");
                    }else if(op === -1){
                        // console.log(data[0]['category']);
                        arr.push(select);
                        var val=$("#category").find('option:selected').text();
                        var code="<span class='added'>* " + val + " <font color='red'><input type='button' value='&#215;' onclick='$(this).parent().parent().remove(); removeInArr(" + select + ");' class='outline:none;'/></font></span> ";
                        $("#catcheck").append(code);
                    }else{
                        alert("카테고리가 중복되어 추가할 수 없습니다");
                    }
                },
                error: function(data){
                    console.log("오류!");
                }
            });
        })

        function removeInArr(val){
            var idx=arr.indexOf(String(val));
            arr.splice(idx, 1);
            console.log(arr);
        }

        $('#ex_file').change(function(){
            setImageFromFile(this, '#preview');
        });

        function setImageFromFile(input, expression) {
            if (input.files && input.files[0])
            {
                var reader = new FileReader();
        
                    reader.onload = function (e) {
                        $(expression).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#update_btn").click(function(){ // 브랜드 수정 버튼 클릭 시
                var form = $("#frm")[0];
                var formData = new FormData(form);
                for(var i=0; i<arr.length; ++i){
                    formData.append('arr[]', arr[i]);
                }

                $.ajax({ // 브랜드 수정하는 ajax
                    headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    url: '/products/{{$products->id}}/update',
                    type: "post",
                    cache: false,
                    enctype: "multipart/form-data",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(data){
                        console.log(data);
                        window.location.href="{{route('products.index')}}";
                    },
                    error: function(data){
                        console.log("오류!");
                    }
                });
            })
    </script>
@stop