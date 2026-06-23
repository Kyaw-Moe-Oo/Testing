function frequencyCounter(arr = []){
    if(arr.length == 0){
        return {};
    }
    let freq = {};
    for(let num of arr){
        freq[num] = (freq[num] || 0) + 1;
    }
    return freq;
}

let numbers = [1 , 1 , 2,2,2,2,3,4];
console.log(frequencyCounter(numbers));