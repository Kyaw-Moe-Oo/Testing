function rob(nums) {
    if (!Array.isArray(nums) || nums.length === 0) {
        return 0;
    }

    let prev = 0;
    let curr = 0;

    for (const money of nums) {
        const best = Math.max(curr, prev + money);

        prev = curr;
        curr = best;
    }

    return curr;
}
console.log(rob([10, 1, 1, 10]));
