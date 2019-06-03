<!DOCTYPE html>
<html lang="en">
<head >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="api-token" content="{{ Auth::check() ? 'Bearer '.JWTAuth::fromUser(Auth::user()) : '' }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
</head>
<body>
    <div class="container">
        <h1 class="form-signin-heading">管理员登录</h1>
        <form id="form1" class="form-horizontal form-signin" onsubmit="return false">
            <div class="form-group">
                <label class="col-sm-1 control-label" for="username">账号</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="username" placeholder="账号">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" for="password">密码</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="password" placeholder="密码">
                </div>
            </div>
            <button class="btn btn-primary btn-block" onclick="login()" style="width:44%;">登录</button>
        </form>
    </div>
    <script src="{{URL::asset('js/jquery.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/login.js')}}"></script>
</body>
</html>