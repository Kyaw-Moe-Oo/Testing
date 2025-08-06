<?php

class TreeNode{
    public $data;
    public $children=[];


    public function __construct($data){
        $this->data=$data;
    }
    public function addChild(TreeNode $child){
        $this->children[]=$child;
    }
} 
function dfs(TreeNode $node) {
    echo $node->data . " ";

    foreach ($node->children as $child) {
        dfs($child); // recursive call
    }
}
function bfs(TreeNode $root) {
    $queue = [$root]; // initialize with root

    while (!empty($queue)) {
        $node = array_shift($queue); // get first node
        echo $node->data . " ";

        foreach ($node->children as $child) {
            $queue[] = $child; // enqueue child nodes
        }
    }
}


function display(TreeNode $node, $level = 0) {
    echo str_repeat("  ", $level) . "- " . $node->data . "\n";
    foreach ($node->children as $child) {
        display($child, $level + 1);//recursive call
    }
}

$root=new TreeNode("CEO");

$headofsale=new TreeNode("headofsale");
$developer=new TreeNode("DeveloperTeam");

// $headofsale->addChild(new TreeNode("Sale1"));

$sale1=new TreeNode("Sale1");
$sale2=new TreeNode("Sale2");
$sale3=new TreeNode("Sale3");
$dev1=new TreeNode("Dev1");
$dev2=new TreeNode("Dev2");

$headofsale->addChild($sale1);
$headofsale->addChild($sale2);

// $sale1->addChild($sale3);

$developer->addChild($dev1);
$developer->addChild($dev2);

$root->addChild($headofsale);
$root->addChild($developer);

// bfs($root);
display($root);
// dfs($root);



?>