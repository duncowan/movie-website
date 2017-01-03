/**
 * Module to toggle a particular film's details visibility.
 */
var ShowHide = (function() {
    "use strict";
    // Public interface
    var pub = {};

    /**
     * Toggles the visibility of an element's siblings.
     */
    function showHideDetails() {
        $(this).siblings().toggle();
    }

    /**
     * Setup function for ShowHide module.
     *
     * Whenever the title of a film is clicked, toggle the visibility of the film's details.
     */
    pub.setup = function() {
        $('.film').find('h3').each(function () {    // For each film title
            $(this).click(showHideDetails);     // Add the 'showHideDetails' click event handler
            $(this).css("cursor", "pointer");   // Change the cursor so the title looks clickable
            $(this).click();                    // Hide the film's details by default
        });
    };

    // Expose public interface
    return pub;
}());

// Call ShowHide module's setup function when the web page is ready
$(document).ready(ShowHide.setup);