<?php



// Balanced Parentheses Checker
// Difficulty: Easy to Medium
// Topic: Stack

// Problem Statement

// Given a string containing just the characters '(', ')', '{', '}', '[', and ']', write a function that determines if the input string is valid.

// A string is considered valid if:

// Open brackets must be closed by the same type of brackets.
// Open brackets must be closed in the correct order.


// is_valid_brackets("()")            # True
// is_valid_brackets("()[]{}")        # True
// is_valid_brackets("(]")            # False
// is_valid_brackets("([)]")          # False
// is_valid_brackets("{[]}")          # True



function is_valid_brackets(string $s): bool
{
    $stack = [];
    $map = [
        ')' => '(',
        ']' => '[',
        '}' => '{'
    ];

    // Iterate through each character
    for ($i = 0; $i < strlen($s); $i++) {
        $char = $s[$i];

        if (in_array($char, ['(', '[', '{'])) {
            // Push opening brackets to stack
            array_push($stack, $char);
        } else {
            // If stack is empty or top doesn't match expected, return false
            if (empty($stack) || array_pop($stack) !== $map[$char]) {
                return false;
            }
        }
    }

    // If stack is empty, all brackets matched correctly
    return empty($stack);
}

// Test cases
$tests = [
    "()"        => true,
    "()[]{}"    => true,
    "(]"        => false,
    "([)]"      => false,
    "{[]}"      => true
];

foreach ($tests as $input => $expected) {
    $result = is_valid_brackets($input);
    echo "is_valid_brack-++
    
    ets(\"$input\") => " . ($result ? 'true' : 'false') . " (Expected: " . ($expected ? 'true' : 'false') . ")\n";
}
 