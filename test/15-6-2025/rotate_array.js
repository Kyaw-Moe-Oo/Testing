const arr = [1,2,3,4,5,6];

function rotateArray (arr = [], k){

    let n = arr.length;
    if(n <= 1) return arr;

    k = k % n;


    function reverse(left , right){
        while (left < right){
            [arr[left], arr[right]] = [arr[right], arr[left]];
            left++;
            right--;
        }
        
    }
    reverse(0, n - 1);
    reverse(0, k - 1);
    reverse(k, n - 1);

        return arr;


}
console.log(rotateArray(arr, 3));