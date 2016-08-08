module.export = (function ($) {

    $.fn.countdownTimer = function () {

        $(this).each(function () {
            var count_down_date = $(this).data('date');
            var countdownTimerObj = new countdownTimer(count_down_date, this);
        });
    };

    function countdownTimer(time, counter) {
        var end = new Date(time);
        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var timer;
        $(counter).prepend('<span class="days"></span>:<span class="hours"></span>:<span class="minutes"></span>:<span class="seconds"></span>');

        function interval() {
            var now = new Date();
            var distance = end - now;

            if (distance < 0) {
                clearInterval(timer);
                $(counter).text('Very Soon');
                return;
            }

            var days = Math.floor(distance / _day);
            var hours = Math.floor((distance % _day) / _hour);
            var minutes = Math.floor((distance % _hour) / _minute);
            var seconds = Math.floor((distance % _minute) / _second);
            $(counter).find('.days').text(("00" + days).slice(-3));
            $(counter).find('.hours').text(("0" + hours).slice(-2));
            $(counter).find('.minutes').text(("0" + minutes).slice(-2));
            $(counter).find('.seconds').text(("0" + seconds).slice(-2));
        }

        return setInterval(interval, 1000);
    }

})(jQuery);