<?php

function validateDate($date_string) {
    $format = 'Y-m-d';
    $d = DateTime::createFromFormat($format, $date_string);

    return $d && $d->format($format) === $date_string;
}

function validateParameters() {
    if (!array_key_exists("entry_date", $_POST) || !validateDate($_POST["entry_date"])) {
        echo "<p>The parameter 'entry_date' is missing, or not a valid date.</p>";
        return false;
    }

    if (!array_key_exists("mood_slider", $_POST) ||
        !is_numeric($_POST["mood_slider"]) ||
        (intval($_POST["mood_slider"])) < 1 ||
        (intval($_POST["mood_slider"])) > 10) {
       echo "<p>The parameter 'mood_slider' is missing, or not a valid number between 1 and 10.</p>";
       return false;
    }

    if (!array_key_exists("entry_text", $_POST) || strlen($_POST["entry_text"]) == 0) {
        echo "<p>The parameter 'entry_text' is missing, or empty.</p>";
        return false;
    }

    return true;
}

function insertEntry($conn) {
    $entry_date = DateTime::createFromFormat("Y-m-d", $_POST["entry_date"]);
    $entry_date_sql = $entry_date->format("Y-m-d");
    $mood = $_POST["mood_slider"];
    $text = $_POST["entry_text"];

    $query = "INSERT INTO entries (entry_date, mood, text) VALUES ('$entry_date_sql', ?, ?)";
    $statement = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($statement, "is", $mood, $text);

    // Execute INSERT.
    $result = mysqli_stmt_execute($statement);

    if (!$result) {
        echo "<p>Die INSERT-Operation ist fehlgeschlagen: " . mysqli_error($conn) . "</p>";
    }
}

function displayEntries($conn) {
    $query = "SELECT id, entry_date, mood, text FROM entries ORDER BY entry_date, id";

    // Execute query.
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<p>Das SELECT-Query ist fehlgeschlagen: " . mysqli_error($conn) . "</p>";
        return;
    }

    if (mysqli_num_rows($result) == 0) {
        echo "<p>Es sind noch keine Einträge vorhanden.</p>";
        return;
    }

    $table_rows_html = "";
    $mood_data_json = "";

    $row_number = 0;
    while($row = mysqli_fetch_array($result)){
        $entry_date = $row['entry_date'];
        $mood = $row['mood'];
        $text = htmlspecialchars($row['text']);

        // Prepare an HTML table row.
        $row_class = "row_type_" . ($row_number % 2);

        $table_rows_html .= "<tr class=\"$row_class\">";
        $table_rows_html .= "<td class=\"date_column\">$entry_date</td>";
        $table_rows_html .= "<td class=\"mood_column\">$mood</td>";
        $table_rows_html .= "<td class=\"text_column\"><pre>$text</pre></td>";
        $table_rows_html .= "</tr>";

        // Prepare a JSON data point.
        if (strlen($mood_data_json) > 0) {
            $mood_data_json .= ", ";
        }

        $mood_data_json .= "{ \"entry_date\":\"$entry_date\", \"mood\":$mood }";

        $row_number++;
    }

    $mood_data_json_array = "[ " . $mood_data_json . " ]";

    // Graph article.
    echo "<article class=\"w3-container\">";
    echo "<h2>Stimmungsverlauf</h2>";
    echo "<script id=\"mood_data\" type=\"application/json\">$mood_data_json_array</script>";
    echo "<canvas id=\"graph_canvas\" alt=\"Graphische Darstellung des Stimmungsverlaufs\"></canvas>";
    echo "</article>";

    // Entry table article.
    echo "<article class=\"w3-container\">";
    echo "<h2>Eintr&auml;ge</h2>";

    echo "<table id=\"entry_table\">";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Datum</th>";
    echo "<th>Stimmung</th>";
    echo "<th>Text</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo $table_rows_html;
    echo "</tbody>";
    echo "</table>";

    echo "</article>";
}

function displayCookieContent() {
    if (!array_key_exists("number_of_entries", $_COOKIE) ||
        !is_numeric($_COOKIE["number_of_entries"])) {
        setcookie("number_of_entries", 1, time()+(3600 * 12));
        return;
    }

    // Increment number of entries.
    $number_of_entries = $_COOKIE["number_of_entries"];
    $number_of_entries++;
    setcookie("number_of_entries", $number_of_entries, time()+(3600 * 12));

    // Display a "welcome back" message.
    echo "<article class=\"w3-container\">";
    echo "<p>Willkommen zurück! Sie haben heute schon den $number_of_entries. Eintrag erfasst.</p>";
    echo "</article>";
}

function prepareHtmlContent() {
    if (!validateParameters()) {
        return;
    }

    displayCookieContent();

    // Connect to MySQL DB.
    $conn = mysqli_connect("localhost", "root", "", "diary");
    if (!$conn) {
        echo "<p>Die Datenbankverbindung ist fehlgeschlagen.</p>";
        return;
    }

    insertEntry($conn);
    displayEntries($conn);

    mysqli_close($conn);
}

?>

<html>
    <head>
        <title>Tagebuch mit Stimmungsbarometer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gentium+Plus:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/entries.css">
        <script type="text/javascript" src="js/graph.js"></script>
    </head>
    <body onload="drawGraph('graph_canvas', JSON.parse(document.getElementById('mood_data').text))">
       <header class="w3-container w3-transparent">
            <h1>Tagebuch mit Stimmungsbarometer - Eintr&auml;ge</h1>
        </header>
        <div id="navigation_container" class="w3-container w3-collapse">
            <nav>
                <a class="w3-bar-item w3-button w3-hover-white" href="index.html">Zur&uuml;ck</a>
            </nav>
        </div>
        <div id="content_container" class="w3-container">
            <section>
                <?php prepareHtmlContent(); ?>
            </section>
        </div>
        <footer class="w3-container w3-transparent">
            <p>Made by Jonas Aklin, MEP WEBT, HSLU, 2022</p>
        </footer>
    </body>
</html>