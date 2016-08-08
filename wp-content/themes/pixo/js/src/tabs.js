
modules.export = (function ($) {

    $.fn.zbxtabs = function (options) {
        $(this).each(function () {
            var CreateTabs = new Tabs($(this), options);
        });
    };

    var Tabs = function (container, options) {
        var contents = $(container.find('.content'));
        var btnWrap = $(container.find('.trigger'));
        this.container = container;

        container.prepend(btnWrap);

        if (btnWrap.find("a").length < 1) {
            btnWrap.wrapInner("<a href='#' />");
        }

        if (options.type === 'side') {
            btnWrap.wrapAll("<div class='zbxtabs-wrap'></div>");
            contents.wrapAll("<div class='contents-wrap'></div>");
        }

        var btn = btnWrap.find('a');

        btnWrap.last().css('margin-right', '0');
        btn.first().addClass('current');

        // Hide content, show first
        contents.hide().first().show();
        btn.data('container', container);

        // Remove focus after click, keyboard accessibility uneffected
        btn.mouseup(function () {
            $(this).blur();
        });

        btn.click(function () {
            var container = $(this).data('container');
            container = $(container);
            var tabNum = $(this).parent().index();
            container.find('a').removeClass('current');
            $(this).addClass('current');
            container.css('minHeight', container.height());
            container.find('.content').fadeOut().hide();
            container.find('.tab' + tabNum).fadeIn(function () {
                container.css('minHeight', '0');
            });
            // container.css( 'height', 'auto' );
            return false;
        });

        return this;
    };

})(jQuery);