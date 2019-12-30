<?php

error_reporting(0);

require_once(__DIR__ . '/../../../backend/backend_proc/backend_main.php');
require_once(__DIR__ . "/../../collapsable/tree.php");

date_default_timezone_set('Asia/Taipei');
$time = date("Y/m/d");
$param = ['cmd' => 'select_class' ,
    'esti_start' => $time . '-00:00:00' ,
    'esti_end' => $time . '-23:59:59'];

$obj = new \backend_proc\backend_main($param);
$data = $obj->run();

$categorize = new tree(
    [
        ['child_key' => ['vdish' , 'department' ,'factory' ,'id']   ,'func' => "factory_dom"],
        ['child_key' => ['vdish' ,'id']                             ,'func' => "dish_dom"],
        ['child_key' => ['id']                                      ,'func' => "user_dom"],
    ] ,0
);
if($data == null) die();

foreach($data as $key => $value) 
    if($value->money->payment["payment"]->paid)
        $categorize->add($value);
    
$categorize->build_info();
echo $categorize->get_collapsable();


?> 



<?php

function factory_dom($parent_id ,$content_id ,$content ,$value){
    $title = $value->info->fname . ' x' . $value->info->count . '(' . $value->info->charge_sum .'$.)'; 
    $title_dom = '<h4 class=" panel-title"><a style="width:80%" data-toggle="collapse" data-parent="#' . $parent_id . '" href="#' .
        $content_id . '">' . $title . '</a></h4>';
    return '<div class="panel panel-default"><div class="panel-heading">' . $title_dom . 
        '</div><div id="' . $content_id . '" class="panel-collapse collapse"><div class="panel-body">' . $content .
        '</div></div></div>';
}
function dish_dom($parent_id ,$content_id ,$content ,$value){
    $title = $value->info->dname . ' x' . $value->info->count . '(' . $value->info->charge_sum .'$.)'; 
    $title_dom = '<h4 class=" panel-title"><a style="width:80%" data-toggle="collapse" data-parent="#' . $parent_id . '" href="#' . $content_id . '">' .
        $title . '</a></h4>';
    return '<div class="panel panel-default"><div class="panel-heading">' . $title_dom . 
        '</div><div id="' . $content_id . '" class="panel-collapse collapse"><div class="panel-body">' . $content .
        '</div></div></div>';
}
function user_dom($parent_id ,$content_id ,$content ,$value){
    $title = $value->info->uname . '(' . $value->info->charge_sum . '$.)';
    $title_dom = '<h4 class=" panel-title"><a style="width:80%" data-toggle="collapse" data-parent="#' . $parent_id . '" href="#' . $content_id . '">' .
        $title . '</a></h4>';
    return '<div class="panel panel-default"><div class="panel-heading">' . $title_dom . 
        '</div><div id="' . $content_id . '" class="panel-collapse collapse"><div class="panel-body">' . 
        '<div class="order_id ' . ($value->info->paid['dinnerman'] ? "upload" : "unupload") . '" oid="' . $value->data[0]->id . '"></div></div></div></div>';
}
?>