@extends("layouts.main_login")

@section('title', 'Đăng nhập')

@section('content')
<div style="margin-top: 100px" class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading"><h4>Login</h4></div>
            <div class="panel-body">
                <form method="post" action="{{ route('login') }}" role="form">
                    @csrf
                    @method('POST')
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="E-mail" name="username" type="text" autofocus="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="Remember Me">Remember Me
                            </label>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Login" name="login"></fieldset>
                </form>
                <div>Chưa có tài khoản,
                    <a href="{{ route('user.register') }}">
                        Đăng ký
                    </a></div>
            </div>
        </div>
    </div>
</div>
@endsection

