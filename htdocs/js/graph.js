function drawGraph(canvasId, data) {
    alert(data[0]["entry_date"]);

    // Get the canvas and context.
    var canvas = document.getElementById(canvasId);
    var context = canvas.getContext("2d");

    // Clear for (re)drawing.
    context.clearRect(0, 0, canvas.width, canvas.height);

    // Draw stuff.
    context.font = "30px Arial";
    context.fillText("Hello World", 10, 50);
}

