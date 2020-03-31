$(document).ready(() => {
    show_org((data) => {
        var json = $.parseJSON(data);
        for (var key in json) {
            var value = json[key];
            $("#org").append('<li><a onclick="change_org(' + value["id"] + ',\'' + value["name"] + '\');">' + value["name"] + '</a></li>');
        }
    });
});

var org_id = 1;
function change_org(id, name) { org_id = id; $("#org_name").text(name); }

$(document).on('keypress', function (e) {
    if (e.which == 13) {
        normal_login();
    }
});

function normal_login() {
    var uid = $("#id").val();
    var pswd = $("#password").val();

    login(uid, pswd, org_id, (result) => {
        try {
            if ($.parseJSON(result) == null) {
                throw new Exception();
            } else if (result == "Wrong password.") {
                show("帳號或密碼不對");
            } else if (result == "Punish not over") {
                show("重試次數過多");
            } else {
                window.localStorage.user_data = result;
                window.localStorage.user_id = uid;
                window.localStorage.login_date = Math.floor(Date.now() / 1000);
                window.location = 'index.html';
            }
        } catch (e) {
            show("登入失敗");
        }

    }, function () { });
}


function show(msg) {
    $("#error_msg").text(msg);
    $("#error_msg").removeClass("animated bounceIn").parent().css("display", "block");
    setTimeout(function () {
        $("#error_msg").addClass("animated bounceIn");
    }, 30);

    setTimeout(function () {
        $("#error_msg").parent().css("display", "none");
    }, 1000);
}
