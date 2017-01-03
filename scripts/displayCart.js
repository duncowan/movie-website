/**
 * Module to display items in the cart.
 */
var DisplayCart = (function() {
    "use strict";
    // Public interface
    var pub = {};

    /**
     * Puts every item's name and price, along with the overall total price, into the
     * element with the id 'cartItems'.
     */
    function displayItems() {
        var items, totalPrice = 0;
        // Get the element that will display the items and overall total price
        var container = $('#cartItems');
        // If there are items in the cart
        if((items = JSON.parse(Cookie.get("items")))) {
            // Clear everything from the 'cartItems' element and add the heading "Items in cart"
            container.html("<h3>Items in cart</h3>");
            items.forEach(function(item) {              // Loop through all items in cart
                totalPrice += parseFloat(item.price);   // Add item's price to total price

                container.append(                       // Add item to 'cartItems' element
                    $('<p class="item"></p>').append(
                        '<span class="title">'+item.title+'</span><br>',
                        '<span class="price"><em>$'+item.price+'</em></span>'
                    )
                );
            });
            // Add total price to 'cartItems' element
            container.append("<span id='totalPrice'><strong>Total Price: $"+totalPrice.toFixed(2)+"</strong></span>");
        } else {    // If there are no items in the cart
            // Clear everything from the 'cartItems' element and add the heading "No items in cart"
            container.html("<h3>No items in cart</h3>");
            // Hide the delivery and credit card details form
            $('#checkoutForm').hide();
        }
    }

    /**
     * Setup function for DisplayCart module.
     *
     * If there is an element on the page with the id 'cartItems', display the cart and total
     * price.
     */
    pub.setup = function() {
        if($('#cartItems')) {
            displayItems();
        }
    };

    // Expose public interface
    return pub;
}());

// Call DisplayCart module's setup function when the web page is ready
$(document).ready(DisplayCart.setup);