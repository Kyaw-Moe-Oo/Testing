function reverseList(head) {
    if (!head) return null;

    let prev = null;
    let current = head;

    while (current) {
        const next = current.next;
        current.next = prev;
        prev = current;
        current = next;
    }

    return prev;
}

const head = {
    value: 1,
    next: {
        value: 2,
        next: {
            value: 3,
            next: {
                value: 4,
                next: null
            }
        }
    }
};

console.log(reverseList(head));

function findReversedLinkList(head = {}) {
    if(!head) {
        return null;
    }
    let prev = null;
    let current = head;
    while (current) {
        const next = current.next;
        current.next = prev;
        prev = current;
        current = next;
    }
    return prev;
}
const head = {value: 1, next: {value:2 , next:{value:3 , next:{value:4, next:null}}}};
console.log(findReversedLinkList(head));