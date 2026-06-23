function minMaxArr(arr = []){
    let len = arr.length;
    if (len === 0) return [];
    let min = arr[0];
    let max = arr[0];

    for (let i = 1; i<len-1; i ++){
        if(min > arr[i]){
            min = arr[i];
        }
        if(max< arr[i]){ 
            max = arr[i];

        }
    }
    return {min,max};
}

console.log('minMaxArr:', minMaxArr([1,2,4,3,6,7,8]));