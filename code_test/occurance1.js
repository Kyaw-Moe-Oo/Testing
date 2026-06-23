function findOccurrences(arr, target) {

    function findFirst(arr, target) {
        let low = 0;
        let high = arr.length - 1;
        let first = -1;

        while (low <= high) {
            let mid = Math.floor((low + high) / 2);

            if (arr[mid] === target) {
                first = mid;
                high = mid - 1; // move left
            } else if (arr[mid] < target) {
                low = mid + 1;
            } else {
                high = mid - 1;
            }
        }

        return first;
    }

    function findLast(arr, target) {
        let low = 0;
        let high = arr.length - 1;
        let last = -1;

        while (low <= high) {
            let mid = Math.floor((low + high) / 2);

            if (arr[mid] === target) {
                last = mid;
                low = mid + 1; // move right
            } else if (arr[mid] < target) {
                low = mid + 1;
            } else {
                high = mid - 1;
            }
        }

        return last;
    }

    const first = findFirst(arr, target);

    if (first === -1) {
        return 0;
    }

    const last = findLast(arr, target);

    return last - first + 1;
}

// Example usage
const arr = [1, 1, 2, 2, 2, 2, 3];
const target = 2;

console.time("searchTime");

const occurrences = findOccurrences(arr, target);

console.timeEnd("searchTime");

console.log("Array:", arr);
console.log("Target:", target);
console.log(`Number of occurrences of ${target}: ${occurrences}`);