function anagram(str1, str2) {
    if (str1.length !== str2.length) {
        return false;
    }

    const count = {};

    // Count characters from str1
    for (const ch1 of str1) {
        count[ch1] = (count[ch1] || 0) + 1;
    } // { s:1, i:1, l:1, e:1, n:1, t:1 }

    // Decrease count using str2
    for (const ch2 of str2) {
        if (!count[ch2] || count[ch2] <= 0) {
            return false;
        }
        count[ch2]--; // { l:0, i:0, s:0, t:0, e:0, n:0 }
    }

    return true;
}

const testStr1 = "silent";
const testStr2 = "listen";

if (anagram(testStr1, testStr2)) {
    console.log("They are Anagram.");
} else {
    console.log("They are not Anagram.");
}