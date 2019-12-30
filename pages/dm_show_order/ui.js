function order(value) {
    var seat_no = parseInt(value['user']['seat_no']) % 100;
    var highlight = (value['user']['id'] !== value['order_maker']['id']);
    var ret = '<div id="' + value['id'] + '" class="order"><div class="info"><div class="index index_adjust' + (highlight ? " red-highlight " : "") +
        '"><label>' + value['user']['name'] + '(' + seat_no + ')' + '</label></div>';
    var text = (value['dish'].length > 1 ? "自訂套餐(" + value['money']['charge'] + "$.)" : value['dish'][0]['dish_name'] + '(' + value['dish'][0]['dish_cost'] + '$.)');
    return ret + '</div><div class="info"><div class="index dish_name' +
        (highlight ? " red-highlight " : "") + '"><label>' +
        text + '</label></div></div><hr /></div>';
}

function load() {
    var today = moment().format("YYYY/MM/DD");
    var url = "../../../backend/backend.php?cmd=select_class&dirty=true&history=true&esti_start=" + today + "-00:00:00&esti_end=" + today + "-23:59:59";

    $("#loading").css("display" ,"block");
    $.get(url, function (data) {
        var json = $.parseJSON(data);
        for (var key in json) {
            var value = json[key];
            if(value["money"]["payment"][0]["paid"] == "true")
                $("#data_person").append(order(value));
        }
    }).done(function(){
        $("#loading").css("display" ,"none");
    });
}


$(document).ready(function () {
    load();
    $.get("backstage.php" ,(result) => {
        $("#data_category").append(result);
    });
});