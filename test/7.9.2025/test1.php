<?php

function is_valid(string $s): bool
{
    $stack = [];

    foreach (str_split($s) as $char) {
        if (in_array($char, ['(', '[', '{'])) {
            $stack[] = $char;
        } else {
            if (empty($stack)) return false;

            $top = array_pop($stack);

            // Use ASCII codes to check match
            // ')' - '(' = 1
            // ']' - '[' = 2
            // '}' - '{' = 2
            $diff = ord($char) - ord($top);
            if (!in_array($diff, [1, 2])) return false;
        }
    }

    return empty($stack);
}

// ✅ Test cases
var_dump(is_valid("(){}"));      // true
var_dump(is_valid("()[]{}"));    // true
var_dump(is_valid("(]"));        // false
var_dump(is_valid("([)]"));      // false
var_dump(is_valid("{[]}"));      // true
