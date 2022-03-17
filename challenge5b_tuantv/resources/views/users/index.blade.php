@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Danh sách Người dùng</div>
@if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
<a href="{{ route('user.register') }}" >
    <button style="width: 100px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</button>
</a>
@endif
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tên tài khoản</th>
        <th>Họ và tên</th>
        <th>Avatar</th>
        <th>Trạng thái</th>
        <th>Hành Động</th>
    </tr>
    @if(!empty($users))
        @foreach($users as $user)
            <tr >
                <td>{{ $user->id }}</td>
                <td><a href="{{ route('user.detail',['id' => $user->id]) }}">{{ $user->username }}</a></td>
                <td>{{ $user->full_name }}</td>
                <td>
                    @if(!empty($user->avatar))
                    <img height="100px" src="{{ asset('storage/avatars/'.$user->avatar) }}"/>
                    @endif
                </td>
                <td>@if ($user->is_active)
                        Hoạt động
                    @else
                        Không hoạt động
                    @endif
                </td>
                <td style="text-align: center">
                    <ul>
                        <li><a title="Chi tiết" href="{{ route('user.detail',['id' => $user->id]) }}"><img class="left__iconDown" src="{{asset('assets/assets/icon-edit.svg')}}" alt="Chi tiết"></a></li>
                        @if( \Illuminate\Support\Facades\Auth::id()==$user->id )
                        <li><a title="Update" href="{{ route('user.update',['id' => $user->id]) }}"><img class="left__iconDown" src="{{asset('assets/assets/refresh.svg')}}" height="35px" alt="Sửa"></a></li>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role_id==1 && $user->role_id!=1 )
                            <li><a title="Update" href="{{ route('user.update',['id' => $user->id]) }}"><img class="left__iconDown" src="{{asset('assets/assets/refresh.svg')}}" height="35px" alt="Sửa"></a></li>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role_id==1 && \Illuminate\Support\Facades\Auth::id()!=$user->id && $user->role_id!=1 )
                        <li>
                        <form method="POST" action="{{ route('user.delete',['id' => $user->id]) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa Người dùng {{ $user->username }}?')">
                            @method('DELETE')
                            @csrf
                            <button type="submit"><img class="left__iconDown" src="{{asset('assets/assets/icon-trash-black.svg')}}" alt="Xóa"></button>
                        </form>
                        </li>
                        @endif
                    </ul>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">Không có bản ghi nào</td>
        </tr>
    @endif
</table>
@endsection
