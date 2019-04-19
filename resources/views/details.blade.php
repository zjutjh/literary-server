<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>details</title>
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrapValidator.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/details.css')}}">
</head>
<body>
    <div class="container mainDiv">
        <ul class="nav nav-pills nav-stacked col-md-2">
            <li><a href="{{url('admin')}}">管理员设置</a></li>
            <li class="active">
                <a href="#" data-toggle="collapse" data-target="#leftNav1">读书沙龙 <span class="caret"></span></a>
                <ul id="leftNav1" class="collapse in">
                    <li><a href="{{url('readings')}}">读书沙龙列表</a></li>
                    <li class="sec-active"><a href="#">读书沙龙内容</a></li>
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
                    <h2>读书沙龙内容 <small>查看/修改读书沙龙内容</small></h2>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <form id="rightForm" class="form-horizontal" onsubmit="return false">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="theme">题目</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="theme" name="theme" placeholder="题目" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="speaker">主讲人</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="speaker" name="speaker" placeholder="主讲人" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="place">地点</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="place"  name="place" placeholder="地点" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="time">时间</label>
                                <div class="col-sm-4 timeInput">
                                    <div class="col-sm-6"><input type="text" class="form-control" id="timeD" placeholder="日期" disabled></div>
                                    <div class="col-sm-6"><input type="text" class="form-control" id="timeH"  name="timeH" placeholder="时间" readonly></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="desc">简介</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="desc" placeholder="简介" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="limitNum">报名人数上限</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="limitNum" name="limitNum" placeholder="报名人数上限" readonly>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-2 control-label" for="code">签到码</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="code" placeholder="签到码" readonly>
                                </div>
                            </div> -->
                            <a class="btn btn-default formBtn1" data-toggle="collapse" data-target="#tableDiv">查看报名人员信息</a>
                            <a class="btn btn-default" id="modifyBtn">修改</a>
                            <button type="submit" class="btn btn-default" id="confirmBtn">确定</button>
                            <a class="btn btn-default" id="cancleBtn">取消</a>
                        </form>
                    </div>
                    <div class="collapse" id="tableDiv">
                        <table class="table table-striped" >
                            <thead>
                                <tr>
                                    <th>学院</th>
                                    <th>姓名</th>
                                    <th>学号</th>
                                    <th>手机号</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--<tr>--}}
                                    {{--<td>danyuange</td>--}}
                                    {{--<td>danyuange</td>--}}
                                    {{--<td>danyuange</td>--}}
                                    {{--<td>danyuange</td>--}}
                                {{--</tr>--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{URL::asset('js/jquery.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-datepicker.zh-CN.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrapValidator.min.js')}}"></script>
    <script src="{{URL::asset('js/details.js')}}"></script>
</body>
</html>