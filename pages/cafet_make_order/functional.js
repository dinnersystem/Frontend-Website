var result;
var data = [];

function submit() {
    $(".dish_content").each(function (index, value) {
        var uid = parseInt($(this).find('input').val());
        var did = $(this).find('input').attr('name').split('_')[1];
        make_order(uid, did, "everyone", function (result) {
            result = $.parseJSON(result)[0];
            make_payment(result["id"], 'everyone', '123', (result) => {});
        });
    });
    $(document).ajaxStop(function () {
        show("成功點餐");
        setTimeout(function () {
            window.history.back();
        }, 1000);
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



function update() {
    var charge_sum = 0;

    $(".dish_content").each(function (index, value) {
        var charge = parseInt($(this).parent().attr('cost'));
        charge_sum += charge;
    });
    $("#chargesum").text("金額總共: " + charge_sum + "$.");

    setTimeout(update, 500);
}