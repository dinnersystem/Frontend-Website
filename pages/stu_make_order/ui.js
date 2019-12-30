$(document).ready(function(){
    $("#loading").css("display" ,"block");
    $.get("backstage.php" ,function(data){
        $("#data").append(data);
        $(".make_order").click(submit);
    }).done(function(){
        $("#loading").css("display" ,"none");  
    });
    
    get_money((value) => {
        if(value == null) {
            $("#money").text("- $.");
        } else {
            $("#money").text(value + " $.");
        }
    });

    $.get("")
});
