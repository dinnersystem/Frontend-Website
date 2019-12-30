<?php
class sort_function {
    static function sort_class($a ,$b) {
        $class_a = ($a->info->class);
        $class_b = ($b->info->class);
        return ($class_a == $class_b ? 0 : 
            ($class_a < $class_b) ? -1 : 1);
    }
}
?>