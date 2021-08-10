@extends('layouts.app')

@section('section')
    <div class="container">

        <!-- 등록된 메뉴 목록 -->
        <div class="ex_div">
            <ul>
                <li><a href="{{ route('auth.register.index') }}">사용자 관리</a></li>
                <li><a href="{{ route('brands.index') }}">브랜드 관리</a></li>
                <li><a href="{{ route('categories.index') }}">카테고리 관리</a></li>
                <li><a href="{{ route('products.index') }}">상품 관리</a></li>
            </ul>
        </div>

        <!-- form 예제 -->
        <div class="ex_div">
            <form id="form_submit" name="form_submit" onsubmit="return false;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- input text -->
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">제목</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control is-invalid" id="title" name="title" placeholder="title">
                        <small class="form-text">We'll never share your email with anyone else.</small>
                    </div>
                </div>

                <!-- select -->
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">브랜드</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="brand" style="appearance:auto;">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                </div>

                <!-- radio -->
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">사용여부</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="isuse" id="isuse_y" value="Y">
                            <label class="form-check-label" for="isuse_y">사용</label>
                        </div>                            
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="isuse" id="isuse_n" value="N">
                            <label class="form-check-label" for="isuse_n">미사용</label>
                        </div>
                    </div>
                </div>

                <!-- checkbox -->
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">체크박스</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">1</label>
                        </div>                         
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">2</label>
                        </div>
                    </div>
                </div>


                <button type="button" class="btn btn-primary" id="btn_submit">SUBMIT</button>
            </form>
        </div>
        
    </div>

    <script>
        $(function(){

            $('#btn_submit').click(function(e){

                var kalidator = new Kalidator(document.getElementById('form_submit'));

                var rules = {
                    //'title(제목)': ['required', 'maxLength:100'],
                };

                var messages = {
                    // 'title.required': ':param(을/를) 입력해주세요.',
                    // 'title.maxLength': ':param(은/는) 최대 :$0자까지 입력 가능합니다.',
                };

                kalidator
                .setRules(rules)
                .setMessages(messages)
                .run({
                    pass: function () {

                        var formData = $('#form_submit').serialize();

                        console.log(formData);

                        $.ajax({
                            type : 'POST',
                            url : '{{ route("example.store") }}',
                            data : formData,
                            success : function(res){
                                alert(res.isSuccess);
                                console.log(res);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown){
                                alert("통신 실패.");
                                console.log(XMLHttpRequest.responseText);
                            }
                        });
                        
                    },
                    fail: function (__errors) {
                        alert("here?");
                        alert(kalidator.firstErrorMessage);
                        return false;
                    },
                });
                

                return;
            });
        });
    </script>


@stop