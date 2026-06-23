function  IsValid(string = ''){

    const stack = [];
    const map = {
        "]" : "[",
        "}" : "{",
        ")" : "("
    };

    for (ch of string)
    {
        if(ch === '{' || ch === '[' || ch == '('){
            stack.push(ch);
        }else{
            if(stack.pop() !== map[ch])
                return false;
        }
    }
    if(stack.length === 0) return true;
}
const string = "{[()]}";
const result = IsValid(string);
console.log(result ? "Valid" : "Invalid");
