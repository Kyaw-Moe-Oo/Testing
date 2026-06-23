function lengthOfLongestSubstring(s = "") {
    if (typeof s !== "string") return 0;

    const set = new Set();
    let l = 0;
    let res = 0;

    for (let r = 0; r < s.length; r++) {
        while (set.has(s[r])) {
            set.delete(s[l]);
            l++;
        }

        set.add(s[r]);
        res = Math.max(res, r - l + 1);
    }

    return res;
}

let testStr = "abaaaab";
let result = lengthOfLongestSubstring(testStr);
console.log(result);

function longestSubstring(str = "") {
    if (typeof str !== "string") return 0;
    let set = new Set();
    let left = 0;
    let result = 0;
    for (let right = 0; right < str.length; right++) {
        while (set.has(str[right])) {
            set.delete(str[left]);
            left ++;
        }
        set.add(str[right]);
        result =Math.max(result, right - left + 1);

    }
    return result;
}
let str = "aabbccdd";
let result =longestSubstring(str);
console.log(result);