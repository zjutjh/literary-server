$(".mainDiv ul li a").on("click",function () {
    $(".mainDiv ul li").siblings().removeClass("active");
    $(this).parent().addClass("active");
})

$("#timeD").datepicker({
    format: "yyyy-mm-dd",
    language: "zh-CN",
    startDate:new Date()
})

$(document).ready(function() {
    if(sessionStorage['token']==null) {
        alert("请先登录!")
        window.location.href = "login";
    } else {
        token = sessionStorage['token']
    }
    $.ajax({
        url: "api/book-party/list",
        type: "GET",
        beforeSend: function (xmlhttprequest) {
            xmlhttprequest.setRequestHeader("Authorization", "Bearer "+token)
        },
        success: function (result) {
            if (result.code == 0) {
                const data = result.data
                data.forEach(element => {
                    let template =
                        `
                    <td>${element.title}</td>
                    <td>${element.speaker}</td>
                    <td>${element.place}</td>
                    <td>${element.startTime.substr(0, element.startTime.lastIndexOf(":"))}</td>
                    <td>${element.summary}</td>
                    <td>${element.maxUser||'无限制'}</td>
                    <td>
                        <button class="btn btn-default" onclick="toDetail(${element.id})">查看</button>
                        <button class="btn btn-default" onclick="Delete(${element.id})">删除</button>
                    </td>
                    `
                    let child = document.createElement('tr')
                    child.innerHTML = template
                    const render_dom = document.querySelector('tbody')
                    render_dom.appendChild(child)
                })
            } else {
                alert(result.error);
                if(result.code==402||result.code==403)
                    window.location.href = "login";
            }
        }
    });
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
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '请输入数字'
                    }
                }
            }
        }
    });
})

$(".rightNav a").on("click",function(){
    sessionStorage.removeItem('username')
})

function addReading() {
    let theme=$("#theme").val()
    let speaker=$("#speaker").val()
    let place=$("#place").val()
    let timeD=$("#timeD").val()
    let timeH=$("#timeH").val()
    let desc=$("#desc").val()
    let limitNum=$("#limitNum").val()
    // let code=$("#code").val()
    if(theme==""||speaker==""||place==""||timeD==""||timeH=="") {
        alert("有信息未输入！")
        return
    }
    if(limitNum=="") limitNum=0
    let data = {
        "title":theme,
        "speaker":speaker,
        "place":place,
        "startTime":timeD+" "+timeH,
        "summary":desc,
        "maxUser":limitNum
    }
    $.ajax({
        url:"api/book-party/add",
        data: data,
        type: "POST",
        beforeSend: function (xmlhttprequest) {
            xmlhttprequest.setRequestHeader("Authorization", "Bearer "+token)
        },
        success: function(res) {
            if (res.code == 0) {
                alert("添加成功!")
                window.location.reload()
            } else {
                alert(result.error);
                if(result.code==402||result.code==403)
                    window.location.href = "login";
            }
        }
    });
}

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

function toDetail(id) {
    localStorage.detailId = id
    console.log(localStorage.detailId)
    window.location.href = "details"
}

function Delete(id) {
    data = {
        "bookPartyId":id
    }
    $.ajax({
        url: "api/book-party/delete",
        type: "POST",
        data: data,
        beforeSend: function (xmlhttprequest) {
            xmlhttprequest.setRequestHeader("Authorization", "Bearer "+token)
        },
        success: function(result) {
            if (result.code == 0) {
                alert("删除成功!")
            } else {
                alert(result.error);
                if(result.code==402||result.code==403)
                    window.location.href = "login";
            }
        }
    });
    window.location.reload()
}
