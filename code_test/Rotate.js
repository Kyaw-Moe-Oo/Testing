function findRotateArray(arr) {
    if (arr.length <= 1) {
        return arr;
    }

    const lastElement = arr[arr.length - 1];

    for (let i = arr.length - 1; i > 0; i--) {
        arr[i] = arr[i - 1];
    }

    arr[0] = lastElement;

    return arr;
}

const originalArray = [1, 8, 1, 1, 2, 3, 4];

console.log("Original Array:", originalArray);

findRotateArray(originalArray);
findRotateArray(originalArray);

console.log("Rotated Array:", originalArray);