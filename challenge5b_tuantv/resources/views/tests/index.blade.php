@extends('layouts.main')

@section('title',"Đăng ký")

@section('content')
<div class="right__title" >Danh sách Bài tập</div>
@if( \Illuminate\Support\Facades\Auth::id()==1 )
    <a href="{{ route('test.create') }}" >
        <button style="width: 100px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</button>
    </a>
@endif
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tên bài tập</th>
        <th>Người đăng</th>
        <th>Download</th>
        <th>Trạng thái</th>
        <th>Ngày đăng</th>
        <th>Hành Động</th>
    </tr>
    @if(!empty($tests))
        @foreach($tests as $test)
          <tr>
              <td>{{ $test->id }}</td>
              <td><a href="{{ route('test.detail',['id'=>$test->id]) }}">{{ $test->name_test }}</a></td>
              <td>{{ $test->username }}</td>
              <td>
                  <a href="{{route('test.download',['id'=>$test->id])}}">Download</a>
              </td>
              <td>{{ $test->created_at }}</td>
              <td>@if($test->created_at!=$test->updated_at) {{ $test->updated_at }} @endif</td>
              <td>
                  <ul>
                      <li><a title="Chi tiết" href="{{ route('test.detail',['id'=> $test->id]) }}"><img class="left__iconDown" src="{{asset('assets/assets/icon-edit.svg')}}" alt="Chi tiết"></a></li>
                      @if( \Illuminate\Support\Facades\Auth::id()==1 )
                          <li>
                              <form method="POST" action="{{ route('test.delete',['id' => $test->id]) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa Bài tập {{ $test->name_test }}?')">
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

