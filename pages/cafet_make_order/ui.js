$(document).ready(function () {
    $("#loading").css("display" ,"block");
    $.get("backstage.php", function (data) {
        $("#data").append(data);
        update();
        $("img[name='another']").click(function(){
            make_column($(this).attr('dish'));
        });
    }).done(function(){
        $("#loading").css("display" ,"none");  
    });
});


function enter() {
    $('input').off("keypress").on("keypress", function (e) {
        if (e.keyCode == 13) {
            var id = $(this).parent().parent().attr('id').split('_')[1];
            make_column(id);
            return false; // prevent the button click from happening
        }
    });
}


function make_column(id) {
    var element = '<div class="dish_content"><input name="user_' + id +
        '" type="text" placeholder="座號 ex.[11707]"><button name="delete_btn">刪除</button></div>';
    $("#dish_" + id).append(element);
    $("#dish_" + id).parent().parent().collapse('show');
    $("button[name='delete_btn']").off('click').click(function () {
        var id = $(this).parent().parent().attr('id').split('_')[1];
        $(this).parent().remove();
    });
    enter();
}