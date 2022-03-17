@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Chi tiết bài tập</div>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $test->id }}</td>
    </tr>
    <tr>
        <th>Name</th>
        <td>{{ $test->name_test }}</td>
    </tr>
    <tr>
        <th>Người Đăng</th>
        <td>{{ $test->username }}</td>
    </tr>
    <tr>
        <th>Download</th>
        <td>
            <a href="{{ route('test.download',['id'=>$test->id]) }}">Download</a>
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($test->is_active)
                Hoạt động
            @else
                Không hoạt động
            @endif
        </td>
    </tr>
    <tr>
        <th>Created_at</th>
        <td>
            {{ $test->created_at }}
        </td>
    </tr>
</table>
<a class="btn btn-primary" href="{{ route('test.index') }}">Back</a>
<br> <br>
<div class="right__title" >Nộp bài</div>
<form method="post" action="{{ route('submit.create',['id'=>$test->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-group">
        <label>Chọn File nộp</label>
        <input type="file" name="sub" required class="form-control" id="category-avatar"/>
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Nộp bài"/>
</form>
    <br>
<div class="right__title" >Danh sách Người dùng bài nộp</div>
<table class="table table-bordered">
    <tr>
        <th>Người nộp</th>
        <th>Download</th>
        <th>Thời gian</th>
    </tr>
    @if(!empty($submits))
        @foreach($submits as $submit)
            <tr >
                <td>{{$submit->username}}</td>
                <td><a href="{{ route('submit.download',['id' => $submit->id]) }}">Download</a></td>
                <td>{{$submit->created_at}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">Không có Bài nộp nào!</td>
        </tr>
    @endif
</table>
@endsection
