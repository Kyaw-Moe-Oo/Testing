<?php

class Node{
    public $data;
    public $next;

    public function __construct($data){
        $this->data = $data;
        $this->next = null;
    }
}
class Linklist{
    private $head;

    public function __construct(){
        $this->head=null;
    }
    
    public function append($data){
        $newNode = new Node($data);
        if($this->head===null){
            $this->head=$newNode;
        }else{
            $current=$this->head;
            
            while($current->next!==null){
                $current=$current->next;
            }
            $current->next=$newNode;
        }
    }
    public function delete($value){
        if($this->head===null){
            echo "List is Empty";
            return;
        }
        if($this->head->data===$value){
            $this->head=$this->head->next;
            return;
        }
        $current=$this->head;
        while($current->next!==null && $current->next->data!==$value){
            $current=$current->next;
        }
        if($current->next===null){
            echo "Value not found in the list";
    }else{
        $current->next=$current->next->next;
    }
    }

    public function display(){
        $current=$this->head;
        while($current!==null){
            echo $current->data."->";
            $current=$current->next;
        }
        echo "NULL";
    }
}

$list=new Linklist();
$list->append(1);
$list->append(2);
$list->append(3);
// $list->delete(100);
// $list->append(30);
$list->display();



?>