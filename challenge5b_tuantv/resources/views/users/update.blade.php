@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Cập nhật Người dùng </div>
<a href="{{ route("user.avatar",["id" => $user->id]) }}"><button style="width: 230px; margin-bottom: 20px" class="btn btn-primary">Cập nhật ảnh đại diện bằng URL</button></a>
<form method="post" action="{{ route('user.update',['id' => $user->id]) }}" enctype="multipart/form-data">
    @csrf
    @method("POST")
    @if(\Illuminate\Support\Facades\Auth::user()->role_id==1 && \Illuminate\Support\Facades\Auth::id()!=$user->id)
    <div class="form-group">
        <label>Tên tài khoản</label>
        <input type="text" name="username" value="{{ $user->username }}" class="form-control" />
    </div>
    <div class="form-group">
        <label>Họ và tên</label>
        <input type="text" name="full_name" value="{{ $user->full_name }}" class="form-control" />
    </div>
    @endif
    <div class="form-group">
        <label>Mật khẩu mới</label>
        <input type="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control" />
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control" />
    </div>

    <!-- <div class="form-group">
        <label for="avatar">Ảnh đại diện</label>
        <input type="file" name="avatar" value="" class="form-control" id="avatar"/>
            <br>
        @if(!empty($user->avatar))
            <img height="120" src="{{ asset("storage/avatars/".$user->avatar) }}"/> <br>
        @endif
    </div> -->

    <div class="form-group">
        <label>Trạng thái</label>
        <select name="is_active" class="form-control">
            <option value="1" @if($user->is_active == 1) selected @endif >Hoạt động</option>
            <option value="0" @if($user->is_active == 0) selected @endif >Không hoạt động</option>
        </select>
    </div>
    </div>

    <input type="submit" class="btn btn-primary" name="update" value="Save"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
</form>
<a class="btn btn-primary" href="{{ route("user.index") }}">Trở lại</a>
@endsection
