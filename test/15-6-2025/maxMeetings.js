function maxMeetings(intervals) {

    if (!Array.isArray(intervals) || intervals.length === 0) {
        return 0;
    }

    const meetings = [...intervals].sort(
        (a, b) => a[1] - b[1]
    );

    let meetingCount = 0;
    let lastMeetingEnd = 0;

    for (const meeting of meetings) {

        const currentStart = meeting[0];
        const currentEnd = meeting[1];

        if (currentStart >= lastMeetingEnd) {

            meetingCount++;
            lastMeetingEnd = currentEnd;

        }
    }

    return meetingCount;
}
let intervals = [
    [1,2],
    [3,4],
    [0,6],
    [5,7],
    [8,9]
];
console.log(maxMeetings(intervals));