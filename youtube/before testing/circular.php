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
                if (!$node->next){
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
        public function getAt($index) {
            if (!$this->head) {
               return false;
            }
            $counter = 0;
            $node = $this->head;
            while ($node) {
               if ($counter === $index) {
                  return $node;
               }
               $counter++;
               $node = $node->next;
            }
            return null;
        }
        public function removeAt($index) {
            if (!$this->head) {
                return false;
            }
            if ($index === 0) {
                $this->head = $this->head->next;
            }
            $previous = $this->getAt($index - 1);
            if (!$previous || !$previous->next) {
                return false;
            }
            $previous->next = $previous->next->next;
            return $this->head;
        }
        public function insertAt($data, $index) {
            if (!$this->head) {
                $this->head = new Node($data);
                return;
            }
            if ($index === 0) {
                $this->head = new Node($data, $this->head);
                return;
            }
            $previous = $this->getAt($index - 1);
            if (!$previous) {
                $previous = $this->getLast();
            }
            if (!$previous) {
                // Could not find a valid previous node, do not insert
                return false;
            }
            $node = new Node($data, $previous->next);
            $previous->next = $node;
            return $this->head;
        }
        public function createCircular($index) {
            $lastNode = $this->getLast();
            // $targetNode = $this->getAt($index);
            // if ($lastNode && $targetNode) {
            if ($lastNode) {
                // $lastNode->next = $targetNode;
                $lastNode->next = $this->getAt($index);
                return $lastNode;
            }
            return false;
        }
    }
    $LinkedList = new LinkList();
    $node = new Node("Hey");
    $LinkedList->head = $node;
    $LinkedList->insertFirst("Huh");
    $LinkedList->insertFirst("Ab");
    $LinkedList->insertFirst("Ab");
    $LinkedList->insertFirst("Ab");
    $LinkedList->insertFirst("Cd");

    function getMidPoint($LinkedList) {
        $slow = $LinkedList->getFirst();
        $fast = $LinkedList->getFirst();
        while ($fast->next && $fast->next->next) {
            $slow = $slow->next;
            $fast = $fast->next->next;
        }
        return $slow;
    }

    function checkCircular($LinkedList) {
        $slow = $LinkedList->getFirst();
        $fast = $LinkedList->getFirst();
        while ($fast->next && $fast->next->next) {
            $slow = $slow->next;
            $fast = $fast->next->next;
            if ($slow === $fast) {
                return true;
            }
        }
        return false;
    }



    // var_dump("linkedList : " , $LinkedList);
    // var_dump("1.Remove first :", $LinkedList->removeFirst());
    // echo "<br>";
    // var_dump("2.Remove last :", $LinkedList->removeLast());
    // var_dump("2.Insert last :", $LinkedList->insertLast("Yes"));
    // echo "<br>";
    var_dump("2.Get last is :", $LinkedList->getLast());
    // var_dump("5.Get node At index is :", $LinkedList->getAt(1));
    // var_dump("6.Remove node At index is :", $LinkedList->removeAt(5));
    // var_dump("7.Insert node At index 1 :", $LinkedList->insertAt("yes", 1));
    // var_dump("8.  Get Mid Point is :", getMidPoint($LinkedList));
    // $LinkedList->createCircular(1);
    // var_dump("9.  Get circular answer is :", checkCircular($LinkedList));

?>