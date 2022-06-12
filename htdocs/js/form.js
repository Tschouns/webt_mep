function validateEntryDate() {
    let datePicker = document.getElementById("entry_date");
    let datePickerMessage = document.getElementById("entry_date_message");

    if (datePicker.value == null) {
        datePickerMessage.innerHTML = "Es muss ein Datum ausgew&auml;hlt werden.";

        return false;
    }

    let date = new Date(datePicker.value);
    if (isNaN(date.getTime()) || date.getTime() !== date.getTime()) {
        datePickerMessage.innerHTML = "Das ausgew&auml;hlte Datum ist nicht g&uuml;ltig.";

        return false;
    }

    datePickerMessage.innerHTML = date;

    return true;
}