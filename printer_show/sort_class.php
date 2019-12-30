<?php
include(__DIR__ . "/sort_department.php");

function sort_class($data ,$row_height)
{
    $class_data = [];
    foreach($data as $value) 
        $class_data[$value->user->class->class_no][] = $value;

    $left = true;
    $result = "";
    foreach($class_data as $key => $value)
    {
        if($left) $result .= '<div class="page">';
        $result .= '<div class="border cls" style="' . ($left ? 'float:left;' : 'float:right;') . '">';
        $result .= sort_department($value ,$key ,$row_height);
        $result .= '</div>';
        $left = !$left;
        if($left) $result .= '</div><p style="page-break-after: always;">&nbsp;</p><p style="page-break-before: always;">&nbsp;</p>';
    }

    return $result;
}
?>