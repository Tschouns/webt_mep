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

    // Map data points, determine dates.
    let dataPoints = data.map(i => ({ date: new Date(i.entry_date), mood: i.mood }));
    dataPoints.sort((a, b) => a.date - b.date);

    let earliestDate = dataPoints[0].date;
    let latestDate = dataPoints[dataPoints.length - 1].date;

    let differenceInDays = getDifferenceInDays(earliestDate, latestDate);

    // Determine step sizes.
    let xPadding = 20;
    let yPadding = 10;

    let xStepSize = (canvas.width - (2 * xPadding)) / differenceInDays;
    let yStepSize = (canvas.height - (2 * yPadding)) / 9;

    // Get graph points.
    let graphPoints = dataPoints.map(i => ({
        x: getDifferenceInDays(earliestDate, i.date) * xStepSize + xPadding,
        y: canvas.height - ((i.mood - 1) * yStepSize) - yPadding
    }));

    // Draw axes.
    drawLine(context, xPadding, canvas.height - yPadding, canvas.width - xPadding, canvas.height - yPadding, "black");
    drawLine(context, xPadding, canvas.height - yPadding, xPadding, yPadding, "black");

    // Draw points:
    for (let i = 0; i < graphPoints.length; i++) {
        drawDot(context, graphPoints[i].x, graphPoints[i].y, 3, "red");
    }
}

function getDifferenceInDays(date1, date2) {
    let difference = date2.getTime() - date1.getTime();
    let differenceInDays = Math.ceil(difference / (1000 * 3600 * 24));

    return differenceInDays;
}

function drawLine(context, aX, aY, bX, bY, color) {
    context.moveTo(aX, aY);
    context.lineTo(bX, bY);
    context.strokeStyle = color;
    context.stroke();
}

function drawDot(context, x, y, size, color) {
    context.beginPath();
    context.arc(x - (size / 2), y - (size / 2), size, 0, 2 * Math.PI);
    context.strokeStyle = color;
    context.stroke();
}
