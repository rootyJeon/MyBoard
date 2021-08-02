@extends('layouts.app')

@section('section')
    <section class="w-2/3 mx-auto">
        <center>
            <p class="border-b border-gray-400 text-left mb-8 pb-1 text-2xl">&nbsp 상 품 &nbsp 등 록</p>
        </center>

        <form action="/products" method="post" class="mt-8 w-full" id="frm">
            @csrf
            <p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">상품명</label>
                <input type="text" id="name" name="name"
                       class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg">
            </p><br>
            <p>
                <label for="category" class="inline-block w-2/5 text-right mr-4">카테고리</label>
                <select name="category" class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg" style="width:180px">
                    <option value="">카테고리 선택</option>
                    @foreach ($boards as $board)
                    <option>{{$board->name}}</option>
                    @endforeach
                </select>
                <input type="button" value="추가" id="reg" style="width:50pt"
                       class="ml-1 bg-yellow-500 hover:bg-yellow-700 text-lg text-white rounded-lg"></input>
            </p>
            <div class="font_size w-4/2 text-middle" id="registed_cat"></div><br>
            <p>
                <label for="brand" class="inline-block w-2/5 text-right mr-4">브랜드</label>
                <select name="brand" class="outline-none border border-blue-400 w-1/5 pl-1 py-1 rounded-lg" style="width:260px">
                    <option value="">브랜드 선택</option>
                    @foreach ($brands as $brand)
                    <option>{{$brand->kor_name}}</option>
                    @endforeach
                </select>
            </p><br>
            <p>
                <label for="name" class="inline-block w-2/5 text-right mr-4">상태</label>
                <input type="radio" name="status" value="sell" checked>&nbsp판매중</input>
                <input type="radio" name="status" value="tmp">&nbsp일시품절</input>
                <input type="radio" name="status" value="soldout">&nbsp품절</input>
                <input type="radio" name="status" value="stop">&nbsp판매중지</input>
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
                <div class="filebox">
                    <img scr="" id="preview" height="150" width="150" class="inline-block w-2/5 text-right mr-4"/>
                    <label for="ex_file">상품이미지 등록</label>
                    <input type="file" id="ex_file" accept=".jpg,.jpeg,.png">
                </div>
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