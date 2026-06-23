class AdjNumber {
  //two pointer
  //left=0, right = nums.length
  //find mid
  //mid == target return;
  //if(num[mid]< target) , left = mid + 1
  //else, right = mid - 1
  execute(nums, target) {
    if (nums.length === 0) return false;

    let result = [];
    nums.sort((a, b) => a - b);

    // console.log(nums);
    const filteredArr = nums.filter((num) => num > target);
    // console.log(filteredArr);
    // console.log(nums);

    for (let i = 0; i < filteredArr.length; i++) {
      if (filteredArr[i] % 2 == 0 && filteredArr[i] == filteredArr[i + 1]) {
        result.push(filteredArr[i]);
      }
    }
    return result;
  }
}

console.log(new AdjNumber().execute([8, 1, 2, 4, 5, 4, 5, 2, 1, 1, 8, 3], 3)); //3
// console.log(new AdjNumber().execute([1, 2, 2, 3, 4, 4, 5, 7, 7,10,10, 12, 12, 16, 16], 10)); //3