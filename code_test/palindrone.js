function isPalindrome(str) {
    // Remove non-alphanumeric characters
    let cleanStr = str.replace(/[^A-Za-z0-9]/g, '');

    // Convert to lowercase
    cleanStr = cleanStr.toLowerCase();
    
    let left = 0;
    let right = cleanStr.length - 1;

    while (left < right) {
        if (cleanStr[left] !== cleanStr[right]) {
            return false;
        }

        left++;
        right--;
    }

    return true;
}

const testing = "12321";
let testing2 = "Hello";
let testing3 = "rotator";

if (isPalindrome(testing)) {
    console.log("This is Palindrome");
} else {
    console.log("This is not Palindrome");
}

if (isPalindrome(testing2)) {
    console.log("This is Palindrome");
} else {
    console.log("This is not Palindrome");
}

if (isPalindrome(testing3)) {
    console.log("This is Palindrome");
} else {
    console.log("This is not Palindrome");
}   