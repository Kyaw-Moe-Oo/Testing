function findMaxMin(arr = []) {
    if (arr.length === 0) {
        return {
            max: null,
            min: null
        };
    }

    let maxValue = arr[0]; //7, 2>7, 5>7, 8>7, 10>7, 1<7, 6<7
    let minValue = arr[0]; //7, 2<7, 5<2, 8>2, 10>2, 1<2, 6>1

    for (let i = 1; i < arr.length; i++) {
        if (arr[i] > maxValue) {
            maxValue = arr[i];
        }

        if (arr[i] < minValue) {
            minValue = arr[i];
        }
    }

    return {
        min: minValue,
        max: maxValue
    };
}

const array = [7, 2, 5, 8, 10, 1, 6];
const result = findMaxMin(array);

console.log("Minimum Value:", result.min);
console.log("Maximum Value:", result.max);