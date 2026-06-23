class ListNode{
    constructor(value,next=null){
        this.value=value;
        this.next=next;
    }
}
function hasCycle(head){
    if(head == null) return false;
    let slow=head;
    let fast=head;
    while(fast !== null && fast.next !== null){
        slow=slow.next;
        fast=fast.next.next;
        if(slow == fast) return true;
    }
    return false;
}
const n1=new ListNode(1);
const n2=new ListNode(2);
const n3=new ListNode(3);
const n4=new ListNode(4);
n1.next=n2;
n2.next=n3;
n3.next=n4;
n4.next=n2;
const head=n1;
console.log("This is Circle",hasCycle(head));
