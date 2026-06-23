function cloneGraph(node = null) {
    if (!node || typeof node !== "object") return null;

    const map = new Map();

    function dfs(curr) {
        if (map.has(curr)) return map.get(curr);

        const copy = {
            val: curr.val,
            neighbors: []
        };

        map.set(curr, copy);

        for (const neighbor of curr.neighbors || []) {
            copy.neighbors.push(dfs(neighbor));
        }

        return copy;
    }

    return dfs(node);
}

// Graph Create
const node1 = { val: 1, neighbors: [] };
const node2 = { val: 2, neighbors: [] };
const node3 = { val: 3, neighbors: [] };
const node4 = { val: 4, neighbors: [] };

// Connect
node1.neighbors = [node2, node4];
node2.neighbors = [node1, node3];
node3.neighbors = [node2, node4];
node4.neighbors = [node1, node3];

// Clone
const cloned = cloneGraph(node2);

console.log(cloned);