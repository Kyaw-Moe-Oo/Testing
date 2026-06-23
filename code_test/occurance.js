const arr = [1, 2, 2, 2, 3, 4, 7, 8, 2, 8];
const target = 2;

function countFreq(arr, target) {
    let res = 0;

    for (let i = 0; i < arr.length; i++) {
        if (arr[i] === target) {
            res++;
        }
    }

    return res;
}

const occurrenceCount = countFreq(arr, target);

console.log(`Occurrences of ${target} in the array: ${occurrenceCount}`);