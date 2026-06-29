function canAttendMeetings(intervals) {

    if (!Array.isArray(intervals) || intervals.length <= 1) {
        return true;
    }

    const meetings = [...intervals].sort(
        (a, b) => a[0] - b[0]
    );

    for (let i = 1; i < meetings.length; i++) {

        const previousEnd = meetings[i - 1][1];
        const currentStart = meetings[i][0];

        if (currentStart < previousEnd) {
            return false;
        }
    }

    return true;
}
let intervals = [
 [0,30],
 [5,10],
 [15,20]
];
console.log(canAttendMeetings(intervals));