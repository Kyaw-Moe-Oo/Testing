function mergedIntervals(nums){
    console.log(nums);
    if (!Array.isArray(nums))
        throw new Error ("number should be array");
    const sortedArray = nums.sort((a,b)=>a[0]-b[0]);
    console.log(sortedArray);
    console.log("*****");
    let merged = [sortedArray[0]];
    for(let i=1; i<sortedArray.length; i++){
        let current = sortedArray[i];
        console.log(current);
          console.log("*****");
        let lastMerged= merged[merged.length-1];
        if(current[0]< lastMerged[1]){
            lastMerged[1]= Math.max(
                current[1],lastMerged[1]
            );
        }else{
            merged.push(current);
        }
    }
    return merged;
}
let nums =[[1,3],[2,5],[4,7],[8,9]];
console.log(mergedIntervals(nums));