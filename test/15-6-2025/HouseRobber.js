function rob(nums) {
    if (!Array.isArray(nums) || nums.length === 0) {
        return 0;
    }

    let prev = 0;
    let curr = 0;

    for (const money of nums) { //10,1,1
                                //0,10, 10,1, 10,11
        const best = Math.max(curr, prev + money);  //10,10,11

        prev = curr; // 0,10,10
        curr = best; // 10,10,11
    }

    return curr;
}
console.log(rob([10, 1,1]));
