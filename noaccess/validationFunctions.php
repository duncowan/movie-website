<?php
    /**
     * Check to see if a string is composed entirely of the digits 0-9.
     * Note that this is different to checking if a string is numeric since
     * +/- signs and decimal points are not permitted.
     *
     * @param string $str The string to check.
     * @return True if $str is composed entirely of digits, false otherwise.
     */
    function isDigits($str) {
      $pattern='/^[0-9]+$/';
      return preg_match($pattern, $str);
    }

    /**
     * Check to see if a string contains any content or not.
     * Leading and trailing whitespace are not considered to be 'content'.
     *
     * @param string $str The string to check.
     * @return True if $str is empty, false otherwise.
     */
    function isEmpty($str) {
      return strlen(trim($str)) == 0;
    }

    /**
     * Check to see if a string looks like an email.
     * Email validation is actually fairly complex, so this is a thin wrapper
     * around a PHP filter function.
     *
     * @param string $str The string to check.
     * @return True if $str looks like a valid email address, false otherwise.
     */
    function isEmail($str) {
      // There's a built in PHP tool that has a go at this
      return filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Check to see if the length of a string is a given value, ignoring leading
     * and trailing whitespace.
     *
     * @param string $str The string to check.
     * @param integer $len The expected length of $str.
     * @return True if $str has length $len, false otherwise.
     */
    function checkLength($str, $len) {
      return strlen(trim($str)) === $len;
    }

    /**
     * Check credit card number.
     * This provides some rudimentary validation of a credit card number.
     * These checks depend on the card type:
     * - American express ($cardType = 'amex') card numbers must be 15 digits long and start with a 3.
     * - MasterCard ($cardType = 'mcard') card numbers must be 16 digits long and start with a 5.
     * - Visa ($cardType = 'visa') card numbers must be 16 digits long and start with a 4.
     *
     * @param string $cardType The type of card, one of 'amex', 'mcard', or 'visa'.
     * @param string $cardNumber The credit card number.
     * @return True if $cardNumber passes some basic checks, false otherwise.
     */
    function checkCardNumber($cardType, $cardNumber) {
      if (!isDigits($cardNumber)) {
        return false;
      }

      switch ($cardType) {
        case 'amex':
          return checkLength($cardNumber, 15) && (int)$cardNumber[0] === 3;
          break;
        case 'mcard':
          return checkLength($cardNumber, 16) && (int)$cardNumber[0] === 5;
          break;
        case 'visa':
          return checkLength($cardNumber, 16) && (int)$cardNumber[0] === 4;
          break;
        default:
          return false;
        }
     }


    /**
     * Check credit card verification code.
     * This provides some rudimentary validation of a credit card number.
     * These checks depend on the card type:
     * - American express ($cardType = 'amex') card verification codes must be 4 digits long.
     * - MasterCard ($cardType = 'mcard') card verification codes must be 3 digits long.
     * - Visa ($cardType = 'visa') card verification codes must be 3 digits long.
     *
     * @param string $cardType The type of card, one of 'amex', 'mcard', or 'visa'.
     * @param string $cardVerify The credit card verification code.
     * @return True if $cardVerify passes some basic checks, false otherwise.
     */
    function checkCardVerification($cardType, $cardVerify) {
      if (!isDigits($cardVerify)) {
        return false;
      }

      switch ($cardType) {
        case 'amex':
          return checkLength($cardVerify, 4);
          break;
        case 'mcard':
        case 'visa':
          return checkLength($cardVerify, 3);
          break;
        default:
          return false;
      }
     }

    /**
     * Check credit card expiry date.
     * Checks that the date provided is in the future.
     *
     * @param string $cardMonth Numeric value of card expiry month.
     * @param string $cardYear Card expiry year.
     * @return True if $cardMonth/$cardYear is in the future, false otherwise.
     */
    function checkCardDate($cardMonth, $cardYear) {
      $year = (int) date('Y');
      $month = (int) date('n');
      $cardYear = (int) $cardYear;
      $cardMonth = (int) $cardMonth;

      if ($year > $cardYear) {
        return false;
      } elseif ($year === $cardYear && $month >= $cardMonth) {
        return false;
      } else {
        return true;
      }
    }

    /**
     * Check to see if all required fields are filled
     *
     * @param array $fields The fields to check
     * @return True if all inputs are filled, False otherwise
     */
    function checkRequiredFilled($fields) {
        foreach($fields as $field => $value) {
            if($field !== "deliveryEmail" && $field !== "deliveryAddress2") {
                if(isEmpty($value)) {
                    //echo "All required fields must be filled.<br>";
                    $_SESSION['severErrors'][] = "All required fields must be filled.";
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Check that a postcode looks valid
     *
     * Postcodes must be 4 numbers long
     *
     * @param string $postcode The postcode to check
     * @return True if postcode is valid, False otherwise
     */
    function checkPostcode($postcode) {
        if(isEmpty($postcode)) {
            //message has already been added by 'checkRequiredFilled'
            return false;
        } else if(!isDigits($postcode)) {
            //echo "The postcode must only contain the digits 0-9.<br>";
            $_SESSION['severErrors'][] = "The postcode must only contain the digits 0-9.";
            return false;
        } else if(!checkLength($postcode, 4)) {
            //echo "The postcode must be 4 digits long.<br>";
            $_SESSION['severErrors'][] = "The postcode must be 4 digits long.";
            return false;
        }
        return true;
    }

    /**
     * Check if email address is valid
     *
     * @param string $email The email address to check
     * @return True if email address is valid, False otherwise
     */
    function checkEmail($email) {
        if(!isEmail($email)) {
            //echo "The entered email address is not valid.<br>";
            $_SESSION['severErrors'][] = "The entered email address is not valid.";
            return false;
        }
        return true;
    }