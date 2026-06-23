function twoSum(nums, target) {
    const map = new Map();

    for (let i = 0; i < nums.length; i++) {
        const diff = target - nums[i];

        if (map.has(diff)) {
            return [map.get(diff), i];
        }

        map.set(nums[i], i);
    }

    return [];
}

// Example usage
const nums = [2, 7, 11, 15];
const target = 9;   
const result = twoSum(nums, target);
console.log("Indices of the two numbers that add up to target:", result);