function searchRotate(nums,target){
    let left = 0;
    let right = nums.length -1;
//  console.log("Num:", nums);
    while(left <= right){
        let mid = Math.floor((left + right)/2);
        // console.log("Mid :" , mid);
        if(nums[mid] === target) return mid;

        if(nums[left] <= nums[mid]){
            if(target >= nums[left] && target < nums[mid])
            {
                right = mid -1;
            }else left = mid + 1;
        }else {
            if(target <= nums[right] && target > nums[mid]){
                left = mid + 1;
            }else right = mid - 1;
        }
    }
    return -1;
}
console.log(searchRotate([4,5,6,7,1,2,3],1));
