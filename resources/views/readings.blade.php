<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ Auth::check() ? 'Bearer '.JWTAuth::fromUser(Auth::user()) : '' }}">
    <title>readings</title>
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrapValidator.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/readings.css')}}">
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
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#leftNav2" class="left-nav-li1 left-nav-li1-active">读书沙龙<span class="caret"></span></a>
                <ul id="leftNav2" class="collapse in">
                    <li><a class="left-nav-li2 left-nav-li2-active">读书沙龙列表</a></li>
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
            <li><a class="left-nav-li1" href="{{ url('admin') }}">管理员列表</a></li>
        </ul>
        <div class="col-md-10 col-md-offset-2 right-arr">
            <div class="col-md-10 col-md-offset-1 wrapper">
                <div class="page-header">
                    <h2>读书沙龙 <small>添加/删除读书沙龙</small></h2>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        读书沙龙列表
                        <button class="btn btn-default" data-toggle="collapse" data-target="#rightForm">添加</button>
                        <form id="rightForm" class="form-horizontal collapse" onsubmit="return false">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="theme">题目*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="theme" name="theme" placeholder="题目">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="speaker">主讲人*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="speaker" name="speaker" placeholder="主讲人">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="place">地点*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="place" name="place" placeholder="地点">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">时间*</label>
                                <div class="col-sm-4 timeInput">
                                    <div class="col-sm-6"><input type="text" class="form-control" id="timeD" name="timeD" placeholder="日期"></div>
                                    <div class="col-sm-6"><input type="text" class="form-control" id="timeH" name="timeH" placeholder="时间"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="desc">简介</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="desc" id="desc" placeholder="简介">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="limitNum">报名人数上限</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="limitNum" name="limitNum" placeholder="报名人数上限，不填为不限制">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default formBtn1" onclick="addReading()">确定</button>
                            <button class="btn btn-default" data-toggle="collapse" data-target="#rightForm">取消</button>
                        </form>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>题目</th>
                            <th>主讲人</th>
                            <th>地点</th>
                            <th>时间</th>
                            <th>简介</th>
                            <th>报名人数上限</th>
                            <th></th>
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
    <script src="{{URL::asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-datepicker.zh-CN.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrapValidator.min.js')}}"></script>
    <script src="{{URL::asset('js/readings.js')}}"></script>
</body>
</html>
