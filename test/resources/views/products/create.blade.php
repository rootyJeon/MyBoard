@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">

        <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 상 품 &nbsp 등 록</p>

        <form action="/products" method="post" enctype="multipart/form-data" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">상품명</label>
                <input type="text" id="name" name="name"
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
                    <option value="">브랜드 선택</option>
                    @foreach ($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->kor_name}}</option>
                    @endforeach
                </select>
            </p><br>

            <p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">상태</label>
                <input type="radio" name="status" value="1" checked>&nbsp판매중</input>
                <input type="radio" name="status" value="2">&nbsp일시품절</input>
                <input type="radio" name="status" value="3">&nbsp품절</input>
                <input type="radio" name="status" value="4">&nbsp판매중지</input>
            </p><br>

            <p>
                <label for="o_price" class="inline-block w-2/5 text-right mr-4">정가</label>
                <input type="text" id="o_price" name="o_price"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>

            <p>
                <label for="s_price" class="inline-block w-2/5 text-right mr-4">판매가</label>
                <input type="text" id="s_price" name="s_price"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>

            <p>
            <center>
                <img id="preview" height="250" width="250" class="ml-11" align="center"/><br>
                <div class="filebox">
                    <label for="ex_file" class="ml-11">상품이미지 등록</label>
                    <input type="file" id="ex_file" name="ex_file" accept=".jpg,.jpeg,.png"/>
                </div>
            </center>
            </p><br>

            <p>
                <center>
                <input type="button" value="등록" id="reg" style="width:190pt"
                       class="ml-11 bg-green-500 hover:bg-green-700 text-lg text-white rounded-lg"></input><br><br>
                <input type="button" value="취소" id="cancel" style="width:190pt" onclick=history.back();
                       class="ml-11 bg-red-500 hover:bg-red-700 text-lg text-white rounded-lg"></input>
                </center>
            </p>
        </form>
    </section>

    <script>
        var arr = new Array();
        
        $("#add").click(function(){ // id명 변경
            // var select = $("#category").val();

            // arr.push(select);

            // console.log(arr);

            // return false;

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

        $("#reg").click(function(){
            var kalidator = new Kalidator(document.getElementById('frm'));
            var o_price = 0;
            if($("#o_price").val()) o_price = $("#o_price").val();
            console.log(o_price);
            
            var rules = {
                'name' : ['required'],
                'category' : ['required'],
                'brand' : ['required'],
                'o_price' : ['required', 'number', 'minValue:0'],
                's_price' : ['required', 'number', 'minValue:0', 'maxValue:' + o_price],
                'ex_file' : ['required'],
            };

            var messages = {
                'name.required' : '상품명을 입력하세요',
                'category.required' : '카테고리를 선택하세요',
                'brand.required' : '브랜드를 선택하세요',
                'o_price.required' : '정가를 입력하세요',
                'o_price.number' : '정가는 0 이상의 정수만 가능합니다',
                'o_price.minValue' : '정가는 0 이상의 정수만 가능합니다',
                's_price.required' : '판매가를 입력하세요',
                's_price.number' : '판매가는 0 이상의 정수만 가능합니다',
                's_price.minValue' : '판매가는 0 이상의 정수만 가능합니다',
                's_price.maxValue' : '판매가는 정가 이하여야합니다',
                'ex_file.required' : '상품 사진을 입력해주세요',
            };

            kalidator
            .setRules(rules)
            .setMessages(messages)
            .run({
                pass: function(){
                    var form = $("#frm")[0];
                    var formData = new FormData(form);
                    formData.append('arr', arr);
                    // for문 말고 배열을 만드는 함수 사용
                    // for(var i=0; i<arr.length; ++i){
                    //     formData.append('arr[]', arr[i]);
                    // }
                    // console.log(formData);

                    $.ajax({
                        headers: {'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        url: "/products/store",
                        cache: false,
                        enctype: "multipart/form-data",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res){
                            // alert(res.isSuccess);
                            console.log(res);
                            alert($("#name").val() + "이(가) 정상 등록되었습니다.");
                            window.location.href="{{route('products.index')}}";
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown){
                            console.log("실패!");
                            var result = JSON.parse(XMLHttpRequest.responseText);
                            var errors = result.errors;
                            for(prop in errors){
                                alert(errors[prop]);
                            }
                        }
                    });
                },
                fail: function(__errors){
                    alert(kalidator.firstErrorMessage);
                    return false;
                },
            });
            return;
        })

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

    </script>
@stop