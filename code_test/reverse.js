function reverseArray(arr) {
    // Edge case: empty array
    if (arr.length === 0) {
        return "Array is empty.";
    }

    const n = arr.length;
    const temp = [];

    for (let i = 0; i < n; i++) {  // n = 6, 
        temp[i] = arr[n - 1 - i];  // 6 - 1 - 0 = 5, so temp[0] = arr[5], temp[1] = arr[4], temp[2] = arr[3], temp[3] = arr[2], temp[4] = arr[1], temp[5] = arr[0]
    }

    return temp;
}

const arr2 = [1, 4, 3, 2, 5];
const result = reverseArray(arr2);

console.log("Using temp array:", result);
// What is the bed case senario for this code? The worst case scenario for this code is when the input array is very large, as it requires O(n) time complexity to reverse the array. Additionally, it uses O(n) space complexity due to the temporary array used to store the reversed elements.