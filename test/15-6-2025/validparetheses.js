function isValid(str = []) {
    if (typeof str !== "string") return false;

    const result = []; // opening bracket 
    const pairs = { ")": "(", "}": "{", "]": "[" }; // closing bracket , ) => (

    for (const ch of str) {
        if (pairs[ch]) {
            if (result.pop() !== pairs[ch]) { 
                return false; 
            }
        } else if (ch === "(" || ch === "[" || ch === "{") {
            result.push(ch); // { , [, 
        }
    }
    return result.length === 0;
}

//example usage
const testStr1 = [[]];
// const testStr2 = "()[]{}";
// const testStr3 = "(]";
// const testStr4 = "([)]";
const testStr5 = "{[]}";    

console.log(isValid(testStr1)); // true
console.log(isValid(testStr5));
