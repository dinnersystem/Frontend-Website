//every function here is synchornized.

var time = "-12:00:00";
var url = "/dinnersys_beta/backend/backend.php?";

function login(uid, pswd, callback, done) {
    var json;

    $.get(url + "cmd=login&id=" + uid + "&password=" + pswd + "&device_id=website", function (data) {
        json = data;
    }).done(function () {
        callback(json);
        done();
    });
}

function logout(done) {
    $.get(url + "cmd=logout", function (data) {

    }).done(function () {
        done();
    });
}


function make_payment(id, type, pin, callback, target = true) {
    $.get(url + "cmd=payment_" + type + "&target=" + target + "&order_id=" + id + "&password=" + pin, function (data) {
        callback(data);
    });
}




function delete_order(oid, type, callback, done) {
    var json;
    var local_url = url;
    switch (type) {
        case "self":
            local_url += "cmd=delete_self";
            break;
        case "class":
            local_url += "cmd=delete_dm";
            break;
        case "everyone":
            local_url += "cmd=delete_everyone";
            break;
    }

    $.get(local_url + "&order_id=" + oid, function (data) {
        json = data;
    }).done(function () {
        callback(json);
        done();
    });
}


function make_order(login_id, did, type, callback) {
    var result;
    var esti_recv = moment().format("YYYY/MM/DD") + time;
    switch (type) {
        case "self":
            url += "cmd=make_self_order";
            break;
        case "class":
            url += "cmd=make_class_order&target_id=" + login_id;
            break;
        case "everyone":
            url += "cmd=make_everyone_order&target_id=" + login_id;
            break;
    }

    $.get(url + "&dish_id[]=" + did + "&time=" + esti_recv, function (data) {
        result = data;
    }).done(function () {
        callback(result);
    });
}

function get_card(callback) {
    var result;
    $.get(url + "cmd=get_pos", function (data) {
        try {
            result = $.parseJSON(data)["card"];
        } catch (e) {
            result = null;
        }
    }).done(function () {
        callback(result);
    });
}

function get_money(callback) {
    var result;
    $.get(url + "cmd=get_pos", function (data) {
        try {
            result = $.parseJSON(data)["money"];
        } catch (e) {
            result = null;
        }
    }).done(function () {
        callback(result);
    });
}
