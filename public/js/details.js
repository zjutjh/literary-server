var readingId = localStorage.detailId;

$(".mainDiv ul li a").on("click",function () {
    $(".mainDiv ul li").siblings().removeClass("active");
    $(this).parent().addClass("active");
})

$("#timeD").datepicker({
    format: "yyyy-mm-dd",
    language: "zh-CN"
})

$("#modifyBtn").on("click",function(){
    $(".form-group div input").removeAttr("readonly");
    $("#timeD").removeAttr("disabled");
    $("#confirmBtn").show();
    $("#cancleBtn").show();
    $(this).hide();
})

$("#cancleBtn").on("click",function(){
    window.location.reload()
})

$(document).ready(function(){
    $("#confirmBtn").hide();
    $("#cancleBtn").hide();
})

$(".rightNav a").on("click",function(){
    localStorage.removeItem("username")
})

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

window.onload = function() {
    if(sessionStorage['username']==null) {
        alert("请先登录!")
        window.location.href = "login";
    }
    $.get("api/bookParty/select/"+readingId,function(result) {
        const data = result.data
        if(result.code==0) {
            $("#theme").val(data.title);
            $("#speaker").val(data.speaker);
            $("#place").val(data.place);
            $("#timeD").val(data.startTime.substr(0,data.startTime.indexOf(" ")));
            let time=data.startTime.substr(data.startTime.indexOf(" ")+1);
            $("#timeH").val(time.substr(0,time.lastIndexOf(":")));
            $("#desc").val(data.summary);
            $("#limitNum").val(data.maxUser);
            $("#code").val(data.checkinCode)
        }
    })
    $('#rightForm').bootstrapValidator({
　　　　 message: 'This value is not valid',
        feedbackIcons: {
　　　　    valid: 'glyphicon glyphicon-ok',
　　　　    invalid: 'glyphicon glyphicon-remove',
　　　　    validating: 'glyphicon glyphicon-refresh'
　　　　 },
        fields: {
            theme: {
                validators: {
                    notEmpty: {
                        message: '题目不能为空'
                    }
                }
            },
            speaker: {
                validators: {
                    notEmpty: {
                        message: '主讲人不能为空'
                    }
                }
            },
            place: {
                validators: {
                    notEmpty: {
                        message: '地点不能为空'
                    }
                }
            },
            timeH: {
                validators: {
                    notEmpty: {
                        message: '时间不能为空'
                    }
                }
            },
            limitNum: {
                validators: {
                    notEmpty: {
                        message: '报名人数上限不能为空'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,                        
                        message: '请输入数字'
                    }
                }
            }
        }
    });

}

$(".formBtn1").on("click",function(){
    let str="api/bookParty/showSignUp/"+readingId
    $.get(str,
        function (result) {
            const data = result.data.user
            console.log(data)
            if(result.code==0) {
                data.forEach(element => {
                    let template = 
                    `
                    <td>${element.institute}</td>
                    <td>${element.name}</td>
                    <td>${element.uid}</td>
                    <td>${element.mobile}</td>
                    `
                    let child = document.createElement('tr')
                    child.innerHTML = template
                    const render_dom = document.querySelector('tbody')
                    render_dom.appendChild(child)
                })
            } else alert(result.error)
        }
    );
})

$("#confirmBtn").on("click",function() {
    let theme=$("#theme").val()
    let speaker=$("#speaker").val()
    let place=$("#place").val()
    let timeD=$("#timeD").val()
    let timeH=$("#timeH").val()
    let desc=$("#desc").val()
    let limitNum=$("#limitNum").val()
    let code=$("#code").val()
    if(theme==""||speaker==""||place==""||timeD==""||timeH==""||code=="") {
        alert("有信息未输入！")
        return
    }
    let data = {
        "id":readingId,
        "title":theme,
        "speaker":speaker,
        "place":place,
        "startTime":timeD+" "+timeH,
        "summary":desc,
        "maxUser":limitNum,
        "checkinCode":code
    }
    $.post("api/bookParty/update", data,
        function (res) {
            if(res.code==0) {
                alert("修改成功!")
            } else alert(res.error)
        }
    );
})

$(".rightNav a").on("click",function(){
    sessionStorage.removeItem('username')
})