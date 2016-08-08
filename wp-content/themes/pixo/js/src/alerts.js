module.export = (function ($) {
    $.fn.alerts = function () {

        var button = $(this).prepend('<a class="alert-button" href="#"></a>')

        $('.alert-button').click(function () {
            $(this).parent().animate({
                opacity: "toggle"
            });
            return false;
        });

    };
})(jQuery);