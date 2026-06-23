function sortArray(arr = []){
    let n = arr.length;
    if(n === 0) return  arr;

    for(let i = 0 ;i < n-1;i++){
        let swapped = false;
        for(let j=0;j<n-i-1;j++){
            if(arr[j] > arr[j + 1]){
                [arr[j],arr[j +1]] = [arr[j + 1], arr[j]];
                swapped = true;
            }
        }
        if(!swapped){
            break;
        }
    }
    return arr;
}
let arr = [5,4,3,2,1,6];
console.log(sortArray(arr));