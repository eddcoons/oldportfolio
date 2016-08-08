    jQuery(document).ready(function ($) {
        var format_array;
        (function ($) {

            // ----------------------------------
            // --  Importer message  --
            // ----------------------------------
            $("input[name='importer_trigger']").on('change', function () {
                if ($(this).val() !== ' ') {
                    $('.zx_ajax_message').html($(this).val());
                    $('.zx_ajax_message').fadeIn();
                }
            });

            // $("input[value='demo_main']").trigger('click');

            /* Hide Unused Social Fields */
            var loadCSS;
            $("select[name='social_field_set']").on("click", function (e) {
                var social_field_set, social_field_urls;
                social_field_set = $(this).val();
                social_field_urls = $('#social_urls input');
                return $.each(social_field_urls, function () {
                    var url_field;
                    url_field = $(this).attr('name');
                    if ($.inArray(url_field, social_field_set) === -1) {
                        $(this).parent().parent().parent().hide();
                    } else {
                        return $(this).parent().parent().parent().show();
                    }
                });
            });
            $("select[name='social_field_set']").trigger('click');

            /* Url Loader */
            loadCSS = function (href) {
                var cssLink;
                cssLink = $("<link rel='stylesheet' type='text/css' href='" + href + "'>");
                return $("head").append(cssLink);
            };

        })(jQuery);

        /*
         * ----------------------------------------
         * - Project Post, show slider image metabox
         * - on slider layout select
         * ----------------------------------------
         */

        $("input[name='port[layout]'], input[name='port[seperate_image]'] ").change(function () {
            show_images_mb($(this).val());

        });

        function show_images_mb(value) {
            if (value === "slider" || $("input[name='port[layout]']:checked").val() === "lightbox" && $("input[name='port[seperate_image]']").is(':checked') || $("input[name='port[layout]']:checked").val() === "" && $("input[name='port[seperate_image]']").is(':checked')) {
                return $("#project-images").fadeIn();
            } else {
                return $("#project-images").fadeOut();
            }
        }

        // Set intial state
        show_images_mb($("input[name='port[layout]']:checked").val());

        /*
         * ----------------------------------------
         * --  Post Format Metabox Dependencies  --
         * ----------------------------------------
         */

        /* Posts with dependency */
        format_array = ['link', 'video', 'audio', 'quote', 'gallery'];

        /* All Hide Meta format boxes, show selected */
        $.each(format_array, function () {
            var element;
            element = this;
            var endBit = "_post";

            $("#" + element + endBit ).addClass("hidden");
            if ($("#post-format-" + element).is(":checked")) {
                return $("#" + element + endBit ).removeClass("hidden");
            }
        });

        /* If "Video" post format is selected, show the "Video Options" meta box */
        return $("#post-formats-select input").change(function () {
            return $.each(format_array, function () {

                var endBit = "_post";

                if ($("#post-format-" + this).is(":checked")) {
                    return $("#" + this + endBit ).removeClass("hidden");
                } else {
                    return $("#" + this + endBit ).addClass("hidden");
                }
            });
        });
    });

    jQuery(document).ready(function ($) {
        $(window).load(function ($) {
            var format = function vp_fontawesome_chooser_format(icon) {
                return '<span class="fontawesome"><i class="fa ' + icon.id + '"></i>' + icon.text + '</span>';
            };
            jQuery('.font-chooser').select2({
                templateResult: format,
                escapeMarkup: function (m) {
                    return m;
                },
                allowClear: true,
                placeholder: 'Choose an icon'
            });
            jQuery('.font-chooser').css('display', 'none');
        });
    });

