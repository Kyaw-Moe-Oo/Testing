function twoSum(nums = [], target)
{
 let n = nums.length;
 if(!Array.isArray(nums) || n === 0)
 {
    return null;
 }
 const map = new Map();
  const result = [];

 for(let i = 0; i< n; i++)
 {
    let diff = target - nums[i];
console.log("The different number: ", diff);
    if(map.has(diff))
    {
        result.push([map.get(diff), i]);
    }
    map.set(nums[i], i);
 }
 return result;
}
console.log("The pair of two sum is ", twoSum([2, 1, 5, 3, 4, 8],7));