function drawGraph(canvasId, data) {
    // Get the canvas and context.
    let canvas = document.getElementById(canvasId);
    let context = canvas.getContext("2d");

    // Clear for (re)drawing.
    context.clearRect(0, 0, canvas.width, canvas.height);

    // Check number of entries... need at least 2.
    if (data.length < 2) {
        context.font = "10px Arial";
        context.fillText("Need at least two entries.", 10, 10);
        return;
    }

    // Determine dates and step sizes.
    let dataPoints = data.map(i => ({ date: new Date(i.entry_date), mood: i.mood }));
    dataPoints.sort((a, b) => b.date - a.date);

    let earliestDate = dataPoints[0].date;
    let latestDate = dataPoints[dataPoints.length - 1].date;

    // Draw stuff.
    context.font = "30px Arial";
    context.fillText("Hello World", 10, 50);
    context.fillText(earliestDate, 10, 70);
    context.fillText(latestDate, 10, 90);
}

