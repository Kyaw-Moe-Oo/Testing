function canFinish(numCourses, prerequisites) {
  const graph = Array.from({ length: numCourses }, () => []);
  // console.log("before graph:", graph);
  const visited = new Array(numCourses).fill(0);
  // console.log("visited", visited);
  for (let [a,b] of prerequisites) {
    graph[b].push(a);
  }
  // console.log("after graph:", graph);

  function dfs(node) {
    if (visited[node] === 1) return false;
    if (visited[node] === 2) return true;

    visited[node] = 1;
    for (let nei of graph[node]) {
      if (!dfs(nei)) return false;
    }
    visited[node] = 2;
    return true;
  }

  for (let i = 0; i < numCourses; i++) {
    if (!dfs(i)) return false;
  }
  return true;
}
numCourses = 2
prerequisites = [[1,0]]
console.log(canFinish(numCourses, prerequisites));