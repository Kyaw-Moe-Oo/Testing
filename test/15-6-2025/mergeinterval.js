function mergeIntervals(intervals) {
  if (!Array.isArray(intervals)) return [];

  intervals.sort((a, b) => a[0] - b[0]);

  const merged = [];

  for (const [start, end] of intervals) {
        const last = merged[merged.length - 1];

        if (!last || last[1] < start) {
            merged.push([start, end]);
        } else {
            last[1] = Math.max(last[1], end);
        }
    }
  return merged;
}

function mergeintervals(intervals) {
  if (!Array.isArray(intervals)) return [];

  intervals.sort((a, b) => a[0] - b[0]);

  const merged = [];

  for (const interval of intervals) {
        if(merged.length == 0 || merged[merged.length-1][1] < interval[0]){
            merged.push(interval);
        }else{
            merged[merged.length-1][1] = Math.max(merged[merged.length-1][1],interval[1]);
        }
        
    }
  return merged;
}

// Example usage
const intervals = [[1, 3],[2, 6], [8, 10], [15, 18]];
const mergedIntervals = mergeIntervals(intervals);
console.log(mergedIntervals); // Output: [[1, 6], [8, 10], [15, 18]]
