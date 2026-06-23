function topKFrequent(nums, k) {
    if (!Array.isArray(nums) || k < 1) return [];

    const frequencyMap = new Map();

    for (const num of nums) {
        frequencyMap.set(num, (frequencyMap.get(num) || 0) + 1);
    }

    return [...frequencyMap.entries()]
        .sort((a, b) => b[1] - a[1])
        .slice(0, k)
        .map(([num]) => num);
}
const nums = [1, 1, 1, 2, 2, 3];
const k = 2;

console.log(topKFrequent(nums, k));