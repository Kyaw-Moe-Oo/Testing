<?php 
//link list style
    class Node{
        public $data;
        public $next;
        public function __construct($data, $next = null){
            $this->data = $data;
            $this->next = $next;

        }
    }
    // $node1 = new Node(100);
    // $node2 = new Node(200);
    // $node1->next = $node2;
    // $node = new Node(10);
    // var_dump($node);
    class LinkList{
        public $head; 
        public function __construct() {  
        $this->head = null;
        }
        public function insertFirst($data){
            $this->head = new Node($data, $this->head);
        }
        public function size(){
            $count = 0;
            $node = $this->head;
            while ($node){
                $count++;
                $node = $node->next;
            }
            return $count;
        }
        public function getFirst() {
            return $this->head;
        }
        public function getLast() {
            if (!$this->head) {
                return false;
            }
            $node = $this->head;
            while ($node) {
                if ($node->next){
                    return $node;
                }
                $node = $node->next;
            }
        }
        //RemoveFirst()
        public function removeFirst(){
            if (!$this->head) {
                return;
            }
            return $this->head=$this->head->next;
        }
        public function removeLast(){
            if (!$this->head) {
                return;
            }
            if (!$this->head->next) {
               
                return $this->head = null;
              
            }
            $previous = $this->head;
            $node = $previous->next;

            while ($node->next) {
                $previous = $node;
                $node = $node->next;
            }
            $previous->next = null;
            return $this->head;        
        }
        public function insertLast($data){
            $last = $this->getLast();
            if ($last) {
                $last->next = new Node($data);
                return $last;
            }else {
                $this->head = new Node($data);
                return $this->head;
            }
        }
    }
    $LinkedList = new LinkList();
    $node = new Node("Hey");
    $LinkedList->head = $node;
    $LinkedList->insertFirst("Hi");
    $LinkedList->insertFirst("Huh");
    // var_dump("1.Remove first :", $LinkedList->removeFirst());
    echo "<br>";
    // var_dump("2.Remove last :", $LinkedList->removeLast());
    var_dump("2.Insert last :", $LinkedList->insertLast("Yes"));
    echo "<br>";
    var_dump("2.Get last is :", $LinkedList->getLast());
?>