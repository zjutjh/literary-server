$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [ o[this.name] ];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

function login() {
    $.post("api/admin/login", $("form").serializeObject(),
        function (result) {
            const data=result.data;
            if(!result.code) {
                sessionStorage['token'] = data.token
                location.href = 'admin'
            } else alert(result.error)
        }
    );
}