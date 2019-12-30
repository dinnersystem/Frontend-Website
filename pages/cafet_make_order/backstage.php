<?php

error_reporting(0);

include(__DIR__ . '/../../../backend/backend_proc/backend_main.php');
require_once(__DIR__ . "/../../collapsable/tree.php");

$obj = new \backend_proc\backend_main(['cmd' => 'show_dish']);
$data = $obj->run();

$categorize = new tree(
    [
        ['child_key' => ['department' ,'factory' ,'id']     ,'func' => "factory_dom"],
        ['child_key' => ['id']                              ,'func' => "dish_dom"],
    ] ,0
);
foreach($data as $key => $value) {
    if($value->is_idle == true) continue;
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
    $title = $value->info->dname . '(' . $value->info->dcharge .'$.)';
    $title_dom = '<h4 class=" panel-title"><a style="width:80%" data-toggle="collapse" data-parent="#' . $parent_id . '" href="#' . $content_id . '">' .
        $title . '</a>' . '<img src="../../images/another.png" class="side_btn" name="another" dish="' . $value->info->did . '"></img></h4>';
    return '<div class="panel panel-default"><div class="panel-heading">' . $title_dom . 
        '</div><div id="' . $content_id . '" class="panel-collapse collapse"><div class="panel-body"><div id="dish_' . 
        $value->info->did .'" cost="' . $value->info->dcharge . '">' .
        '</div></div></div></div>';
}
?>