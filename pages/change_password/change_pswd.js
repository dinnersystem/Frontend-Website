function change_pswd() {
    var old_pswd = $("#old").val();
    var new_pswd = $("#new").val();
    $.get("../../../backend/backend.php?cmd=change_password&old_pswd=" + old_pswd + "&new_pswd=" + new_pswd, function (data) {
        if (data.charCodeAt(0) === 0xFEFF) data = data.substr(1);
        try {
            if ($.parseJSON(data) == null) {
                throw new Exception("Invalid");
            }
            $("#error_msg").text("更改成功");
            setTimeout(function () {
                window.history.back();
            }, 1000);
        }
        catch (e) {
            if (data == "Wrong password.") {
                $("#error_msg").text("舊密碼不對");
            } else if (data == "password too short.") {
                $("#error_msg").text("密碼太短");
            } else {
                $("#error_msg").text("密碼格式錯誤");
            }
        };


        $("#error_msg").removeClass("animated bounceIn")
        setTimeout(function () {
            $("#error_msg").addClass("animated bounceIn");
        }, 30);
    });
}

$(document).ready(function () {
    $("#new_account").click(change_pswd);
});