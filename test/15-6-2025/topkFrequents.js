function topkFrequent(nums,k){
    let map = new Map();
    for(let n of nums){
        map.set(n,(map.get(n) || 0) + 1);
    }
    return [...map.entries()]
        .sort((a,b) => b[1] - a[1])
        .slice(0,k)
        .map(x=>x[0]);

}
console.log(topkFrequent([4,4,4,4,2,2,3,3],2))