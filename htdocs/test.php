<?php
    $html_content = prepareHtmlContent();

    function prepareHtmlContent()
    {
        [$id_entry_date, $id_mood_slider, $id_entry_text] = array("entry_date", "mood_slider", "entry_text");

        if (!array_key_exists($id_entry_date, $_POST) || !validateDate($_POST[$id_entry_date]))
        {
            return "The parameter " . $id_entry_date . " is missing, or not a valid date.";
        }

        if (!array_key_exists($id_mood_slider, $_POST) ||
            !is_numeric($_POST[$id_mood_slider]) ||
            (intval($_POST[$id_mood_slider])) < 1 ||
            (intval($_POST[$id_mood_slider])) > 10)
        {
           return "The parameter " . $id_mood_slider . " is missing, or not a valid number between 1 and 10.";
        }

        if (!array_key_exists($id_entry_text, $_POST) || strlen($_POST[$id_entry_text]) == 0)
        {
            return "The parameter " . $id_entry_text . " is missing, or empty.";
        }

        $entry_date = $_POST[$id_entry_date];
        $mood_slider = $_POST[$id_mood_slider];
        $entry_text = $_POST[$id_entry_text];

        $text = $entry_date . " " . $mood_slider . " " . $entry_text;

        return "<p>" . $text ."</p>";
    }

    function validateDate($date_string)
    {
        $format = 'Y-m-d';
        $d = DateTime::createFromFormat($format, $date_string);

        return $d && $d->format($format) === $date_string;
    }
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