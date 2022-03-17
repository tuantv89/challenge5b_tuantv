@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Cập nhật Ảnh đại diện Người dùng {{ $user->username }} Bằng URL</div>
<a href="{{ route("user.update",["id" => $id]) }}"><button style="width: 100px; margin-bottom: 20px" class="btn btn-primary">Trở lại</button></a>
<form method="post" action="{{ route("user.avatar",["id"=>$id]) }}" enctype="multipart/form-data">
    @csrf
    @method("POST")
    <div class="form-group">
        <label>URL</label>
        <input type="text" required name="url" value="" class="form-control" />
    </div>
    <input type="submit" class="btn btn-primary" name="update" value="Save"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
</form>
<a class
@endsection
