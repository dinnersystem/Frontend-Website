<?php

error_reporting(0);

include(__DIR__ . '/../../../backend/backend_proc/backend_main.php');
require_once(__DIR__ . "/../../collapsable/tree.php");

$obj = new backend_proc\backend_main(['cmd' => 'show_dish']);
$data = $obj->run();

$categorize = new tree(
    [
        ['child_key' => ['department' ,'factory' ,'id']     ,'func' => "factory_dom"],
        ['child_key' => ['psuedo_id']                       ,'func' => "dish_dom"],
    ] ,0
);

$counter = 0;
foreach($data as $key => $value) {
    if($value->is_idle == true) continue;
    if($value->department->factory->allow_custom) continue;
    $value->psuedo_id = $counter++;
    $categorize->add($value);
}
$categorize->build_info();

echo $categorize->get_collapsable();

?> 



<?php

function factory_dom($parent_id ,$content_id ,$content ,$value){
    $title = $value->info->fname; 
    $title_dom = '<h4 class=" panel-title"><a style="width:80%" data-toggle="collapse" data-parent="#' . $parent_id . '" href="#' .
        $content_id . '">' . $title . '</a></h4>';
    return '<div class="panel panel-default"><div class="panel-heading">' . $title_dom . 
        '</div><div id="' . $content_id . '" class="panel-collapse collapse"><div class="panel-body">' . $content .
        '</div></div></div>';
}
function dish_dom($parent_id ,$content_id ,$content ,$value){
    $best_seller = '<br> <label style="font-size: 15px;margin-top: 10px;font-weight: normal;color: black;margin-left: 80px;">人氣餐點！</label>';
    $title = $value->info->dname . '(' . $value->info->dcharge .'$.)' . (reset($value->data)->best_seller ? $best_seller : '');
    $title_dom = '<h4 class=" panel-title"><a style="width:80%" data-toggle="collapse" data-parent="#' . $parent_id . '" href="#' . $content_id . '">' .
        $title . '</a></h4>';
    return '<div class="panel panel-default">' .
        '<div class="panel-heading" style="' . (reset($value->data)->best_seller ? 'color: #FF4444' : '')  . 
        '">' . $title_dom . '</div><div id="' . $content_id . '" class="panel-collapse collapse"><div class="panel-body"><div id="dish_' . 
        $value->info->did .'" cost="' . $value->info->dcharge . '">' .
        '<button class="make_order" style="width:100%">訂購</button></div></div></div></div>';
}
?>