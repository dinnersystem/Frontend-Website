<?php

class info {
    public $charge_sum = 0;
    public $count = 0;
    public $time = ["user" => 0, "dinnerman" => 0, "cafeteria" => 0, "factory" => 0];
    public $paid = ["user" => true, "dinnerman" => true, "cafeteria" => true, "factory" => true];
    public $fname = "";
    public $class = "";
    public $uname = "";
    public $dname = "";
    public $dcharge = ""; 
    public $did = "";
    public $department = "";

    function __construct($childs ,$data) {
        if($childs === null && $data === null) return;
        if($childs !== null && $data !== null) throw new \Exception();

        if($childs === null) {
            $arr = [];
            foreach($data as $key => $value) {
                $tmp = new info(null ,null);
                $tmp->setup_item($value);
                $arr[] = $tmp;
            }
            $this->setup_child($arr);
        }
        if($data === null) {
            $arr = [];
            foreach($childs as $key => $value)
                $arr[] = $value->info;
            $this->setup_child($arr);
        }
    }

    function setup_child($childs) {
        foreach($childs as $key => $value) {
            $this->charge_sum += $value->charge_sum;
            $this->count += $value->count;
            foreach($value->paid as $key => $v)
                $this->paid[$key] = ($v && $this->paid[$key]); 
            foreach($value->time as $key => $v)
                $this->time[$key] = max($v ,$this->time[$key]);
            $this->department = ($this->department !== "" && $value->department !== $this->department ? null : $value->department);
            $this->uname = ($this->uname !== "" && $value->uname !== $this->uname ? null : $value->uname);
            $this->fname = ($this->fname !== "" && $value->fname !== $this->fname ? null : $value->fname);
            $this->class = ($this->class !== "" && $value->class !== $this->class ? null : $value->class);
            $this->dname = ($this->dname !== "" && $value->dname !== $this->dname ? null : $value->dname);
            $this->dcharge = ($this->dcharge !== "" && $value->dcharge !== $this->dcharge ? null : $value->dcharge);
            $this->did = ($this->did !== "" && $value->did !== $this->did ? null : $value->did);
        }
    }

    function setup_item($data) {
        $this->count = 1;
        if(get_class($data) === "order\\order") {
            $this->charge_sum = $data->money->charge;
            $this->class = $data->user->class->class_no;
            foreach($data->money->payment as $key => $value) {
                $this->paid[$key] = ($value->paid == 1);
            }
            $this->uname = $data->user->name;
            foreach($data->money->payment as $key => $value) {
                $this->time[$key] = strtotime($value->paid_dt);         # ten minutes a tick
            }
            $this->dname = $data->vdish->name;
            $this->dcharge = $data->vdish->charge;
            $this->did = $data->vdish->id;
            $this->department = $data->vdish->department->name;
            $this->fname =  $data->vdish->department->factory->name;
        }
        if(get_class($data) === "food\\dish") {
            $this->fname = $data->department->factory->name;;
            $this->dname = $data->name;
            $this->did = $data->id;
            $this->dcharge = $data->charge;
        }
    }
}

?>