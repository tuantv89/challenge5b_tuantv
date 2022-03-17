<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
</head>
<body>

<div class="wrapper">
    <div class="container">
        <div class="dashboard">
            <div class="left">
                    <span class="left__icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                <div class="left__content">
                    <div class="left__logo">Quản lý sinh viên</div>
                    <div class="left__profile">
                        <div class="left__image">
                            <a href="{{ route("user.detail",["id" => \Illuminate\Support\Facades\Auth::id()]) }}">
                                <img height="160" src="{{ asset("storage/avatars/". \Illuminate\Support\Facades\Auth::user()->avatar ) }}"/></a>
                        </div>
                        <a href="{{ route("user.detail",["id" => \Illuminate\Support\Facades\Auth::id()]) }}"><p class="left__name">{{ \Illuminate\Support\Facades\Auth::user()->username }}</p></a>
                    </div>
                    <ul class="left__menu">
                        <li class="left__menuItem">
                            <div class="left__title"><img src="{{asset('assets/assets/icon-tag.svg')}}" alt="">Challenge<img class="left__iconDown" src="{{asset('assets/assets/arrow-down.svg')}}" alt=""></div>
                            <div class="left__text">
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                <a class="left__link" href="{{ route('challenge.create') }}">Thêm Challenge</a>
                                @endif
                                <a class="left__link" href="{{ route('challenge.index') }}">Xem Challenge</a>
                            </div>
                        </li>
                        <li class="left__menuItem">
                            <div class="left__title"><img src="{{asset('assets/assets/icon-edit.svg')}}" alt="">Bài tập<img class="left__iconDown" src="{{asset('assets/assets/arrow-down.svg')}}" alt=""></div>
                            <div class="left__text">
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                <a class="left__link" href="{{ route('test.create') }}">Thêm bài tập</a>
                                @endif
                                <a class="left__link" href="{{ route('test.index') }}">Xem danh sách</a>
                            </div>
                        </li>
                        <li class="left__menuItem">
                            <div class="left__title"><img src="{{asset('assets/assets/icon-user.svg')}}" alt="">Người dùng<img class="left__iconDown" src="{{asset('assets/assets/arrow-down.svg')}}" alt=""></div>
                            <div class="left__text">
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                <a class="left__link" href="{{ route('user.register') }}">Thêm Người dùng</a>
                                @endif
                                <a class="left__link" href="{{ route('user.index') }}">Xem Người dùng</a>
                            </div>
                        </li>
                        <li class="left__menuItem">
                            <a href="{{ route('user.logout') }}" class="left__title"><img src="{{ asset('assets/assets/icon-logout.svg')}}" alt="">Đăng Xuất</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="right">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
        <div class="right__content">
            <div class="right__table">

                <div> @yield('content') </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

<script src="{{asset('assets/js/main.js')}}"></script>

</body>
</html>
