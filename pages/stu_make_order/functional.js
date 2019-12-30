var result;
var data = [];

function submit() {
    var over_time = (moment().hour() >= 10) && (moment().minute() >= 10);
    var did = $(this).parent().attr('id').split('_')[1];
    var server_respond;
    
    make_order(null, did, "self", function (result) { server_respond = result });
    
    $(document).ajaxStop(function () {
        if (server_respond == "Impossible to make the order." || server_respond == "Off hours") {
            show("時間已過");
        } else if(server_respond == "daily limit exceed") {
            show("達單日訂購上限");
        } else {
            try {
                var respond = JSON.parse(server_respond);
                show("成功點餐");
                setTimeout(function () {
                    window.history.back();
                }, 1000);
            } catch(e) {
                show("點餐失敗");
            }
        }
    });
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
