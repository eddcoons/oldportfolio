module.export = (function ($) {
    $.fn.accordian = function () {
        $(this).each(function () {
            var CreateAccordian = new Accordian($(this));
        });
    };

    var Accordian = function (accordian) {
        var btnWrap = accordian.find('.trigger'),
            content = accordian.find('.content');
        var fullWidth = content.outerWidth(true);
        btnWrap.wrapInner("<a href='#' />");
        var button = btnWrap.find('a');
        button.append('<span>+</span>');
        content.hide().first().show();
        button.first().toggleClass('current');

        button.css({'cursor': 'pointer'});

        button.mouseup(function () {
            $(this).blur();
        });

        // Styling for ipad hover
        button.on('touchstart', function () {
            $(this).addClass('touch-hover');
        });

        button.click(function () {
            $(this).parent().siblings().find('a').removeClass('current');
            $(this).parent().siblings('.content').slideUp('normal');
            $(this).addClass('current').parent().next().slideDown('normal');
            return false;
        });
        return this;
    };
})(jQuery);