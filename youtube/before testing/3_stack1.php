<?php
class Stack{
    public $data = [];
    
    public function push($record){
        array_push($this->data, $record);
    }
    public function pop()  {
        return array_pop($this->data);
    }
    public function peek(){
        // if (count($this->data) > 0) {
        //     return true;
        // }
        // return false;
        return count($this->data) > 0;
    }
}
?>