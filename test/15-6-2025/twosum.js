function findTwoSum(nums, target) {
    if (!Array.isArray(nums))
    {
        return false;
    }

    let seen = new Map();

    for ( let i=0; i < nums.length; i++) {
        let need = target - nums[i];

        if (seen.has(need)) {
            return [seen.get(need), i];
        }
        seen.set(nums[i], i);
    }
    return null;

}

function findTwoSum(nums, target) {
    if (!Array.isArray(nums)) return null;

    const seen = {};

    for (let i = 0; i < nums.length; i++) {
        const need = target - nums[i];

        if (need in seen) {
            return [need, nums[i]];
        }

        seen[nums[i]] = i;
    }

    return null;
}

console.log(findTwoSum([2, 7, 11, 15], 18));
// Example usage
let nums = [2, 7, 11, 15];
let target = 18;
let result = twoSum(nums, target);
console.log("Two numbers that add up to target:", result);