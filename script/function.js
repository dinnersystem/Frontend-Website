//every function here is synchornized.

var time = "-12:00:00";
var url = "/dinnersys_beta/backend/backend.php";

function login(uid, pswd, callback, done) {
    var json;
    $.post(url, { cmd: "login", "id": uid, "password": pswd, "device_id": "website" }, (data) => { json = data; }).done(() => { callback(json); done(); });
}

function logout(done) { $.get(url, { "cmd": "logout" }).done(done); }

function make_payment(id, type, pin, callback, target = true) {
    $.post(url, { "cmd": "payment_" + type, "target": target, "order_id": id, "password": pin }, (data) => { callback(data); });
}

function delete_order(oid, type, callback, done) {
    var json;
    var parameter = { "order_id": oid };
    if (type == "self") parameter["cmd"] = "delete_self";
    if (type == "everyone") parameter["cmd"] = "delete_everyone";
    $.post(url, parameter, (data) => { json = data; }).done(() => { callback(json); done(); });
}

function make_order(did, callback) {
    var result;
    var parameter = { "dish_id": [did], "time": moment().format("YYYY/MM/DD") + time, "cmd": "make_self_order" };
    $.post(url, parameter, (data) => { result = data; }).done(() => { callback(result); });
}

function get_card(callback) {
    var result;
    $.post(url, { "cmd": "get_pos" }, function (data) {
        try { result = $.parseJSON(data)["card"]; } catch (e) { result = null; }
    }).done(function () { callback(result); });
}

function get_money(callback) {
    var result;
    $.post(url, { "cmd": "get_pos" }, function (data) {
        try { result = $.parseJSON(data)["money"]; } catch (e) { result = null; }
    }).done(function () { callback(result); });
}
