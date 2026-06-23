const arr = [12, 12, 11, 40, 12, 5, 6, 5, 12, 11]; //Index:  0   1   2   3   4   5   6   7   8   9

function findDuplicatesArray(arr) {
    if (arr.length === 0) {
        return [];
    }
    const rep = [];
    const num = arr.length;

    for (let i = 0; i < num - 1; i++) {         //12
        for (let j = i + 1; j < num; j++) {     //12
            if (arr[i] === arr[j]) {            //12 === 12
                if (!rep.includes(arr[i])) {
                    rep.push(arr[i]);
                }
                break;
            }
        }
    }

    return rep;
}

const duplicates = findDuplicatesArray(arr);

console.log("Original Array:", arr);
console.log("Duplicates Found:", duplicates);