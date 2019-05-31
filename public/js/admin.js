window.onload = function() {
    if(sessionStorage['token']==null) {
        alert("请先登录!")
        window.location.href = "login";
    } else {
        token = sessionStorage['token']
    }
    $.ajax({
        url:"api/admin/show",
        beforeSend: function (xmlhttprequest) {
            xmlhttprequest.setRequestHeader("Authorization", "Bearer"+token)
        },
        success: function(result) {
            if (result.code == 0) {
                const data = result.data.admins
                data.forEach(element => {
                    let template =
                        `
                    <td>${element.name}</td>
                    <td>${element.username}</td>
                    `
                    let child = document.createElement('tr')
                    child.innerHTML = template
                    const render_dom = document.querySelector('tbody')
                    render_dom.appendChild(child)
                })
            } else {
                alert(result.error);
                if(result.code==-402||result.code==-403)
                    window.location.href = "login";
            }
        }
    });
//     $('#rightForm').bootstrapValidator({
// 　　　　 message: 'This value is not valid',
//         feedbackIcons: {
// 　　　　    valid: 'glyphicon glyphicon-ok',
// 　　　　    invalid: 'glyphicon glyphicon-remove',
// 　　　　    validating: 'glyphicon glyphicon-refresh'
// 　　　　 },
//         fields: {
//             name: {
//                 validators: {
//                     regexp: {                        
//                         regexp: /^[\u4E00-\u9FA5]{2,4}$/,                        
//                         message: '姓名由2-4个汉字组成'
//                     },
//                     notEmpty: {
//                         message: '姓名不能为空'
//                     }
//                 }
//             },
//             username: {
//                 validators: {
//                     regexp: {                        
//                         regexp: /^[a-zA-Z0-9_]+$/,                        
//                         message: '用户名由数字字母下划线组成'
//                     },
//                     notEmpty: {
//                         message: '用户名不能为空'
//                     }
//                 }
//             },
//             password: {
//                 validators: {
//                     stringLength: {                        
//                         min: 5,                        
//                         message: '密码长度须大于等于5位'
//                     },
//                     notEmpty: {
//                         message: '密码不能为空'
//                     },
//                     regexp: {
//                         regexp: /^[a-zA-Z0-9]+$/,                        
//                         message: '只能由数字字母组成'
//                     }
//                 }
//             },
//             passwordConf: {
//                 validators: {
//                     identical: { 
//                         field: 'password', 
//                         message: '两次输入密码不一样'
//                     }
//                 }
//             }
//         }
//     });
}

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

$(".mainDiv ul li a").on("click",function () {
    $(".mainDiv ul li").siblings().removeClass("active");
    $(this).parent().addClass("active");
})

$(".rightNav a").on("click",function(){
    sessionStorage.removeItem('username')
})

// function addAdmin() {
//     let name = $("#name").val();
//     let username = $("#username").val();
//     let password = $("#password").val();
//     let passwordConf = $("#passwordConf").val();
//     const data = {
//         "name": name,
//         "username": username,
//         "password": password,
//         "passwordConf": passwordConf
//     }
//     $.post("api/bookParty/add", data,
//         function (res) {
//             const result=JSON.parse(res);
//             if(result.code==0) {

//             } else {
//                 alert(result.error)
//             } 
//         }
//     );
// }