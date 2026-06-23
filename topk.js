function topk(nums = [] , target)
{
    const freq = new Map();

    for(let i = 0; i < nums.length; i++)
    {
        const num = nums[i];
        // console.log(num);

       freq.set(num, (freq.get(num) || 0 ) + 1);
        // else freq.set(num[i], );
    }

    // console.log(freq);

    const arr = [];
    //[1,2,3]
    for(const item of freq)
    {
        arr.push(item);
    }

    // arr.sort((a,b) => b[1] - a[1]);
    console.log(arr);

    let result = [];
    for(let i = 0; i < target; i++)
    {
        result.push(arr[i][0]);

        // console.log(result);
    }
    return result;
}
const nums = [1,1,1,2,2,3,3,3,4], target = 3;
const result = topk(nums, target);
console.log(result);