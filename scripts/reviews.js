/**
 * Module to get and display the reviews for a particular film.
 */
var Reviews = (function() {
    "use strict";
    // Public interface
    var pub = {};

    /**
     * Takes the review data from an XML file, formats it and puts it into the target element
     * on the page.
     *
     * @param data Raw review data from the XML file.
     * @param target The element to put the formatted review data into.
     */
    function parseReviews(data, target) {
        // Assume there is no reviews.
        var reviews = "<p>There are no reviews for the item.</p>";
        if ($(data).find('review').length > 0) {    // If there are reviews
            reviews = $('<dl></dl>');   // Create a new description list
            $(data).find('review').each(function () {   // Add each review to the list
                reviews.append('<dt>' + $(this).find('user').text() + '</dt><dd>' + $(this).find('rating').text() + '</dd>');
            });
        }
        // Put the list into the target element
        // (if there are no reviews, display the text "There are no reviews for the item.")
        $(target).html(reviews);
    }

    /**
     * Uses ajax to get the reviews XML file for a particular film, then parses XML's data
     * to the 'parseReviews' method for processing.
     */
    function showReviews() {
        // Get the location of the film's reviews XML file
        var data = $(this).parent().siblings('img').attr('src').replace("images", "reviews").replace("jpg", "xml");
        // Get the target element to put the formatted review data into
        var target = $(this).siblings('.reviews');
        // Ajax call to get the reviews XML file
        $.ajax({
            type: "GET",
            url: data,
            cache: false,
            // If call was successful, parse the retrieved data to the 'parseReviews' method
            success: function(data) {
                parseReviews(data, target);
            },
            // If call was unsuccessful, display the text "There are no reviews for the item."
            // in the target element.
            error: function () {
                target.html('<p>There are no reviews for the item.</p>');
            }
        });
    }

    /**
     * Setup function for Reviews module.
     *
     * For every film, add a button that gets the reviews for that film and a div to put
     * the reviews into.
     */
    pub.setup = function() {
        // Add a button with the text "Show Reviews" to the bottom of a film section
        $('.film').find('p:last').append('<input type="button" class="showReviews" value="Show Reviews">',
            // Add a div for putting the reviews into at the bottom of a film section
            '<div class="reviews" style="clear: both"></div>');
        // Add the 'showReviews' on-click-event handler to the "Show Reviews" button
        $(".showReviews").click(showReviews);
    };

    // Expose public interface
    return pub;
}());

// Call Review module's setup function when the web page is ready
$(document).ready(Reviews.setup);