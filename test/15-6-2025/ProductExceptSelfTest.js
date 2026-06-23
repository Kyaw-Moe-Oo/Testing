class ProductExceptSelfTest{
    execute(nums = []){
        const len = nums.length;
        if(len === 0)
            return [];

        const result = new Array(len).fill(1);//result=[1,1,1,1]

        //for prefix product
        let prefix = 1;
        for (let i = 0; i < len; i++) {//[1,3,]
            result[i] = prefix;//[]
            prefix *= nums[i];//
        }

        //for suffix product
        let suffix = 1;
        for (let i = len-1; i >= 0 ; i--) {
            result[i] *= suffix;
            suffix *= nums[i]; 
        }

        return result;
    }
}
console.log(new ProductExceptSelfTest().execute([1,2,3,4]));