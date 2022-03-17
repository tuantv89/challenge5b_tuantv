@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Challenge: {{ $challenge->title }}</div>

<table class="table table-bordered">
    <tr>
        <th>Tên Challenge</th>
        <td>{{ $challenge->title }}</td>
    </tr>
    <tr>
        <th>Người tạo</th>
        <td>{{ $challenge->username }}</td>
    </tr>
    <tr>
        <th>Gợi ý</th>
        <td>{{ $challenge->suggest }}</td>
    </tr>
</table>
<a style="margin-bottom: 40px" class="btn btn-primary" href="{{ route('challenge.index') }}">Trở lại</a>
<div class="right__title" >Đáp án</div>
@if( $check==true)
<div>
    <h2>Bạn trả lời Đúng</h2>
    <h4>Đáp án: {{ $answer }}</h4>
</div>
@elseif($check==false)
<h2>Bạn trả lời sai</h2>
@else
@endif

<div class="right__title" ></div>
<form method="post" action="{{ route('challenge.answer',['id' => $challenge->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-group">
        <label>Nhập câu trả lời</label>
        <input type="text" name="answer" required class="form-control">
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Trả lời"/>
</form>
@endsection
