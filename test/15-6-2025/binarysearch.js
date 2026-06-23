function binarySearch(nums, target) {
    if (!Array.isArray(nums)) return -1;

    let left = 0;
    let right = nums.length - 1;

    while (left <= right) {
        const mid = Math.floor((left + right) / 2);

        if (nums[mid] === target) {
            return mid;
        }

        if (nums[mid] < target) {
            left = mid + 1;
        } else {
            right = mid - 1;
        }
    }

    return -1;
}

const nums = [1, 3, 5, 7, 9, 11];
const target = 7;

console.log(binarySearch(nums, target));