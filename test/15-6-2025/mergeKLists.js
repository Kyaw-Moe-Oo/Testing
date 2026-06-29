class ListNode {
    constructor(val, next = null) {
        this.val = val;
        this.next = next;
    }
}
function mergeKLists(lists) {
    const values = [];

    for (const head of lists) {
        let curr = head;

        while (curr) {
            values.push(curr.val);
            curr = curr.next;
        }
    }

    values.sort((a, b) => a - b);
    console.log("values.sort result : ", values);
    const dummy = new ListNode(0);
    let tail = dummy;

    for (const value of values) {
        tail.next = new ListNode(value);
        tail = tail.next;
    }

    return dummy.next;
}
const l1 =
    new ListNode(
        1,
        new ListNode(
            4,
            new ListNode(5)
        )
    );

const l2 =
    new ListNode(
        1,
        new ListNode(
            3,
            new ListNode(4)
        )
    );

const l3 =
    new ListNode(
        2,
        new ListNode(6)
    );

const result = mergeKLists([l1, l2, l3]);

let curr = result;

while (curr) {
    console.log("final result : ",curr.val);
    curr = curr.next;
}