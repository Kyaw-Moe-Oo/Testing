function productExceptSelf(nums) {
  if (!Array.isArray(nums)) {
    return [];
  }
  const result = Array(nums.length).fill(1); // 1,1,1,1

  let prefix = 1;
  for (let i = 0; i < nums.length; i++) { //0, 1,2
    result[i] = prefix;  // 1, 1 
    prefix *= nums[i];
  }
  let suffix = 1;
  for (let i = nums.length - 1; i >= 0; i--) {
    result[i] *= suffix;
    suffix *= nums[i];      
  }
  return result;
}

const nums = [1, 2, 3, 4]; // for = 2 * 3 * 4

console.log(productExceptSelf(nums));