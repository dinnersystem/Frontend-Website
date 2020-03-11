function make_order(value) {
    var dname = (value["dish"].length == 1 ? value['dish'][0]['dish_name'] : "自訂套餐");
    var has_paid = (value['money']["payment"][0]['paid'] == "true");
    var highlight = false;

    var lower_bound = value["money"]["payment"][0]["able_dt"];
    var upper_bound = value["money"]["payment"][0]["freeze_dt"];
    var expired = !moment().isBetween(lower_bound, upper_bound);

    return '<div id="' + value['id'] + '"><div class="info"><div class="index index_adjust"><label>付款狀態:</label>' +
        '<img src="../../images/' + (has_paid ? 'paid' : 'unpaid') + '.png"></img></div>' +
        (has_paid || expired ? '' : '<div class="value payment clickable"><label> 確認繳款 </label></div>') +
        (has_paid ? '' : '<div id="delete_' + value["id"] + '" class="value value_adjust clickable"><img src="../../images/cross_symbol.png"></img></div>') +
        '</div><div class="info"><div class="index dish_name ' + (highlight ? " red-highlight " : "") + '"><label>' +
        dname + '(' + value['money']['charge'] + '$.)' + '</label></div></div><hr /></div>';
}

function load() {
    var today = moment().format("YYYY/MM/DD");

    $("#loading").css("display", "block");
    select_order(today + "-00:00:00", today + "-23:59:59", (data) => {
        var json = $.parseJSON(data);
        $("#data").empty();
        for (var key in json) {
            var value = json[key];
            $("#data").append(make_order(value));
        }
        $(".value.clickable").off('click').click(payment);
        $(".value_adjust.clickable").off('click').click(del_order);
        $("#loading").css("display", "none");
    });
    update_money();
}

function update_money() {
    get_money((value) => {
        if (value == null) {
            $("#money").text("- $.");
        } else {
            $("#money").text(value + " $.");
        }
    });
}

$(document).ready(function () {
    load();
});
