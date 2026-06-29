function findKthLargest(nums, k) {

    if (!Array.isArray(nums)) {
        return null;
    }

    if (k < 1 || k > nums.length) {
        return null;
    }

    const sorted = [...nums].sort((a, b) => b - a);

    return sorted[k - 1];
}

let nums = [3,2,1,5,6,4];
let k = 2;
console.log(findKthLargest(nums, k));