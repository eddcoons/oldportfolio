modules.export = (function ($) {
    $.fn.toggle = function () {
        $(this).each(function () {
            var createToggles = new Toggle($(this));
        });
    };

    var Toggle = function (accordian) {
        var toggleContent = accordian.find('.content'),
            btnWrap = accordian.find('.trigger');

        var fullWidth = toggleContent.innerWidth(true);

        btnWrap.wrapInner("<a href='#' />");
        var btn = btnWrap.find('a');
        btn.append('<span>+</span>');
        toggleContent.css('width', fullWidth).hide().first().show();
        btn.first().toggleClass('current');

        // Remove focus after click, keyboard accessibility uneffected
        btn.mouseup(function () {
            $(this).blur();
        });

        // Styling for ipad hover
        btn.on('touchstart', function () {
            $(this).addClass('touch-hover');
        });

        btn.click(function (e) {
            if (e.which == 13) {
            }
            $(this).toggleClass('current').parent().next().slideToggle('normal');
            return false;
        });
    };
})(jQuery);