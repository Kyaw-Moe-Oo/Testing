const arr = [1,2,3,4,5];
const target = 3;
function binarySearch(arr=[], target){
    if(arr.length <= 0){
        return false;
    }
    let left = 0;
    let right = arr.length-1;
    while(left <= right){
        let mid = Math.ceil((left+right)/2);

        if(arr[mid] === target) return true;
        console.log("Middle value: " , arr[mid]);
        if(arr[mid] < target){
            left = mid + 1;
        }else{
            right = mid - 1;
        }
    }
    return false;
}

const result = binarySearch(arr,target);
console.log(result);