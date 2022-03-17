@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Chi tiết Người dùng {{ $user->username }}</div>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $user->id }}</td>
    </tr>
    <tr>
        <th>Tài khoản</th>
        <td>{{ $user->username }}</td>
    </tr>
    <tr>
        <th>Chức vụ</th>
        <td>
            @if($user->role_id==1)
                Giảng viên
            @else
                Sinh viên
            @endif
        </td>
    </tr>
    <tr>
        <th>Người tạo tài khoản</th>
        <td>@if(!empty($owenr)) <a href="{{ route("user.detail",['id' => $owenr->id]) }}">{{ $owenr->username }}</a> @endif </td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $user->email }}</td>
    </tr>
    <tr>
        <th>Số điện thoại</th>
        <td>{{ $user->phone }}</td>
    </tr>
    <tr>
        <th>Avatar</th>
        <td>
            @if(!empty($user->avatar))
            <img src="{{ asset("storage/avatars/".$user->avatar) }}" height="120px"/>
            @endif
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($user->is_active)
                Hoạt động
            @else
                Không hoạt dộng
            @endif
        </td>
    </tr>
    <tr>
        <th>Created_at</th>
        <td>
            {{ $user->created_at }}
        </td>
    </tr>
    <tr>
        <th>Updated_at</th>
        <td>
            {{ $user->updated_at }}
        </td>
    </tr>
</table>
<a style="margin-bottom: 40px" class="btn btn-primary" href="{{ route('user.index') }}">Trở lại</a>
<div class="right__title" >Tin nhắn của Người dùng {{ $user->username }}</div>
<table class="table table-bordered">
    <tr>
        <th>Người nhắn</th>
        <th>Nội dung</th>
        <th>Thời gian</th>
        <th>Thời gian sửa</th>
        <th>Hành động</th>
    </tr>
    @if(!empty($comments))
        @foreach($comments as $comment)
            <tr >
                <td>{{ $comment->username }}</td>
                <td>{{ $comment->content }}</td>
                <td>{{ $comment->created_at }}</td>
                <td>
                    @if($comment->created_at!=$comment->updated_at) {{ $comment->updated_at }} @else {{ $comment->updated_at }} @endif
                </td>
                <td style="text-align: center;">
                    @if(\Illuminate\Support\Facades\Auth::id()==$comment->user_id)
                    <ul>
                        <li><a title="Update" href="{{ route('user.detail',['id' => $user->id,'comment_id'=>$comment->id]) }}"><img class="left__iconDown" src="{{asset('assets/assets/refresh.svg')}}" height="35px" alt="Sửa"></a></li>
                        <li>
                            <form method="POST" action="{{ route('comment.delete',['id' => $comment->id]) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa Comment?')">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="user_id1" value="{{ $user->id }}">
                                <button type="submit"><img class="left__iconDown" src="{{asset('assets/assets/icon-trash-black.svg')}}" alt="Xóa"></button>
                            </form>
                        </li>
                    </ul>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
    <tr>
        <td colspan="5">Không có lời nhắn!</td>
    </tr>
    @endif
</table>
<div class="right__title" ></div>
<form method="post" action="@if(!empty($com->content)){{ route('comment.update',['id'=>$com->id]) }}@else {{ route('comment.create') }}@endif" enctype="multipart/form-data">
    @csrf
    @method("POST")
    <div class="form-group">
        <input type="hidden" name="user_id1" value="{{ $user->id }}">
        <label>Nội dung</label>
        <textarea required name="content"  id="summary" class="form-control">@if(!empty($com->content)){{$com->content}} @endif</textarea>
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Nhắn"/>
</form>
@endsection
