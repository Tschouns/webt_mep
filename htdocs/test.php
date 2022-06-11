<?php
    [$id_entry_date, $id_mood_slider, $id_entry_text] = array("entry_date", "mood_slider", "entry_text");
    $parameter_missing_error_message = "The following parameter is missing: ";

    if (!array_key_exists($id_entry_date, $_POST))
    {
        echo $parameter_missing_error_message . $id_entry_date;
        return;
    }

    if (!array_key_exists($id_mood_slider, $_POST))
    {
        echo $parameter_missing_error_message . $id_mood_slider;
        return;
    }

    if (!array_key_exists($id_entry_text, $_POST))
    {
        echo $parameter_missing_error_message . $id_entry_text;
        return;
    }

    $entryDate = $_POST[$id_entry_date];
    $moodSlider = $_POST[$id_mood_slider];
    $entryText = $_POST[$id_entry_text];

    $text = $entryDate . " " . $moodSlider . " " . $entryText;

    $html_content = "<p>" . $text ."</p>";
?>
<html>
    <head>
        <title>Tagebuch mit Stimmungsbarometer</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gentium+Plus:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php echo $html_content ?>
    </body>
</html>