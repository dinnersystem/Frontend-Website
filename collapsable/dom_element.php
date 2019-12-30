<?php

class dom_element {
    public static $id = 0;

    static function collapsable($childs ,$func) {
        $id = "collapse" . (self::$id++);
    
        $element = '<div class="panel-group" id="' . $id . '">';
        foreach($childs as $key => $value) {
            $content_id = "collapse" . (self::$id++);
            $content = $value->get_collapsable();
            $element .= $func($id ,$content_id ,$content ,$value);
        }
        $element .= '</div>';
        return $element;
    }
}


?>