<?php
    session_start();
    if(!isset($_SESSION['authenticatedUser'])) {
        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>

<!--
    Sci-Fi category page.
-->

<html lang="en">
        <?php
            $scripts = array("scripts/cookie.js", "scripts/displayCart.js", "scripts/validator.js");
            include("noaccess/header.php");

            function setFieldValue($field) {
                echo "value='".(isset($_SESSION[$field]) ? $_SESSION[$field] : "")."'";
            }
        ?>

        <div id="main">
            <h2>Cart</h2>

            <section id="cartItems"></section>
            <form id="checkoutForm" action="validateCheckout.php" method="POST" novalidate>
                <h3>Customer Details</h3>
                <div id="errors">
                    <?php
                        if(isset($_SESSION['severErrors'])) {
                            echo "<p><strong>There were errors processing your form</strong></p>";
                            echo "<ul>";
                            foreach($_SESSION['severErrors'] as $error) {
                                echo "<li> $error";
                            }
                            echo "</ul>";
                        }
                    ?>
                </div>
                <fieldset id="deliveryDetails">
                    <!-- First section of form is delivery address etc. -->
                    <legend>Delivery Details:</legend>
                    <p>
                        <label for="deliveryName">Deliver to:</label>
                        <input type="text" name="deliveryName" id="deliveryName" required
                        <?php setFieldValue('deliveryName'); ?>>
                    </p>
                    <p>
                        <label for="deliveryEmail">Email:</label>
                        <input type="email" name="deliveryEmail" id="deliveryEmail"
                        <?php setFieldValue('deliveryEmail'); ?>>

                    </p>
                    <p>
                        <label for="deliveryAddress1">Address:</label>
                        <input type="text" name="deliveryAddress1" id="deliveryAddress1" required
                        <?php setFieldValue('deliveryAddress1'); ?>>
                    </p>
                    <p>
                        <label for="deliveryAddress2"></label>
                        <input class="optional" type="text" name="deliveryAddress2" id="deliveryAddress2"
                        <?php setFieldValue('deliveryAddress2'); ?>>
                    </p>
                    <p>
                        <label for="deliveryCity">City:</label>
                        <input type="text" name="deliveryCity" id="deliveryCity" required
                        <?php setFieldValue('deliveryCity'); ?>>
                    </p>
                    <p>
                        <label for="deliveryPostcode">Postcode:</label>
                        <input type="text" name="deliveryPostcode" id="deliveryPostcode" maxlength="4" required class="short"
                        <?php setFieldValue('deliveryPostcode'); ?>>
                    </p>
                </fieldset>

                <!-- Next section has credit card details -->
                <fieldset id="cardDetails">
                    <legend>Payment Details:</legend>
                    <p>
                        <label for="cardType">Card type:</label>
                        <select name="cardType" id="cardType">
                            <option value="amex"
                                <?php echo (isset($_SESSION['cardType']) && $_SESSION['cardType'] === 'amex' ? "selected" : ""); ?>>
                                American Express</option>
                            <option value="mcard"
                                <?php echo (isset($_SESSION['cardType']) && $_SESSION['cardType'] === 'mcard' ? "selected" : ""); ?>>
                                Master Card</option>
                            <option value="visa"
                                <?php echo (isset($_SESSION['cardType']) && $_SESSION['cardType'] === 'visa' ? "selected" : ""); ?>>
                                Visa</option>
                        </select>
                    </p>
                    <p>
                        <label for="cardNumber">Card number:</label>
                        <input type="text" name="cardNumber" id="cardNumber" maxlength="16" required
                        <?php setFieldValue('cardNumber'); ?>>
                    </p>
                    <p>
                        <label for="cardMonth">Expiry date:</label>
                        <select name="cardMonth" id="cardMonth">
                            <?php
                                for($i = 1; $i <= 12; $i++) {
                                    echo "<option ".(isset($_SESSION['cardMonth']) && $_SESSION['cardMonth'] === "$i" ? "selected" : "")
                                        ." value='$i'>".($i < 10 ? "0" : "")."$i</option>";
                                }
                            ?>
                        </select> / <select name="cardYear" id="cardYear">
                            <?php
                                for($i = 14; $i <= 21; $i++) {
                                    echo "<option ".(isset($_SESSION['cardYear']) && $_SESSION['cardYear'] === "20$i" ? "selected" : "")
                                        ." value='20$i'>20$i</option>";
                                }
                            ?>
                        </select>
                    </p>
                    <p>
                        <label for="cardValidation">CVC:</label>
                        <input type="text" class="short" maxlength="4" name="cardValidation" id="cardValidation" required
                        <?php setFieldValue('cardValidation'); ?>>
                    </p>
                </fieldset>
                <input type="submit" name="submit">
            </form>
        </div>

        <?php include("noaccess/footer.php"); ?>
    </body>
</html>
