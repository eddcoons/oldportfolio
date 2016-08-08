(function () {
    tinymce.create('tinymce.plugins.zbx', {
        init: function (editor, url) {

            editor.addButton('shortcodes', {
                title: 'Zorbix',
                type: 'menubutton',
                icon: url + '/add.svg',
                image: url + '/add.svg',
                menu: [
                    {
                        text: 'Dash',
                        value: '<div class="dash centered"></div>&#8203;',
                        onclick: function () {
                            editor.execCommand('mceInsertContent', 0, this.value());
                        }
                    },
                    {
                        text: 'Dash Left',
                        value: '<div class="dash"></div>&#8203;',
                        onclick: function () {
                            editor.execCommand('mceInsertContent', 0, this.value());
                        }
                    }
                ]
            });

        }

    });
    // Register plugin
    tinymce.PluginManager.add('zbx', tinymce.plugins.zbx);
})();
