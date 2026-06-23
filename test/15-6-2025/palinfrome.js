function isPalindrome(str){
    if(typeof str !== 'string'){
        throw new error('Input must be a string');}

        str= str.toLowerCase().replace(/[^a-z0-9]/g,"");
        let left=0;
        let right= str.length-1;
        while(left < right){
            if(str[left]!== str[right])return false;
            left++;
            right--;
        } 
        return true;
    }
    const result= isPalindrome('madam');
    console.log('Palindrome is'+ result);   
