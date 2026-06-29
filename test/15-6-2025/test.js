function findMaxMeeting(intervals) {
    if (!Array.isArray(intervals) || intervals.length === 0) return 0;

    const meetings = [...intervals].sort((a, b) => a[1] - b[1]);
    let meetingcount = 0;
    let lastmeetingend = 0;
    for (const meeting of meetings) {
        const currentStart = meeting[0];
        const currentEnd = meeting[1];
        if (currentStart >= lastmeetingend) {
            meetingcount++;
            lastmeetingend = currentEnd;
        }
    }
    return meetingcount;
}
let intervals = [
    [1,2],
    [3,4],
    [0,6],
    [5,7],
    [8,9]
];
console.log(findMaxMeeting(intervals));