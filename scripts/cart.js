/**
 * Module to add items to cart.
 */
var Cart = (function() {
    "use strict";
    // Public interface
    var pub = {};

    /**
     * Adds the item that belongs to the button 'e' to the cart.
     *
     * @param e The 'Add to Cart' button that was clicked.
     */
    function addToCart(e) {
        // Get the film to be added to the cart
        var film = $(e.target).closest('.film');
        // Create a new item with the name and price of the film
        var item = {};
        item.title = film.find('h3').text();
        item.price = film.find('.price').text();

        // Get the previously added items. If there are none, create new array
        var items;
        if(!(items = JSON.parse(Cookie.get("items")))) {
            items = [];
        }
        // Add new item to the cart.
        items.push(item);
        Cookie.set("items", JSON.stringify(items), 1);
    }

    /**
     * Setup function for Cart module.
     *
     * Adds the 'addToCart' on-click-event handler to every 'Add to Cart' button.
     */
    pub.setup = function() {
        $('.buy').click(addToCart);
    };

    // Expose public interface
    return pub;
}());

// Call Cart module's setup function when the web page is ready
$(document).ready(Cart.setup);