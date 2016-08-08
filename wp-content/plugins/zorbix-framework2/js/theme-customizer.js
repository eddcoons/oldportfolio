wp.customize('demo_select', function (value) {
    value.bind(function (newval, test) {
        if (newval) {

            // Confirmed
            if (!confirm( 'IMPORTANT: This will begin importing selected demo data, continue?')) {
                return;
            }

            var $ = jQuery;
            var urls = newval.toString().split("~");
            var ajax_url = urls['1'];
            var xml_url = urls['0'];

            $('body').prepend('<div class="alert alert-importer warning">Importing. This could take a few minuets.</div>');

            $.ajax({
                url: ajax_url,
                data: {
                    'action': 'zorbix_importer_ajax_callback',
                    'file': xml_url
                },
                success: function (data) {
                    // This outputs the result of the ajax request
                    $('body .alert-importer').remove();
                    $('body').prepend('<div class="alert alert-importer success">' + data + '<a class="alert-button" href="#"></a></div>');

                },
                error: function (errorThrown) {
                    $('body').prepend('<div class="alert alert-importer error">Something went wrong importing. Your server may have timed out in which case running again may complete the import. Otherwise you can import manually with the WordPress importer.</div>');
                    console.log(errorThrown);
                }
            });

        }

    });
});
