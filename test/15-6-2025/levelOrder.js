function levelOrder(root) {
  if (!root) return [];
  const q = [root], res = [];

  while (q.length) {
    let size = q.length;
    let level = [];

    for (let i = 0; i < size; i++) {
      let node = q.shift();
      level.push(node.val);
      if (node.left) q.push(node.left);
      if (node.right) q.push(node.right);
    }

    res.push(level);
  }
  return res;
}

function levelOrder(root = null) {
    if (!root || typeof root !== "object") return [];

    const queue = [root];
    const result = [];

    while (queue.length) {
        const size = queue.length;
        const level = [];

        for (let i = 0; i < size; i++) {
            const node = queue.shift();

            level.push(node.val);

            if (node.left) queue.push(node.left);
            if (node.right) queue.push(node.right);
        }

        result.push(level); 
    }

    return result;
}
const root = {
    val: 3,
    left: {
        val: 9,
        left: null,
        right: null
    },
    right: {
        val: 20,
        left: {
            val: 15,
            left: null,
            right: null
        },
        right: {
            val: 7,
            left: null,
            right: null
        }
    }
};

console.log(levelOrder(root));