/*
Zorbix Contact Form validation for Zorbix Themes
Author: Zackary Allnutt
 */
(function($) {
    "use strict";

    $.fn.contactValidation = function(options) {
        $(this).each(function() {
            var defaults = {
                    inlineErrors: true,
                    formName: $(this),
                    nameErrorMsg: 'Error please provide your name',
                    emailErrorMsg: 'Please provide a valid email address..',
                    longerErrorMsg: 'Please leave a longer message',
                    name: 'John Doe',
                    email: 'example@example.com',
                    message: 'A test message',
                    autoSubmit: false,
                    debug: false
                },
                options_set = $.extend(defaults, options);
                new Validation(options_set);
        });
    };

    var Validation = function(options) {

        if( true === options.debug ) {
            console.log('Contact form debugging mode activated');
            $('#message').val(options.message);
            $('#email').val(options.email);
            $('#name').val(options.name);
        }

        var formName = options.formName;
        // Config
        var nameErrorMsg = options.nameErrorMsg,
            emailErrorMsg = options.emailErrorMsg,
            longerErrorMsg = options.longerErrorMsg;

        // On focus out set error if empty
        var nameVal = (function() {
            $(this).unbind('keyup');
            if ( $(this).val().length < 2) {
                $(this).addClass("error");
                // Add error if not there already
                if ($(this).parent().find(".error-name").length === 0 && options.inlineErrors) {
                    $(this).parent().prepend('<span class="inline-error error-name">' + nameErrorMsg + '</span>');
                }
                $(this).keyup(function() {
                    $(this).triggerHandler('focusout');
                });
            } else {
                // Validates so remove errors and keyup trigger
                $(this).removeClass("error");
                $(this).parent().children('span').remove('.error-name');
            }
        });

        // On focus off set error if shorter than 5
        // characters
        var messageVal = (function() {
            $(this).unbind('keyup');
            if ($(this).val().length < 5) {
                $(this).addClass("error");
                if ($(this).parent().find(".error-message").length === 0 && options.inlineErrors) {
                    $(this).parent().prepend('<span class="inline-error error-message">' + longerErrorMsg + '</span>');
                }
                $(this).keyup(function() {
                    $(this).triggerHandler('focusout');
                });
            } else {
                // Validates so remove errors
                $(this).parent().children('span').remove('.error-message');
                $(this).removeClass("error");

            }
        });

        // On focus out set error if is not a valid email
        var emailVal = (function() {
            $(this).unbind('keyup');
            if ( !IsEmail( $(this).val() ) ) {
                $(this).addClass("error");
                if ($(this).parent().find(".error-email").length === 0 && options.inlineErrors) {
                    $(this).parent().prepend('<span class="inline-error error-email">' + emailErrorMsg + '</span>');
                }
                $(this).keyup(function() {
                    $(this).triggerHandler('focusout');
                });
            } else {
                // Validates so remove errors
                $(this).parent().children('span').remove('.error-email');
                $(this).removeClass("error");
                $(this).unbind('keyup');
            }
        });


        // Validate Email
        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        formName.submit(function() {
            // Trigger focusout on form submit to check for errors
            $(this).find('#message').focusout(messageVal);
            $(this).find('#email').focusout(emailVal);
            $(this).find('#name').focusout(nameVal);

            $(this).find('#message').triggerHandler("focusout");
            $(this).find('#email').triggerHandler("focusout");
            $(this).find('#name').triggerHandler("focusout");

            // Testing data
            // $(this).find('#message').val("dsdsfs");
            // $(this).find('#email').val("focuslk@fsdfdsf.cd");
            // $(this).find('#name').val("focusol;'ld';ls;'dfut");

            // If no error send to sendForm() for php submitting
            if (!$('input').hasClass('error') && !$('textarea').hasClass('error')) {
                sendForm();
            }
            return false;
        });

        var formWrapper = formName.parent();
        var speed = 100; // Speed of slide animation

        // Send form to PHP
        function sendForm() {

            // Add spinner and disable button
            formName.find('#submit').attr('disabled', true);
            formName.find('#submit').prepend('<i class="fa fa-spinner spin"></i>');
            formName.find('#submit i').css({
                'margin-right': '5px'
            });

            $('.contact-error').slideUp(speed); // Hide previous attempt error message

            var data = {
                'action': 'sendmail',
                'formData': formName.serializeArray()
            };

            if( !zbx_settings.ajax_url ) {
                console.error('Url is not defined');
                return;
            }

            $.ajax({
                url: zbx_settings.ajax_url,
                data: data,
                success: function(html) {
                    var alertBox = $(html).filter('.alert.error'); // Get alert box if alerady one
                    if (alertBox.length === 0) {
                        // If no alert box already, add new
                        html = formWrapper.append(html);
                        $('.contact-success').css('display', 'none').slideDown();
                        formName.slideUp(1000);
                    } else { // If exists add to it.
                        // If already a error displayed add to existing div
                        // Else add new div
                        var contactErrorElem = $('.contact-error');
                        if (contactErrorElem.length !== 0) {
                            contactErrorElem.html(alertBox.html());
                            contactErrorElem.slideDown(speed);
                        } else {
                            $(formName).before(html);
                            contactErrorElem.css('display', 'none');
                            contactErrorElem.slideDown(speed);
                        }
                    }

                    // Remove spinner and hide form
                    formName.find('.spin').remove();
                    formName.find('#submit').attr('disabled', false);
                }
            });
            return false;
        } // End SendForm fnc

        if( true === options.debug && true === options.autoSubmit ) {
            $('#submit').trigger('click');
        }

    }; // End Validation fnc
})(jQuery);/**
 * Created by admin on 30/11/2015.
 */
