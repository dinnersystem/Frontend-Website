function del_order() {
    var oid = $(this).parent().attr('oid');
    delete_order(oid ,'everyone' ,function() {} ,function(){
        load();
    });
}