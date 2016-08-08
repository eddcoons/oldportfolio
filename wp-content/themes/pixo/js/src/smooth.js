
/* ===================================================== */
/* Smooth Scrolling                                      */
/* ===================================================== */

(function ($) {
    "use strict";

    /**
     *
     * @param { options }
     * scrollSpeed
     * offset
     * func
     */
    $.smooth = function (options) {

        var defaults = {
            scrollSpeed: 2000,
            offset: 0,
            func: function () {}
        };

        // Merge options
        var settings = $.extend({}, defaults, options);

        var pos;

        // Get scroll to position
        if ($.isNumeric(settings.elem)) {
            pos = settings.elem;
        } else {

            // Exit if we can't find the element
            if ( 0 === $(settings.elem).length ) {
                console.warn( 'Cannot find Item with ID', settings.elem );
                return;
            }

            pos = $(settings.elem).offset().top;
        }

        // Animate
        $('html, body').animate({
            scrollTop: pos + settings.offset
        }, settings.scrollSpeed, function () {
            settings.func();
        });
    };

})(jQuery);