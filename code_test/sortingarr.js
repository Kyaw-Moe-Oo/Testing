const myArray = [64, 34, 25, 12, 22, 11, 90, 95];

function findSortingArray(arr) {
    if (arr.length <= 1) {
        return arr;
    }

    const num = arr.length; // 8

    for (let i = 0; i < num - 1; i++) {  // 64 34 25 12 22 11 90 95
        let swapped = false; 

        for (let j = 0; j < num - i - 1; j++) { // 64 34 25 12 22 11 90 95
            if (arr[j] > arr[j + 1]) {
                const temp = arr[j];
                arr[j] = arr[j + 1];
                arr[j + 1] = temp;
                swapped = true;
            }
        }

        if (swapped === false) {
            break;
        }
    }

    return arr;
}

console.log("Original Array:", myArray);

const sortedArray = findSortingArray([...myArray]); // copy array

console.log("Sorted Array (Bubble Sort):", sortedArray);