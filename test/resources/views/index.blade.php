@extends('master')

@section('title')
    Welcome
@endsection

@section('content')
    <h2>News List</h2>
    @foreach ($News as $item)
        번호: {{$item -> id}}<br>
        제목: {{$item -> title}}<br>
        내용: {{$item -> story}}<br>
    @endforeach

@endsection