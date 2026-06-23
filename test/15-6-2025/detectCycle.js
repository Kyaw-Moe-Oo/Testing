function hasCycle(head) {
    if (!head || typeof head !== "object") {
        return false;
    }

    let slow = head;
    let fast = head;

    while (fast && fast.next) {
        slow = slow.next;
        fast = fast.next.next;

        if (slow === fast) {
            return true;
        }
    }

    return false;
}

// Test
const node1 = { value: 1 };
const node2 = { value: 2 };
const node3 = { value: 3 };
const node4 = { value: 4 };

node1.next = node2;
node2.next = node3;
node3.next = node4;
node4.next = null;

console.log(hasCycle(node1)); // false

node4.next = node1;

console.log(hasCycle(node1)); // true