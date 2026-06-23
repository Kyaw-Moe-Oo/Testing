function groupAnagrams(strs) {
    const map = new Map();

    for (const str of strs) {
        const key = str.split('').sort().join('');

        if (!map.has(key)) {
            map.set(key, []);
        }

        map.get(key).push(str);
    }

    return [...map.values()];
}

function groupAnagrams(strs = []) {
    if (!Array.isArray(strs)) return [];

    const map = new Map();

    for (const str of strs) {
        const key = [...str].sort().join("");

        if (!map.has(key)) {
            map.set(key, []);
        }

        map.get(key).push(str);
    }

    return [...map.values()];
}

// Example
console.log(
    groupAnagrams(["eat", "tea", "tan", "ate", "nat", "bat"])
);