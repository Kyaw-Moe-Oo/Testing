class TreeNode{
    constructor(val,left = null, right = null){
        this.val = val;
        this.left = left;
        this.right = right;

    }
}

function lowestCommonAncestor(root,p,q){
    if(!root || root == p || root ==q){
        return root;

    }
    let left = lowestCommonAncestor(root.left,p,q);
    let right = lowestCommonAncestor(root.right,p,q);
    if(left && right){
        return root;

    }
    return left || right;
    

}
const root = new TreeNode(1);
root.left = new TreeNode(2);
root.right = new TreeNode(3);
root.left.left = new TreeNode(4);
root.left.right = new TreeNode(6);
root.right.left = new TreeNode(5);
root.right.right = new TreeNode(7);
let p = root.left.left;
let q = root.left.right;
const result = lowestCommonAncestor(root,p,q);
console.log(result.val);
