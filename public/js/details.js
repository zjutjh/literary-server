var readingId = localStorage.detailId;
var user_signup,user_checkin

$(".mainDiv ul li a").on("click",function () {
    $(".mainDiv ul li").siblings().removeClass("active");
    $(this).parent().addClass("active");
})

$("#timeD").datepicker({
    format: "yyyy-mm-dd",
    language: "zh-CN",
    startDate:new Date()
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
    if(sessionStorage['token']==null) {
        alert("请先登录!")
        window.location.href = "login";
    } else {
        token = sessionStorage['token']
    }
    data = {
        "bookPartyId":readingId
    }
    $.ajax({
        url: "api/book-party/detail",
        type: "GET",
        data: data,
        beforeSend: function (xmlhttprequest) {
            xmlhttprequest.setRequestHeader("Authorization", "Bearer "+token)
        },
        success: function(result) {
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
                $('#qrcode').qrcode({
                    render: "canvas",
                    width: 200,
                    height: 200,
                    text: data.checkinCode
                });
                // $("#code").val(data.checkinCode)
            } else {
                alert(result.error);
                if(result.code==402||result.code==403)
                    window.location.href = "login";
            }
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
            desc: {
                validators: {
                    notEmpty: {
                        message: '简介不能为空'
                    }
                }
            },
            limitNum: {
                validators: {
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '请输入数字'
                    },
                    notEmpty: {
                        message: '报名人数上限不能为空'
                    }
                }
            }
        }
    });
    let str1="api/book-party/showSignUp/"+readingId
    let str2="api/book-party/showCheckIn/"+readingId
    $.ajax({
        url: str1,
        type: "GET",
        beforeSend: function (xmlhttprequest) {
            xmlhttprequest.setRequestHeader("Authorization", "Bearer "+token)
        },
        success: function(result) {
            if (result.code == 0) {
                user_signup = result.data.user
            } else {
                alert(result.error);
                if(result.code==402||result.code==403)
                    window.location.href = "login";
            }
        }
    });
    $.ajax({
        url: str2,
        type: "GET",
        beforeSend: function (xmlhttprequest) {
            xmlhttprequest.setRequestHeader("Authorization", "Bearer "+token)
        },
        success: function(result) {
            if (result.code == 0) {
                user_checkin = result.data.user
            } else {
                alert(result.error);
                if(result.code==402||result.code==403)
                    window.location.href = "login";
            }
        }
    });
}

var removeAllChildren = function(render_dom) {
    const childs = render_dom.childNodes;
    for(let i = childs.length - 1; i >= 0; i--) {
        render_dom.removeChild(childs[i]);
    }
}

var showUsers = function(x,thisa) {
    $("#tableNavbar ul li").siblings().removeClass("active");
    $(thisa).parent().addClass("active");
    let data
    if(!x) {
        data = user_signup
        let str = "<strong>报名/上限:&nbsp;&nbsp;&nbsp;"+data.length+"/"+$("#limitNum").val()+"</strong>"
        $(".navbar-text").html(str)
    } else {
        data = user_checkin
        let str = "<strong>签到/报名:&nbsp;&nbsp;&nbsp;"+data.length+"/"+user_signup.length+"</strong>"
        $(".navbar-text").html(str)
    }
    const render_dom = document.querySelector('tbody')
    removeAllChildren(render_dom)
    data.forEach(element => {
        const template =
            `
            <td>${element.institute}</td>
            <td>${element.name}</td>
            <td>${element.sid}</td>
            <td>${element.mobile}</td>
            `
        let child = document.createElement('tr')
        child.innerHTML = template
        render_dom.appendChild(child)
    })
    $("#tableNavbar > button").collapse('show')
    $("#tableDiv").collapse('show')
}

$("#confirmBtn").on("click",function() {
    let theme=$("#theme").val()
    let speaker=$("#speaker").val()
    let place=$("#place").val()
    let timeD=$("#timeD").val()
    let timeH=$("#timeH").val()
    let desc=$("#desc").val()
    let limitNum=$("#limitNum").val()
    // let code=$("#code").val()
    if(limitNum=="") limitNum=0
    let data = {
        "bookPartyId":readingId,
        "title":theme,
        "speaker":speaker,
        "place":place,
        "startTime":timeD+" "+timeH,
        "summary":desc,
        "maxUser":limitNum
    }
    $.ajax({
        url: "api/book-party/update",
        type: "POST",
        data: data,
        beforeSend: function (xmlhttprequest) {
            xmlhttprequest.setRequestHeader("Authorization", "Bearer "+token)
        },
        success: function(res) {
            if (res.code == 0) {
                alert("修改成功!")
                window.location.reload()
            } else {
                alert(result.error);
                if(result.code==402||result.code==403)
                    window.location.href = "login";
            }
        }
    });
})

$(".rightNav a").on("click",function(){
    sessionStorage.removeItem('username')
})

$("#tableNavbar > button").click(function () {
    $("#tableDiv").tableExport({
        type:'excel',
        escape:'false',
        ignoreColumn:'[3]'
    });
})
