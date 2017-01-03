/**
 * Module to cycle through movie category previews on the home page.
 */
var Carousel = (function() {
    "use strict";
    // Public interface
    var pub = {};

    var categoryList, categoryIndex;

    /**
     * Displays the next movie category preview.
     *
     * Previews fade in from the left, stay for 3 seconds, then fade off to the right.
     */
    function nextCategory() {
        var currCategory, categoryContainer = $('#categorycarousel');
        // If there are no categories currently being displayed
        if((currCategory = categoryContainer.find('a')).length < 1) {
            // Add the next category preview in the category list to the page
            categoryContainer.append(categoryList[(categoryIndex++) % categoryList.length].makeHTML());
            // Increase it's width and opacity to 100% over the span of 1 second
            categoryContainer.find('a').animate({width: "100%", opacity: 1.0}, 1000);
        } else {    // If there's already a category being displayed
            // Float it right
            currCategory.css("float", "right");
            // Decrease it's width and opacity to 0% over the span of 1 second
            currCategory.animate({width: "0%", opacity: 0.0}, {duration: 1000, complete: function() {
                // When the animation is complete, remove the current category
                currCategory.remove();
                // And display the next one
                nextCategory();
            }});
        }
    }

    /**
     * Prototype that defines a movie category preview.
     *
     * @param title Title of the category.
     * @param image Location of the preview image for the category.
     * @param page Location of the category page.
     */
    function MovieCategory(title, image, page) {
        this.title = title;
        this.image = image;
        this.page = page;
        this.makeHTML = function () {
            var aHTML = "<a href=" + this.page + ">";
            var imgHTML = "<img src=" + this.image + ">";
            var figcaptionHTML = "<figcaption>" + this.title + "</figcaption>";
            return aHTML + "<figure>" + imgHTML + figcaptionHTML + "</figure></a>";
        };
    }

    /**
     * Setup function for Carousel module.
     *
     * Creates new movie category preview objects, adds them to a list, then cycles through
     * them every 4 seconds.
     */
    pub.setup = function() {
        categoryList = [];
        categoryList.push(new MovieCategory("Classic Films", "images/Metropolis.jpg", "classic.php"));
        categoryList.push(new MovieCategory("Science Fiction and Horror", "images/Plan_9_from_Outer_Space.jpg", "scifi.php"));
        categoryList.push(new MovieCategory("Alfred Hitchcock", "images/The_Birds.jpg", "hitchcock.php"));
        categoryIndex = 0;
        nextCategory();
        // Displays the next category preview every 4 seconds
        setInterval(nextCategory, 4000);
    };

    // Expose public interface
    return pub;
}());

// Call Carousel module's setup function when the web page is ready
$(document).ready(Carousel.setup);
