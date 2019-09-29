<!DOCTYPE html>
<html lang="en">
<head >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="api-token" content="{{ Auth::check() ? 'Bearer '.JWTAuth::fromUser(Auth::user()) : '' }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/login.css')}}">
</head>
<body>
    <div class="header">
        <h3>书香工大后台管理系统 <small>by Webber</small></h3>
    </div>
    <div class="form-arr">
        <div class="form-heading">
            <h3>管理员登录</h3>
        </div>
        <form id="form1" class="form-horizontal" onsubmit="return false">
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">
                    <input type="text" class="form-control" name="username" id="username" placeholder="账号">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">
                    <input type="password" class="form-control" name="password" id="password" placeholder="密码">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">
                    <button class="btn btn-primary btn-block" onclick="login()">登录</button>
                </div>
            </div>
        </form>
    </div>
    <script src="{{URL::asset('js/jquery.js')}}"></script>
    <script src="{{URL::asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/login.js')}}"></script>
</body>
</html>
