<?php

require_once("info.php");
require_once("dom_element.php");
require_once("sort_function.php");

class tree {
    public $childs = array();
    public $info;
    public $data = array();
    public $configs;
    public $level;
    public $is_leaf = false;
    
    public $child_key;
    public $sort_by;
    public $func;
    
    function __construct($configs ,$level) {
        if($level == count($configs)) {
            $this->is_leaf = true;
            return;
        }
        $this->child_key = $configs[$level]['child_key'];
        $this->func = $configs[$level]['func'];
        $this->configs = $configs;
        $this->level = $level;
    }

    public function add($data) {
        if($this->is_leaf) {
            array_push($this->data ,$data);
            return;
        }
        
        $obj = $data;
        foreach($this->child_key as $key => $value) {
            if($value == "payment") {
                $obj = $obj->money->payment['cafeteria'];
            } else {
                $obj = $obj->$value;
            }
        }
        
        if(gettype($obj) == "boolean")
            $obj = ($obj ? 1 : 0);
        if(!array_key_exists($obj ,$this->childs))
            $this->childs[$obj] = new tree($this->configs ,$this->level + 1);
        $this->childs[$obj]->add($data);
    }

    public function build_info($sort_by = null) {
        if($this->is_leaf) {
            $this->info = new info(null ,$this->data);
        } else {
            foreach($this->childs as $key => $value)
                $value->build_info($sort_by);
            $this->info = new info($this->childs ,null);
            
            if($this->child_key === ['user' ,'class' ,'class_no']) {
                usort($this->childs ,array("sort_function" ,$sort_by));
            } else {
                ksort($this->childs);
            }
        }
    }

    function get_collapsable() {
        if($this->is_leaf) return null;
        return dom_element::collapsable($this->childs ,$this->func);
    }
}



?>