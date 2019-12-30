<?php
function categorize($data)
{
    $obj = new \backend_proc\backend_main(['cmd' => 'show_dish']);
    $dish = $obj->run();
    $department = [];
    $department_name = [];
    foreach($dish as $value)
    {
        if($value->is_idle) continue;
        if(!$value->updatable()) {
            continue;
        }
        $department[$value->department->id][$value->id]['count'] = 0;
        $department[$value->department->id][$value->id]['name'] = $value->name;
        $department[$value->department->id][$value->id]['charge'] = $value->charge;

        $department_name[$value->department->id] = $value->department->name;
    }

    foreach($data as $value)
        $department[$value->vdish->department->id][$value->vdish->id]['count'] += 1;
    
    ksort($department);
    foreach($department as $key => $value)
        ksort($department[$key]);
    
    return ["department" => $department ,"name" => $department_name];
}



function sort_department($data ,$class_no ,$row_height)
{
    $ret = categorize($data);
    
    $result = "";
    foreach($ret["department"] as $id => $dishes) {
        $dp_name = $ret["name"][$id];
        $result .= "<p style=\"text-align:center\">$class_no:$dp_name</p>";

        $height = 10 + (count($dishes) + 1) * $row_height;
        $result .= '<div style="height:' . $height . 'px" class="border department"><table>';
        $result .= '<tr><th align="justify">價格</th><th align="justify">名稱</th><th align="justify">數量</th></tr>';

        foreach($dishes as $k => $v) {
            $name = $v['name'];
            $count = $v['count'];
            if($count == 0) $count = "";
            $charge = $v['charge'];
            $result .= '<tr><th align="justify">' . $charge . '</th><th align="justify">' . $name . '</th><th align="justify">' . $count . '</th></tr>';
        }
        $result .= "</table></div>";
    }
    return $result;
}


?>