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
    // // $node1->next = $node2;
    // $node = new Node(10);
    // var_dump($node);
    // die;
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
    }
    $LinkedList = new LinkList();
    $node = new Node("Hey");
    $LinkedList->head = $node;
    // var_dump($LinkedList);
    echo "<br>";
    $LinkedList->insertFirst("Hi");
    var_dump($LinkedList);
    // echo "<br>";
    // var_dump("LinkedList size is ", $LinkedList->size());
    // echo "<br>";
    // var_dump("first node is :", $LinkedList->getFirst());
    // echo "<br>";
    // var_dump("Last node is :", $LinkedList->getLast());
?>