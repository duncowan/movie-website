/**
 * Module to make setting/creating, getting and removing cookies easier.
 */
var Cookie = (function () {
    "use strict";
    // Public interface
    var pub = {};

    /**
     * Sets a cookie's value and lifetime (in hours).
     *
     * @param name Name of the cookie to set.
     * @param value The value to set the cookie to.
     * @param hours The lifetime of the cookie (in hours).
     */
    pub.set = function (name, value, hours) {
        var date, expires;
        if (hours) {
            date = new Date();
            date.setHours(date.getHours() + hours);
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
    };

    /**
     * Gets a cookie's value.
     *
     * @param name Name of the cookie to get.
     * @returns String The value of the cookie.
     */
    pub.get = function (name) {
        var nameEq, cookies, cookie, i;
        nameEq = encodeURIComponent(name) + "=";
        cookies = document.cookie.split(";");

        for (i = 0; i < cookies.length; i += 1) {
            cookie = cookies[i].trim();
            if (cookie.indexOf(nameEq) === 0) {
                return decodeURIComponent(cookie.substring(nameEq.length, cookie.length));
            }
        }
        return null;
    };

    /**
     * Completely removes a cookie.
     *
     * @param name Name of the cookie to remove.
     */
    pub.clear = function (name) {
        pub.set(name, "", -1);
    };

    // Expose public interface
    return pub;
}());