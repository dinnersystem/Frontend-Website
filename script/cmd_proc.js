var adapt = {
    "-5" : "3" ,
    "-6" : "1" ,
    "-7" : "4" ,
    "-8" : "2" ,
};



$(document).ready(() => {
    var now = Math.floor(Date.now() / 1000);
    if(now - window.localStorage.login_date > 3600 || window.localStorage.user_data == null) {
        window.localStorage.clear();
        window.location.replace('login.html');
    }
    
    var json = JSON.parse(window.localStorage.user_data);
    var id = json['id'];
    window.localStorage.fid = adapt[id]; 

    var opers = [];
    $.each(json['valid_oper'], function(index ,value) {
        opers[value] = true;
    });
    
    var welcome = "";// = "你的身分是：";
    if(opers['select_self']) {
        $("#student").css("display" ,"block");
    }

    if(opers['select_class']) {
        $("#dinnerman").css("display" ,"block");
        //welcome += "代訂";
    }

    if(opers['select_facto']) {
        $("#factory").css("display" ,"block");
        //welcome += "廠商";
    }

    if(opers['select_other']) {
        $("#cafeteria").css("display" ,"block");
        //welcome += "合作社";
    }

    welcome += "<br> 歡迎使用系統，" + json['name'];
    $("#welcome").append(welcome);

    get_card((card) => {
        if(card == null) {
            $("#barcode").remove();
        } else {
            JsBarcode("#barcode", card, {
                width: 1,
                height: 15,
                displayValue: false
            });
        }
    });
});

function logout() {
	$.get( "../backend/backend.php?cmd=logout", function( data ) {
	    window.localStorage.clear();
		window.location = "login.html";
	});
}
