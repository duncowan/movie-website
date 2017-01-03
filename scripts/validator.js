/**
 * Module for Validation functions.
 */
var Validator = (function () {
    "use strict";
    // Public interface
    var pub = {};

    /**
     * Check to see if a string is empty.
     *
     * Leading and trailing whitespace are ignored.
     *
     * @param textValue The string to check.
     * @return True if textValue is not just whitespace, false otherwise.
     */
    function checkNotEmpty(textValue) {
        return textValue.trim().length > 0;
    }

    /**
     * Check to see if a string contains just digits.
     *
     * Note that an empty string is not considered to be 'digits'.
     *
     * @param textValue The string to check.
     * @return True if textValue contains only the characters 0-9, false otherwise.
     */
    function checkDigits(textValue) {
        var pattern = /^[0-9]+$/;
        return pattern.test(textValue);
    }

    /**
     * Check to see if a string's length is in a given range.
     *
     * This checks to see if the length of a string lies within [minLength, maxLength].
     * If no maxLength is given, it checks to see if the string's length is exactly minLength.
     *
     *  @param textValue The string to check.
     * @param minLength The minimum acceptable length
     * @param maxLength [optional] The maximum acceptable length
     * @return True if textValue is an acceptable length, false otherwise.
     */
    function checkLength(textValue, minLength, maxLength) {
        var length = textValue.length;
        if (maxLength === undefined) {
            maxLength = minLength;
        }
        return (length >= minLength && length <= maxLength);
    }

    /**
     * Check if a key-press is a digit or not
     *
     * @param event The event representing the key-press
     * @return True (accept) if key is a digit, False (reject) otherwise
     */
    function checkKeyIsDigit(event) {
        // Cross-browser key recognition - see http://stackoverflow.com/questions/1444477/keycode-and-charcode
        var characterPressed, zero, nine, backspace;
        zero = "0";
        nine = "9";
        backspace = 8;  //ASCII code for backspace
        characterPressed = event.keyCode || event.which || event.charCode;
        //allow the backspace key code to be passed through
        if(characterPressed === backspace) {
            return true;
        }
        if (characterPressed < zero.charCodeAt(0)) {
            return false;
        }
        if (characterPressed > nine.charCodeAt(0)) {
            return false;
        }
        return true;
    }

    /**
     * Check to see if a string starts with a given substring
     *
     * @param textValue The string to check.
     * @param startValue The expected starting substring
     * @return True if textValue starts with startValue, False otherwise
     */
    function startsWith(textValue, startValue) {
        return textValue.substring(0, startValue.length) === startValue;
    }

    /**
     * Check to see if all the fields in 'fieldset' are filled
     *
     * @param fieldset The fieldset containing the inputs to check
     * @param messages Array of error messages (may be modified)
     * @return True if all inputs in 'fieldset' are filled, False otherwise
     */
    function checkFieldsFilled(fieldset, messages) {
        $(fieldset).find('input:required').each(function () {
            if(!checkNotEmpty($(this).val())) {
                var labelText = $(this).siblings('label').text();
                messages.push("You must fill out "+labelText.substr(0, labelText.length-1));
            }
        });
    }

    /**
     * Check that a postcode looks valid
     *
     * Postcodes must be 4 numbers long
     *
     * @param postcode The postcode to check
     * @param messages Array of error messages (may be modified)
     * @return True if postcode is valid, False otherwise
     */
    function checkPostcode(postcode, messages) {
        if(!checkNotEmpty(postcode)) {
            //message has already been added by 'checkFieldsFilled'
            return;
        } else if(!checkDigits(postcode)) {
            messages.push("The postcode must only contain the digits 0-9");
        } else if(!checkLength(postcode, 4)) {
            messages.push("The postcode must be 4 digits long");
        }
    }

    /**
     * Check that a email address looks valid
     *
     * Email addresses COULD contain any combination of letters, numbers, '_', '-' or '.' but MUST contain an '@'
     *
     * @param email The email address to check
     * @param messages Array of error messages (may be modified)
     * @return True if email address is valid, False otherwise
     */
    function checkEmail(email, messages) {
        var pattern = /^[a-zA-Z0-9_\-]+(\.[a-zA-Z0-9_\-]+)*@[a-zA-Z0-9_\-]+(\.[a-zA-Z0-9_\-]+)*$/;
        if(!checkNotEmpty(email)) {
            //message has already been added by 'checkFieldsFilled'
            return;
        } else if(!pattern.test(email)) {
            messages.push("The entered email address is not valid");
        }
    }

    /**
     * Check that a credit card number looks valid
     *
     * Basic checks depend on card type
     * American Express - 15 digits starting with 3
     * Master Card - 16 digits starting with 5
     * Visa - 16 digits starting with 4
     *
     * @param cardType The type of credit card (amex | visa | mcard)
     * @param cardNumber The card number to check
     * @param messages Array of error messages (may be modified)
     * @return True if cardNumber passes basic checks, false otherwise
     */
    function checkCreditCardNumber(cardType, cardNumber, messages) {
        if (!checkNotEmpty(cardNumber)) {
            messages.push("You must enter a credit card number");
        } else if (!checkDigits(cardNumber)) {
            // Just numbers
            messages.push("The credit card number should only contain the digits 0-9");
        } else if (cardType === "amex" && (!checkLength(cardNumber, 15) || !startsWith(cardNumber, "3"))) {
            // American Express: 15 digits, starts with a 3
            messages.push("American Express card numbers must be 15 digits long and start with a '3'");
        } else if (cardType === "mcard" && (!checkLength(cardNumber, 16) || !startsWith(cardNumber, "5"))) {
            // MasterCard: 16 digits, starting with a 5
            messages.push("MasterCard numbers must be 16 digits long and start with a '5'");
        } else if (cardType === "visa" && (!checkLength(cardNumber, 16) || !startsWith(cardNumber, "4"))) {
            // Visa: 16 digits, starts with a 4
            messages.push("Visa card numbers must be 16 digits long and start with a '4'");
        }
    }

    /**
     * Check that a credit card expiry date is in the future
     *
     * @param cardMonth The expiry month of the card (1-12)
     * @param cardYear The expiry year of the card (eg: 2017)
     * @param messages Array of error messages (may be modified)
     * @return True if cardValidation passes basic checks, false otherwise
     */
    function checkCreditCardDate(cardMonth, cardYear, messages) {
        var today;
        today = new Date();
        cardMonth = parseInt(cardMonth, 10);
        cardYear = parseInt(cardYear, 10);
        if (!cardYear) {
            messages.push("Invalid year in card expiry date");
        } else if (!cardMonth || cardMonth < 1 || cardMonth > 12) {
            messages.push("Invalid month in card expiry date");
        } else if (cardYear < today.getFullYear()) {
            // Year is in the past, not valid regardless of month
            messages.push("The card expiry date must be in the future");
        } else if (cardYear === today.getFullYear()) {
            // Year is this year, so need to check the month
            // Note - JS counts months from 0 (= January)
            // So the +1 and <= is correct, (even though it looks odd)
            if (cardMonth <= today.getMonth() + 1) {
                messages.push("The card expiry date must be in the future");
            }
        } // else year is in the future, so valid regardless of month
    }

    /**
     * Check that a credit card verification code looks valid
     *
     * Basic checks depend on card type
     * American Express - 4 digits
     * Master Card/Visa - 3 digits
     *
     * @param cardType The type of credit card (amex | visa | mcard)
     * @param cardValidation The validation number to check
     * @param messages Array of error messages (may be modified)
     * @return True if cardValidation passes basic checks, false otherwise
     */
    function checkCreditCardValidation(cardType, cardValidation, messages) {
        // General: Just numbers
        if (!checkNotEmpty(cardValidation)) {
            // A required field
            messages.push("You must enter a CVC value");
        } else if (!checkDigits(cardValidation)) {
            // Just numbers
            messages.push("The CVC should only contain the digits 0-9");
        } else if (cardType === "amex" && !checkLength(cardValidation, 4)) {
            // Amex, 4 digits
            messages.push("American Express CVC values must be 4 digits long");
        } else if (cardType === "mcard" && !checkLength(cardValidation, 3)) {
            // MasterCard, 3 digits
            messages.push("MasterCard CVC values must be 3 digits long");
        } else if (cardType === "visa" && !checkLength(cardValidation, 3)) {
            // Visa, 3 digits
            messages.push("Visa CVC values must be 3 digits long");
        }
    }

    /**
     * Check that everything to do with delivery looks valid
     *
     * @param fieldset The fieldset that contains the delivery input fields
     * @param messages Array of error messages (may be modified)
     */
    function checkDelivery(fieldset, messages) {
        // All inputs filled
        checkFieldsFilled($(fieldset), messages);
        // Postcode validation
        checkPostcode($(fieldset).find('#deliveryPostcode').val(), messages);
        // Email validation
        checkEmail($(fieldset).find('#deliveryEmail').val(), messages);
    }

    /**
     * Check that everything to do with the Credit Card looks valid
     *
     * @param fieldset The fieldset that contains the Credit Card input fields
     * @param messages Array of error messages (may be modified)
     */
    function checkCard(fieldset, messages) {
        // This depends a bit on the type of card, so get that first
        var cardType = $(fieldset).find('#cardType').val();
        // Credit card number validation
        var cardNumber = $(fieldset).find('#cardNumber').val();
        checkCreditCardNumber(cardType, cardNumber, messages);

        // Expiry date validation
        var cardMonth = $(fieldset).find('#cardMonth').val();
        var cardYear = $(fieldset).find('#cardYear').val();
        checkCreditCardDate(cardMonth, cardYear, messages);

        // CVC validation
        var cardValidation = $(fieldset).find('#cardValidation').val();
        checkCreditCardValidation(cardType, cardValidation, messages);
    }

    /**
     * Displays errors to the user
     *
     * @param messages Error messages to display
     * @param element Element where the error messages will be displayed
     * @return void
     */
    function displayErrors(element, messages) {
        var errorList = $('<ul></ul>');
        messages.forEach(function (msg) {
            errorList.append('<li>' + msg);
        });
        $(element).html('<p><strong>There were errors processing your form</strong></p>');
        $(element).append(errorList);
    }

    /**
     * Validate the checkout form
     *
     * Check the form entries before submission
     *
     * @return False, because server-side form handling is not implemented. Eventually will return true on success and false otherwise.
     */
    function validateCheckout() {
        // Default assumption is that everything is good, and no messages
        var messages = [];

        // Validate Address Details
        checkDelivery($('#deliveryDetails'), messages);

        // Validate Credit Card Details
        checkCard($('#cardDetails'), messages);

        if (messages.length === 0) {
            // Checkout successful, clear the cart
            Cookie.clear("items");
            // Display a friendly message
            $('#main').html('<p>Thank you for your order</p>');
        } else {
            // Report the error messages
            displayErrors($('#errors'), messages);
        }

        // Stop the form from submitting, which would trigger a page load
        // In future this will return true if the form is OK and can be submitted to the server
        return false;

    }

    /**
     * Setup function for sample validation.
     *
     * Adds validation to the form on submission.
     * Note that if the validation fails (returns false) then the form is not submitted.
     */
    pub.setup = function () {
        $('#checkoutForm').submit(validateCheckout);
        $('#deliveryPostcode').keypress(checkKeyIsDigit);
        $('#cardNumber').keypress(checkKeyIsDigit);
        $('#cardValidation').keypress(checkKeyIsDigit);
    };

    // Expose public interface
    return pub;
}());

// Call DisplayCart module's setup function when the web page is ready
$(document).ready(Validator.setup);
