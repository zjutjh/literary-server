<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="api-token" content="{{ Auth::check() ? 'Bearer '.JWTAuth::fromUser(Auth::user()) : '' }}">
    <title>admin</title>
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrapValidator.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/admin.css')}}">
</head>
<body>
    <div class="header navbar-fixed-top">
        <h3 class="col-sm-6">书香工大后台管理系统 <small>by Webber</small></h3>
        <ul class="col-sm-6 header-nav">
            <li>
                <a href="javascript:void(0)">消息</a>
            </li>
            <li>
                <a href="{{ url('login') }}">注销</a>
            </li>
        </ul>
    </div>
    <div class="main-arr">
        <ul class="nav nav-pills nav-stacked col-md-2 left-nav">
            <li>
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#leftNav2" class="left-nav-li1">读书沙龙<span class="caret"></span></a>
                <ul id="leftNav2" class="collapse">
                    <li><a href="{{ url('readings') }}" class="left-nav-li2">读书沙龙列表</a></li>
                    <li><a href="{{ url('details') }}" class="left-nav-li2">读书沙龙内容</a></li>
                </ul>
            </li>
    {{--        <li>--}}
    {{--            <a href="javascript:void(0)" data-toggle="collapse" data-target="#leftNav1" class="left-nav-li1">图书信息<span class="caret"></span></a>--}}
    {{--            <ul id="leftNav1" class="collapse">--}}
    {{--                <li><a href="../booklist/booklist.jsp" class="left-nav-li2">图书列表</a></li>--}}
    {{--                <li><a href="../addbook/addbook.jsp" class="left-nav-li2">添加图书</a></li>--}}
    {{--            </ul>--}}
    {{--        </li>--}}
            <li><a class="left-nav-li1 left-nav-li1-active">管理员列表</a></li>
        </ul>
        <div class="col-md-10 col-md-offset-2 right-arr">
            <div class="col-md-10 col-md-offset-1 wrapper">
                <div class="page-header">
                    <h2>管理员查看</h2>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        管理员列表
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>用户名</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="{{URL::asset('js/jquery.js')}}"></script>
<script src="{{URL::asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{URL::asset('js/admin.js')}}"></script>
</body>
</html>
