<html>
    <head>
        <title>Tagebuch mit Stimmungsbarometer</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gentium+Plus:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
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

/* Main */
if (!validateParameters()) {
    return;
}

$entry_date = $_POST["entry_date"];
$mood_slider = $_POST["mood_slider"];
$entry_text = $_POST["entry_text"];

$text = $entry_date . " " . $mood_slider . " " . $entry_text;

echo "<p>" . $text ."</p>";

?>
    </body>
</html>