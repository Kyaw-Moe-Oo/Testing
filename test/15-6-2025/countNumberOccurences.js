function findOccurences(arr, target){
  function findFirst(){
    let low= 0;
    let high = arr.length-1;
    let first = -1;
    while (low <= high){
        const mid = Math.floor((low+high )/2);
        if(arr[mid ]=== target){
            first = mid;
            high = mid -1;

        }else if(arr[mid] < target){
            low = mid +1;
        }else {
            high = mid -1;
        }

    }
    return first;
  }

  function findLast(){
    let low = 0;
    let high = arr.length-1;
    let last = -1;
    while (low <= high){
        const mid = Math.floor((low+high) /2);
        if(arr[mid] === target){
            last = mid;
            low = mid +1;
        }else if(arr[mid] < target){
            low = mid+1;
        }else{
            high = mid -1;
        }
    }
    return last;
  }

  const first = findFirst();
  if(first === -1){
    return 0;
  }

  const last= findLast();
  return last - first +1;
}

const arr = [1,1,2,2,2,2,3];
const target = 2;

console.time('Search time');
const occurences = findOccurences(arr, target);
console.timeEnd('Search time');
console.log(occurences);