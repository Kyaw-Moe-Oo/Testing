function numIslands(grid) {
  let count = 0;

  function dfs(i,j){
    if (i<0||j<0||i>=grid.length||j>=grid[0].length||grid[i][j]==="0") return;
    grid[i][j] = "0";
    dfs(i+1,j); dfs(i-1,j); dfs(i,j+1); dfs(i,j-1);
  }

  for (let i=0;i<grid.length;i++){
    for (let j=0;j<grid[0].length;j++){
      if (grid[i][j]==="1"){
        count++;
        dfs(i,j);
      }
    }
  }
  return count;
}

function numIslands(grid = []) {
    if (!Array.isArray(grid) || !grid.length) return 0;

    const rows = grid.length;
    const cols = grid[0].length;
    let count = 0;

    function dfs(i, j) {
        if (
            i < 0 || j < 0 ||
            i >= rows || j >= cols ||
            grid[i][j] !== "1"
        ) return;

        grid[i][j] = "0";

        dfs(i + 1, j);
        dfs(i - 1, j);
        dfs(i, j + 1);
        dfs(i, j - 1);
    }

    for (let i = 0; i < rows; i++) {
        for (let j = 0; j < cols; j++) {
            if (grid[i][j] === "1") {
                count++;
                dfs(i, j);
            }
        }
    }

    return count;
}
const grid1 = [
  ["1","1","0","0","1"],
  ["1","1","0","0","0"],
  ["0","0","1","0","0"],
  ["1","0","0","1","1"]
];

console.log(numIslands(grid1));