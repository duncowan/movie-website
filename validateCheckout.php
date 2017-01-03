<?php
    session_start();
    if(!isset($_SESSION['authenticatedUser'])) {
        header('Location: index.php');
        exit;
    }

    include("noaccess/validationFunctions.php");

    // If user tries to access this without submitting cart form
    if(!isset($_POST['submit'])) {
        header("location: cart.php");
        exit();
    }

    $_SESSION['severErrors'] = array();

    // Check all required fields
    foreach($_POST as $field => $value) {
        $_SESSION[$field] = htmlentities($value);
        $_POST[$field] = htmlentities($value);
        if($field !== "deliveryEmail" && $field !== "deliveryAddress2") {
            if(isEmpty($value)) {
                if(count($_SESSION['severErrors']) < 1) {    // Only display error message once
                    $_SESSION['severErrors'][] = "All required fields must be filled.";
                }
            }
        }
    }

    //Check the postcode field
    if(!checkPostcode($_POST['deliveryPostcode'])) {
    }
    // Check the email field, if it's set
    if(!isEmpty($_POST['deliveryEmail']) && !checkEmail($_POST['deliveryEmail'])) {
    }

    // Check the card number field
    if(!checkCardNumber($_POST['cardType'], $_POST['cardNumber'])) {
        $_SESSION['severErrors'][] = "Invalid card number.";
    }
    // Check the card date fields
    if(!checkCardDate($_POST['cardMonth'], $_POST['cardYear'])) {
        $_SESSION['severErrors'][] = "The card expiry date must be in the future.";
    }
    // Check the card verification field
    if(!checkCardVerification($_POST['cardType'], $_POST['cardValidation'])) {
        $_SESSION['severErrors'][] = "Invalid card validation number.";
    }

    if(count($_SESSION['severErrors']) > 0) {
        header("location: cart.php");
        exit();
    }

    // Remove errors and fields from session if everything is valid
    unset($_SESSION['severErrors']);
    foreach($_POST as $field => $value) {
        unset($_SESSION[$field]);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php
        $scripts = array("scripts/cookie.js");
        include("noaccess/header.php");
    ?>

    <div id="main">
        <?php
            // If all fields are valid, display summary
            if(!isset($_SESSION['severErrors'])) {
                echo "<p>Thank you for your order.</p>";
                echo "<table>
                          <tr>
                              <th>Title</th>
                              <th>Price</th>
                          </tr>";
                $cart = json_decode($_COOKIE['items']);
                foreach($cart as $item) {
                    echo "<tr> 
                              <td>$item->title</td>
                              <td>$item->price</td>
                          </tr>";
                }
                echo "</table>";

                // Add order to xml file
                $orders = simplexml_load_file('noaccess/orders.xml');
                $newOrder = $orders->addChild('order');
                $newOrder->addChild('username', $_SESSION['authenticatedUser']);

                // Delivery details
                $delivery = $newOrder->addChild('delivery');
                $delivery->addChild('name', $_POST['deliveryName']);
                $delivery->addChild('email', (isEmpty($_POST['deliveryEmail']) ? "NOT PROVIDED" : $_POST['deliveryEmail']));
                $delivery->addChild('address', $_POST['deliveryAddress1'].(isEmpty($_POST['deliveryAddress2']) ? "" : ", ".$_POST['deliveryAddress2']));
                $delivery->addChild('city', $_POST['deliveryCity']);
                $delivery->addChild('postcode', $_POST['deliveryPostcode']);

                // Items ordered
                $items = $newOrder->addChild('items');
                foreach($cart as $item) {
                    $newItem = $items->addChild('item');
                    $newItem->addChild('title', $item->title);
                    $newItem->addChild('price', $item->price);
                }

                // Save xml
                $orders->saveXML('noaccess/orders.xml');

                // Remove items from cookie
                unset($_COOKIE['items']);
                setcookie('items', null, -1, '/');
            }
        ?>
    </div>

    <?php include("noaccess/footer.php"); ?>
    </body>
</html>
