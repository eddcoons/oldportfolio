
modules.export = (function ($) {
    $.fn.newsletter = function (options) {
        $(this).each(function () {
            var defaults = {
                    inlineErrors: true,
                    formName: $(this)
                },

                options_set = $.extend(defaults, options),
                newsletter = new newsletterFnc(options_set);
        });
    };

    var newsletterFnc = function (options) {
        var formName = options.formName;

        // Add spinner
        var email = $(formName.find('.newsletter-email'));

        // Validate Email
        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        // Validation on keyup
        function keyupval() {
            if (IsEmail(email.val())) { // Validation pass
                // remove error and keybinding
                email.parent().children('span').remove('.inline-error');
                email.removeClass("error");
                email.unbind('keyup');
            }
        } // Keyup

        var emailErrorMsg = 'Your email is not valid';

        // Submit, validate then send to php
        formName.submit(function () {
            formName.find('.alert').remove(); // Remove previous php msg
            email = formName.find('.newsletter-email');
            if (!IsEmail(email.val())) { // Validation fail
                // Add error class
                email.addClass("error");
                // If inline error msg span has not been appended, add it
                if (email.parent().find(".inline-error").length === 0 && options.inlineErrors) {
                    email.parent().append('<span class="inline-error">' + emailErrorMsg + '</span>');
                }
                email.keyup(keyupval); // Add keyup validation
            } else {
                var formData = formName.serialize();

                // Add spinner and disable button
                formName.find('.subscribe').prop('disabled', true);
                formName.find('.subscribe').prepend('<i class="icon-spinner-6 spin"></i>');
                formName.find('.subscribe i').css({
                    'margin-right': '5px'
                });

                $.ajax({
                    type: "POST",
                    url: "php/subscribe.php",
                    data: formData,
                    success: function (html) {
                        // Prepend returned msg
                        formName.after(html);
                        formName.remove('.icon-spinner-6');
                        formName.slideUp(1000);
                    } // Success
                }); // Ajax

            } // Else
            return false;
        }); // Submit
    }; // Validation
})(jQuery);
