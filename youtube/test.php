<?php
class Node{
    public $data;
    public $children;
    public function __construct($data){
        $this->data = $data;
        $this->children = [];
    }
    public function add($data) {
        array_push($this->children, new Node($data));
    }
    public function remove($data){
        $this->children = array_filter($this->children, function($node) use ($data) {
            return $node->data != $data;
        });
    }

}
class Tree{
    public $root;
    public function __construct()
    {
        $this->root = null;
    }
    public function treverseBFS() {
        $arr = [$this->root];
        $resultArray = [];
        while (count($arr)) {
            $node = array_shift($arr);
            array_push($resultArray, $node->data);
            if (count($node->children)) {
                for ($i = 0; $i < count($node->children); $i++) {
                    array_push($arr, $node->children[$i]);
                }
            }
        }
        return $resultArray;
    }
}
$node = new Node(5);
// print_r($node);

$node->add(10);
$node->add(-3);
$node->add(8);

$node->children[0]->add(7);
$node->children[0]->add(6);
$node->children[0]->add(14);
$node->children[2]->add(2);

$tree = new Tree();
$tree->root = $node;

print_r($tree->root->children[0]);
