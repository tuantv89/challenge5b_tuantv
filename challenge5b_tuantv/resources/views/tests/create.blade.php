@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Thêm mới Bài tập</div>
<form method="post" action="{{ route('test.create') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-group">
        <label>Tên Bài tập</label>
        <input type="text" name="name_test" required value=""
               class="form-control"/>
    </div>

    <div class="form-group">
        <label>File Bài tập</label>
        <input type="file" name="test" required class="form-control" id="category-avatar"/>
    </div>

    <div class="form-group">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" selected >Hoạt động</option>
            <option value="0" >Không hoạt động</option>
        </select>
    </div>

    <input type="submit" class="btn btn-primary" name="submit" value="Thêm"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
</form>
@endsection
