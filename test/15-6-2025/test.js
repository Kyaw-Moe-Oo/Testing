function findAllAdjacentGreaterThanTarget(nums = [], target) {
    if (!Array.isArray(nums) || nums.length < 2) return [];
    nums.sort((a,b) => a - b);
    const result = [];

    for (let i = 0; i < nums.length - 1; i++) {
        const curr = nums[i];
        const next = nums[i + 1];

        if (
            curr === next &&        // adjacency
            curr > target &&        // greater than target
            curr % 2 === 0          // even
        ) {
            result.push(curr);
            i++; // skip duplicate pair (optimization)
        }
    }

    return result;
}

console.log(findAllAdjacentGreaterThanTarget([8, 1, 2, 4, 5, 4, 5, 2, 1, 1, 8, 3], 3)); //3