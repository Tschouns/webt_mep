/**
 * Validates the currently selected entry date; and, if not, displays an error message.
 * @returns {boolean} A value indicating whether the date is valid
 */
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

    datePickerMessage.innerHTML = "";
    return true;
}

/**
 * Displays the currently selected mood value.
 */
function displayMood() {
    let slider = document.getElementById("mood_slider");
    let sliderMessage = document.getElementById("mood_slider_message");

    sliderMessage.innerHTML = slider.value;
}

/**
 * Validates the currently entered entry text; and, if not, displays an error message.
 * @returns {boolean} A value indicating whether the text is valid
 */
function validateEntryText() {
    let textBox = document.getElementById("entry_text");
    let textBoxMessage = document.getElementById("entry_text_message");

    if (textBox.value == null || textBox.value.length == 0) {
        textBoxMessage.innerHTML = "Es muss ein Text eingegeben werden.";
        return false;
    }

    textBoxMessage.innerHTML = "";
    return true;
}

/**
 * Validates the entire form, and displays error messages.
 * @returns {boolean} A value indicating whether the entered values are valid
 */
function validateForm() {
    displayMood();

    let isDateValid = validateEntryDate();
    let isTextValid = validateEntryText();

    return isDateValid && isTextValid;
}

/**
 * Attaches an event handler to the submit button click event, which prevents an invalid form from being submitted.
 */
function attachSubmitEventHandler() {
    document.getElementById("submit_button").addEventListener("click", function(event){
        if (!validateForm()) {
            event.preventDefault();
        }
    });
}