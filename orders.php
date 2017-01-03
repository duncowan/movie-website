<?php
    session_start();
    if(!isset($_SESSION['authenticatedUser'])) {
        header('Location: index.php');
        exit;
    }
?>

<!--
    Orders page.
-->

<!DOCTYPE html>
<html lang="en">
    <?php
        $scripts = array("scripts/cookie.js");
        include("noaccess/header.php");
    ?>

    <div id="main">
        <h2>Orders</h2>
        <?php
            $orders = simplexml_load_file('noaccess/orders.xml');
            $orderNum = 0;
            foreach ($orders->order as $order) {
                if($_SESSION['role'] === 'user' &&
                   $order->username != $_SESSION['authenticatedUser']) {

                    continue;
                }

                $orderNum++;
                $name = $order->delivery->name;
                $email = $order->delivery->email;
                $address = $order->delivery->address;
                $city = $order->delivery->city;
                $postcode = $order->delivery->postcode;
                $items = $order->items->item;

                echo "<section class='order'>";
                echo "<h3>Order #$orderNum</h3>";
                echo "<p><strong>Delivery Details</strong><br>";
                echo "Name: $name<br>";
                echo "Email: $email<br>";
                echo "Address: $address<br>";
                echo "City: $city<br>";
                echo "Postcode: $postcode</p>";

                echo "<p><strong>Items Ordered</strong><br>";
                foreach($items as $item) {
                    echo $item->title.", ".$item->price."<br>";
                }
                echo "</p>";
                echo "</section>";
            }
            if($orderNum < 1) {
                echo "<p>You have no orders.</p>";
            }
        ?>
    </div>

    <?php include("noaccess/footer.php"); ?>
    </body>
</html>
