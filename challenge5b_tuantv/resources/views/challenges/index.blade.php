@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Danh sách Challenge</div>
    <a href="{{ route('challenge.create') }}" >
        <button style="width: 100px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</button>
    </a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tên Challenge</th>
        <th>Gợi ý</th>
        <th>Ngày tạo</th>
        <th>Trả lời</th>
    </tr>
    @if(!empty($challenges))
        @foreach($challenges as $challenge)
            <tr>
                <td>{{ $challenge->id }}</td>
                <td>{{ $challenge->title }}</td>
                <td>{{ $challenge->suggest }}</td>
                <td>{{ $challenge->created_at }}</td>
                <td><a href="{{ route('challenge.answer',['id' => $challenge->id]) }}">Trả lời</a></td>
                @if(\Illuminate\Support\Facades\Auth::id() == $challenge->user_id)
                <td>
                    @if(\Illuminate\Support\Facades\Auth::id() == $challenge->user_id)
                    <form method="POST" action="{{ route('challenge.delete',['id' => $challenge->id]) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa Challenge {{ $challenge->title }}?')">
                        @method('DELETE')
                        @csrf
                        <button type="submit"><img class="left__iconDown" src="{{asset('assets/assets/icon-trash-black.svg')}}" alt="Xóa"></button>
                    </form>
                    @endif
                </td>
                @endif
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="9">Không Có Dữ Liệu</td>
        </tr>
    @endif
</table>
@endsection
