<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>admin</title>
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrapValidator.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/admin.css')}}">
</head>
<body>
<div class="container mainDiv">
    <ul class="nav nav-pills nav-stacked col-md-2">
        <li class="active"><a href="#">管理员设置</a></li>
        <li>
            <a href="{{ url('readings') }}" data-toggle="collapse" data-target="#leftNav1">读书沙龙 <span class="caret"></span></a>
            <ul id="leftNav1" class="collapse">
                <li><a href="{{ url('readings') }}">读书沙龙列表</a></li>
                <li><a href="{{ url('details') }}">读书沙龙内容</a></li>
            </ul>
        </li>
        <li><a href="#">more</a></li>
    </ul>
    <div class="col-md-10 rightIndex">
        <div class="navbar navbar-default">
            <ul class="nav navbar-nav rightNav">
                <li>
                    <a href="{{ url('login') }}">注销</a>
                </li>
            </ul>
        </div>
        <div class="container wrapper bgcWhite">
            <div class="page-header">
                <h2>管理员设置</h2>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    管理员列表
                    <!-- <button class="btn btn-default" id="addBtn" data-toggle="collapse" data-target="#rightForm">添加</button>
                    <form id="rightForm" class="form-horizontal collapse" onsubmit="return false">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">姓名</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="name" name="name" placeholder="姓名由2-4个汉字组成">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="username">用户名</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="username" name="username" placeholder="用户名由数字字母下划线组成">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="password">密码</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="password" name="password" placeholder="密码长度须大于等于5位，只能由数字字母组成">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="passwordConf">确认密码</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="passwordConf" name="passwordConf" placeholder="确认密码">
                            </div>
                        </div>
                        <button onclick="addAdmin()" class="btn btn-default formBtn1">确定</button>
                        <button class="btn btn-default" data-toggle="collapse" data-target="#rightForm">取消</button>
                    </form> -->
                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>用户名</th>
                    </tr>
                    </thead>
                    <tbody>
                        {{--<tr>--}}
                            {{--<td>danyuange</td>--}}
                            {{--<td>danyuange</td>--}}
                        {{--</tr>--}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::asset('js/jquery.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{URL::asset('js/admin.js')}}"></script>
</body>
</html>