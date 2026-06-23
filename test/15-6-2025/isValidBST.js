function isValidBST(root) {

    function dfs(node, min, max) {

        if (!node) return true;

        if (node.val <= min || node.val >= max) {
            return false;
        }

        return (
            dfs(node.left, min, node.val) &&
            dfs(node.right, node.val, max)
        );
    }

    return dfs(root, -Infinity, Infinity);
}

function isValidBST(root) {
    if (!root || typeof root !== "object") return true;

    function dfs(node, min, max) {
        if (!node) return true;

        if (typeof node.val !== "number") return false;

        if (node.val <= min || node.val >= max) return false;

        return dfs(node.left, min, node.val) &&
               dfs(node.right, node.val, max);
    }

    return dfs(root, -Infinity, Infinity);
}

function isValidBST(root) {
    if (!root || typeof root !== "object") return true;

    function dfs(node, min, max) {
        if (!node) return true;

        if (typeof node.val !== "number") return false;

        if (node.val <= min || node.val >= max) return false;

        return dfs(node.left, min, node.val) &&
               dfs(node.right, node.val, max);
    }

    return dfs(root, -Infinity, Infinity);
}
const root = {
    val: 8,
    left: {
        val: 3,
        left: {
            val: 1,
            left: null,
            right: null
        },
        right: {
            val: 7,
            left: null,
            right: null
        }
    },
    right: {
        val: 10,
        left: {
            val: 7,
            left: null,
            right: null
        },
        right: {
            val: 14,
            left: null,
            right: null
        }
    }
};

console.log(isValidBST(root)); // true


//                  8
//                 / \
//                3   10
//               / \  / \
//              1   7 7  14
//