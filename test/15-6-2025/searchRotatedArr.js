function searchRotated(nums, target) {
    if (!Array.isArray(nums) || nums.length === 0) {
        return null;
    }

    let left = 0;
    let right = nums.length - 1;

    while (left <= right) {
        const mid = Math.floor((left + right) / 2);

        if (nums[mid] === target) {
            return {
                index: mid,
                value: nums[mid]
            };
        }
        // Left side is sorted
        if (nums[left] <= nums[mid]) {
            if (nums[left] <= target && target < nums[mid]) {
                right = mid - 1;
            } else {
                left = mid + 1;
            }
        }
        // Right side is sorted
        else {
            if (nums[mid] < target && target <= nums[right]) {
                left = mid + 1;
            } else {
                right = mid - 1;
            }
        }
    }

    return null;
}

// Example
const nums = [4, 5, 6, 7, 0, 1, 2];
const target = 0;

const result = searchRotated(nums, target);

console.log(result);