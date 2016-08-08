/*
 Zorbix Page Builder
 Version: 1.4
 */

require('jquery-ui-sortable');

$ = jQuery;

(function ($, window, document, undefined) {

    "use strict";

    $.fn.zbxtabs = function (options) {
        $(this).each(function () {
            var defaults = {
                    inlineErrors: true,
                    formName: $(this)
                },
                options = $.extend(defaults, options);
            new Tabs($(this), options);
        });
    }
    ;

    var Tabs = function (container, options) {
            var contents = $(container.find('.content'));
            var btnWrap = $(container.find('.trigger'));
            this.container = container;

            //container.append(btnWrap);

            if (btnWrap.find("a").length < 1) {
                btnWrap.wrapInner("<a href='#' />");
            }

            //btnWrap.wrapAll("<div class='tabs'></div>");

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

            btn.click(function (e) {
                e.preventDefault
                var contents = $(this).parent().data('container');
                contents = $('.' + contents);

                // Current Class
                container.find('a').removeClass('current');
                $(this).find('a').addClass('current');

                // Set height to current elements
                //container.css('minHeight', container.height());


                // Fade out current elements
                container.find('.content').fadeOut('slow').promise().done(
                    function () {
                        container.find(contents).stop().fadeIn(function () {
                        });
                    });

                return this;

            });

            return this;
        }
        ;

    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    }
    ;

    window.zbxbuilder = {


        init: function () {
            // Place initialization logic here
            // You already have access to the DOM element and
            // the options via the instance, e.g. this.element
            // and this.settings
            // you can add more functions like the one below and
            // call them like so: this.yourOtherFunction(this.element, this.settings).

            //this.get_content();

            jQuery(window).load(function () {
                zbxbuilder.editor_to_builder();
            });

            this.ajax = zbxbuilder_ajax; // BEFORE OTHER FUNCTIONS

            this.create_html();
            this.addSectionButton();
            this.enableElementEditButton();
            this.enableAttsButtonClick();
            this.convert_vc_to_zbx();
            this.id = -1;
            this.builder_obj = [];

            this.templates();

            // Get all registered shortcodes
            this.shortcodes = Object.keys(this.ajax.tags).join('|');

            zbxbuilder.toggle_builder_btn();

        },

        sc_filter: function () {
            $('#sc-filter').keyup(function (e) {
                var add_elemend_button = $('.zbx-add-stuff-popup .zbx-add-element');
                add_elemend_button.removeClass('show');
                var filtered = add_elemend_button.filter(function () {
                    var value = $('#sc-filter').val();
                    return $(this).text().toLowerCase().indexOf(value.toLowerCase()) > -1;
                }).addClass('show');
                add_elemend_button.not('.show').parent().fadeOut();
                add_elemend_button.filter('.show').parent().fadeIn();

            });
        },

        toggle_builder_btn: function () {
            var button = $('<a id="zbx-toggle-builder" href="#">Toggle Page Builder</a>');
            var $postdivrich = $('#postdivrich');
            $postdivrich.before(button);
            //$postdivrich.hide();
            $('#page-builder').hide();
            button.click(function () {
                $('#postdivrich').fadeToggle();
                $('#page-builder').fadeToggle();
            });
        },


        add_close_modal: function () {
            function closeMyModal(e) {

                // Again, an editor instance is expected, as upon closing .focus() is called on
                // wpLink.textarea, so we need to provide a jQuery object to .focus() on.
                wpLink.textarea = $('body');
                wpLink.close();

                window.mySpecialModalVariable = false;
                e.preventDefault ? e.preventDefault() : e.returnValue = false;
                e.stopPropagation();
            }

            // When the dialogue box's submit button is clicked...
            var $wp_link_button = $('#wp-link-submit');
            $wp_link_button.unbind('click');
            $wp_link_button.click(function (e) {

                var selectedItem = wpLink.getAttrs();

                if (!selectedItem.href) {
                    closeMyModal();
                }

                var joined = $.map(selectedItem, function (v) {
                    return (v) ? v : null
                }).join('||');

                $('.zbx-atts-form-wrap .link').next().val(joined);

                closeMyModal(e);
            });

            // When the user clicks the cancel button, close button, or overlay...
            $('#wp-link-cancel, #wp-link-close, #wp-link-backdrop').click(function (e) {

                // Do whatever's necessary, then...

                closeMyModal(e);
            });
        },


        get_content: function () {

            if ($.isFunction('tinymce')) {
                tinymce.init({
                    setup: function (ed) {
                        ed.on('init', function (args) {
                            console.debug(args.target.id);
                        });
                    }
                })
            }

            if (typeof tinymce != "undefined") {
                var editor = tinymce.get('content');
                if (editor && editor instanceof tinymce.Editor) {
                    var content = editor.getContent();
                    return content;
                }
                else {
                    return jQuery('textarea#content').val();
                }
            }
        },

        /* wp.shortcode.regex without the global flag: so can be used with .match and not exec */
        shortcode_reg: function (tag) {
            return new RegExp('\\[(\\[?)(' + tag + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)');
        },

        extracted: function (matches, passToLoop) {
            var passToLoop = passToLoop;
            var split_shortcode_reg = zbxbuilder.shortcode_reg(zbxbuilder.shortcodes);
            var shortcode_reg = wp.shortcode.regexp(zbxbuilder.shortcodes);
            if (null !== matches) {
                matches.forEach(function (element) {
                    var parent = this; // pass to loop datas
                    var sc = window.wp.shortcode.fromMatch(element.match(split_shortcode_reg));
                    sc.parentIndex = parent.ID;
                    sc.parentType = parent.type;
                    if (undefined !== sc.content) {
                        var matches = sc.content.match(shortcode_reg);

                        var passToLoop = {
                            ID: zbxbuilder.element(sc),
                            type: sc.tag
                        };

                        // don't pass content of the text shortcode, we don't want to create elements from shortcodes within
                        if (sc.tag !== 'text') {
                            zbxbuilder.extracted(matches, passToLoop);
                        }
                    }


                }, passToLoop);
            }
        },


        editor_to_builder: function () {

            // Empty everything out so we don't end up duplicating everything
            var $zorbix_drop_zone = jQuery('#zbx-drop-zone');
            $zorbix_drop_zone.css('height', $zorbix_drop_zone.outerHeight());
            $zorbix_drop_zone.html(' ');

            var content = this.get_content();
            var shortcode_reg = wp.shortcode.regexp(zbxbuilder.shortcodes);
            var split_shortcode_reg = zbxbuilder.shortcode_reg(zbxbuilder.shortcodes);
            var matches = content.trim().match(shortcode_reg);


            if (null === matches) {
                $zorbix_drop_zone.css('height', 'auto');
                return;
            }

            $.each(matches, function () {

                var sc = window.wp.shortcode.fromMatch(this.match(split_shortcode_reg));
                var passToLoop = {
                    ID: zbxbuilder.addSection(sc)
                };

                //sc = this.trim().match(split_shortcode_reg);
                sc = window.wp.shortcode.fromMatch(this.match(split_shortcode_reg));
                var matches = sc.content.trim().match(shortcode_reg);
                zbxbuilder.extracted(matches, passToLoop);
                passToLoop.type = sc.tag;

            });

            $zorbix_drop_zone.css('height', 'auto');
        },


        replace_tag: function (tag_name, new_name) {

            zbxbuilder.newContent = window.wp.shortcode.replace(tag_name, zbxbuilder.newContent, function (shortcode) {
                // If this codeblock has no code, strip it out.
                // Set up the codeblock with the parsed shortcode attrs.

                // return 'hello';

                return wp.shortcode.string({
                    tag: new_name,
                    content: shortcode.content,
                    attrs: shortcode.attrs
                });
            });
        },

        delete_tag: function (tag) {
            zbxbuilder.newContent = wp.shortcode.replace(tag, zbxbuilder.newContent, function (shortcode) {
                return shortcode.content;
            });

        },

        convert_vc_to_zbx: function () {
            $('#zbx-convert').click(function () {

                zbxbuilder.newContent = zbxbuilder.get_content();

                zbxbuilder.delete_tag('vc_column_inner');
                zbxbuilder.delete_tag('vc_row_inner');
                //
                zbxbuilder.replace_tag('vc_row', 'section');
                zbxbuilder.replace_tag('vc_column', 'column');
                zbxbuilder.replace_tag('vc_column_text', 'text');
                zbxbuilder.replace_tag('vc_single_image', 'image');
                zbxbuilder.newContent.replace(/css=".*?"/gmi, '');

                //var sc = window.wp.shortcode.fromMatch(this.match(split_shortcode_reg));
                zbxbuilder.write_content();
                zbxbuilder.editor_to_builder();
            });
        },


        create_id: function () {
            this.id += 1;
            return this.id;
        },

        create_html: function () {
            this.new_section = '<div class="zbx-section">' +
                '<i class="handle fa fa-arrows"></i>' +
                '<div class="zbx-buttons">' +
                '<a class="zbx-delete-section" href="#"><i class="fa fa-minus"></i></a>' +
                '<a href="#" class="zbx-edit-element"><i class="fa fa-cogs"></i></a>' +
                '<a href="#" class="zbx-copy"><i class="fa fa-copy"></i></a>' +
                '<a href="#" class="copy-shortcodes"><i class="fa fa-clipboard"></i></a>' +
                '<a class="zbx-add-element-open" data-type="zbx-section" href="#"><span class="fa fa-plus"></span></a>' +
                '<a class="zbx-add-snippet" href="#"><span class="fa fa-rocket"></span></a>' +
                '<a class="zbx-add-element" data-element="column" data-col="col-md-6" href="#">&frac12;</a>' +
                '<a class="zbx-add-element" data-element="column" data-col="col-md-4" href="#">&frac13;</a>' +
                '<a class="zbx-add-element" data-element="column" data-col="col-md-3" href="#">&frac14;</a>' +
                '</div>' +
                '<div class="zbx-drag-zone row"></div>' +
                '</div>';
            this.new_column = '<div class="zbx-column">' +
                '<div class="zbx-buttons">' +
                '<a class="zbx-add-element-open" data-type="zbx-section" href="#"><span class="fa fa-plus"></span></a>' +
                '<a href="#" class="zbx-delete-element"><i class="fa fa-minus"></i></a>' +
                '<a href="#" class="zbx-edit-element"><i class="fa fa-cogs"></i></a>' +
                '<a href="#" class="zbx-copy"><i class="fa fa-copy"></i></a>' +
                '</div>' +
                '<h2>column</h2>' +
                '<div class="zbx-drag-zone"></div>' +
                '</div>';
            this.new_nested_column = '<div class="zbx-nested-column">' +
                '<div class="zbx-buttons">' +
                '<a class="zbx-add-element-open" data-type="zbx-section" href="#"><span class="fa fa-plus"></span></a>' +
                '<a href="#" class="zbx-delete-element"><i class="fa fa-minus"></i></a>' +
                '<a href="#" class="zbx-edit-element"><i class="fa fa-cogs"></i></a>' +
                '<a href="#" class="zbx-copy"><i class="fa fa-copy"></i></a>' +
                '</div>' +
                '<h2>nested column</h2>' +
                '<div class="zbx-drag-zone"></div>' +
                '</div>';
            this.new_element = '<div class="zbx-element">' +
                '<div class="zbx-buttons">' +
                '<a href="#" class="zbx-delete-element"><i class="fa fa-minus"></i></a>' +
                '<a href="#" class="zbx-edit-element"><i class="fa fa-cogs"></i></a>' +
                '<a href="#" class="zbx-copy"><i class="fa fa-copy"></i></a>' +
                '</div>' +
                '<h3>ELEMENT</h3>' +
                '</div>';
            this.new_inner_container = '<div class="zbx-column">' +
                '<div class="zbx-buttons">' +
                '<a href="#" class="zbx-delete-element"><i class="fa fa-minus"></i></a>' +
                '<a href="#" class="zbx-edit-element"><i class="fa fa-cogs"></i></a>' +
                '<a href="#" class="zbx-copy"><i class="fa fa-copy"></i></a>' +
                '</div>' +
                '<h2>row</h2>' +
                '<div class="zbx-drag-zone"></div>' +
                '</div>';
        },

        element_delete_button: function () {
            var delete_Button = $('.zbx-delete-element, .zbx-delete-section');
            delete_Button.unbind();
            delete_Button.click(function (e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete?')) {
                    return;
                }
                var section = $(this).parent().parent('.zbx-element, .zbx-section, .zbx-column, .zbx-nested-column, .zbx-row');
                section.remove();
                zbxbuilder.update_content();
            });
        },

        enableElementEditButton: function (e) {
            $('body').on('click', '.zbx-edit-element', function (e) {
                e.preventDefault();
                var $body = $('body');
                var element = $(this).parent().parent();
                var sc = element.data('sc');
                sc = jQuery.parseJSON(sc);
                sc.index = element.index();
                var model = $('<div class="builder-modal"></div>');
                model.data('element', element);
                $body.append(model);
                zbxbuilder.getForm(sc);
            })
        },

        enableAttsButtonClick: function () {
            var $body = $('body');

            var $zbx_edit_section = $('.zbx-edit-section');
            $zbx_edit_section.on('click', function (e) {
                e.preventDefault();
                var sc = $(this).parent().data('sc');
                sc.index = $(this).parent().index();
                var model = $('<div class="builder-modal"></div>');
                model.data('element', $(this).parent());
                $('body').append(model);
                zbxbuilder.getForm(sc);
            });

        },

        formatParagraphs: function (text) {
            text = text.replace(/(<br>)|(<br \/>)/g, "\n").trim();
            text = text.replace(/(<p>)|(<\/p>)/g, "\n").trim();
            return '<p>' + text.split(/\n+/).join('</p>\n<p>') + '</p>';
        },


        form_js: function (builder) {

            zbxbuilder.tabs(); // Must preceed other field JS

            var format = function skyline_fontawesome_chooser_format(icon) {
                return '<span class="fontawesome"><i class="fa ' + icon.id + '"></i>' + icon.text + '</span>';
            };

            jQuery('.iconpicker').select2({
                templateResult: format,
                escapeMarkup: function (m) {
                    return m;
                },
                allowClear: true,
                placeholder: 'Choose an icon'
            });
            //jQuery('.iconpicker').val(null).trigger("change"); // Trigger clear as doesn't load clear (v4.0.1)

            //palettes: ['#f9f9f9', '#2B2B2B', '#f5f5f5', '#009EC6', '#444', '#000', '#fff'],

            $('.color-picker').iris({
                palettes: ['#2B2B2B', '#f5f5f5', '#009EC6', '#444', '#000', '#fff']
            });

            zbxbuilder.link_field();
            zbxbuilder.add_media_button();


            // Editor
            var $zbx_editor = $('#zbx-editor');
            if (0 < $zbx_editor.length) {
                tinymce.EditorManager.execCommand('mceRemoveEditor', true, 'builder'); // Remove tinymce before moving ( for chrome )
                var EDITOR = jQuery('.hidden-editor-container #wp-builder-wrap').detach();
                var contents = $zbx_editor.val();

                // Replace p tags with line breaks as p tags get messed by because of tinymce wrapping shortcodes and adding empty p tags
                contents = contents.replace(/(<br>)|(<br \/>)|(<p>)|(<\/p>)/g, "\n").trim();
                contents = zbxbuilder.formatParagraphs(contents);

                $zbx_editor.hide();
                $('.field-wrap-editor .zbx-input').append(EDITOR);
                tinymce.EditorManager.execCommand('mceAddEditor', true, 'builder'); // Reinit editor
                tinymce.get('builder').setContent(contents);
            }

        },


        link_field: function () {
            $('.zbx-atts-form-wrap .link').click(function (e) {

                // This can be any value. Its sole purpose is to let us know if the modal that's open
                // is the default or a custom one.
                window.mySpecialModalVariable = e.target.dataset.target;

                // This must have a value because the link dialogue expects it to
                // (a wp_editor instance, actually, but that part doesn't matter here...as long as it has a value).
                //wpActiveEditor = true;

                // Open the link popup.
                wpLink.open();

                zbxbuilder.add_close_modal();

                // So no other action is triggered.
                return false;
            });

        },

        add_media_button: function () {

            var _custom_media = true,
                _orig_send_attachment = wp.media.editor.send.attachment;

            $('.zbx-media-btn').on('click', function () {
                var $button = $(this);
                //var id = button.attr('id').replace('_button', '');
                _custom_media = true;
                $

                // Empty val
                $button.prev().val('');
                // Remove prevously appended children
                $button.parent().find('img').remove();

                wp.media.editor.send.attachment = function (props, attachment) {
                    if (_custom_media) {
                        if ($button.prev().hasClass('image_multi')) {
                            if ('' !== $button.prev().val()) {
                                var append = ',' + attachment.id;
                            } else {
                                var append = attachment.id;
                            }
                            $button.prev().val($button.prev().val() + append);
                            $button.siblings('.images').append('<img data-id="' + attachment.id + '" src="' + attachment.sizes.thumbnail.url + '">');
                            $button.siblings('.images').sortable({
                                start: function (e, ui) {
                                    ui.item.data('', ui.item.index());
                                    //$(".item-drop").text("DROP HERE?");
                                },
                                //placeholder: "item-drop",
                                tolerance: "pointer",
                                stop: function (e, ui) {
                                    var idArray = new Array();
                                    $(e.target).find('img').each(function () {
                                        var id = $(this).data('id');
                                        idArray.push(id);
                                    });
                                    jQuery(e.target).siblings('.image_multi').val(idArray.join())
                                }
                            });
                        } else {
                            $button.prev().val(attachment.id);
                        }

                    } else {
                        return _orig_send_attachment.apply(this, [props, attachment]);
                    }
                };

                wp.media.editor.open($button);
                return false;
            });

            $('.add_media').on('click', function () {
                _custom_media = false;
            });
        },

        add_form: function (form) {
            var builder = $('.builder-modal');
            builder.html(form);
            //
            builder.fadeIn().promise()
                .done(function () {

                    zbxbuilder.form_js(builder);
                });

            $('.zbx-atts-form').submit(zbxbuilder.formSubmit);
            $('#zbx-builder-cancel').click(function (e) {
                e.preventDefault();
                zbxbuilder.put_wpeditor_back();
                $('.builder-modal').remove();
            });
        },

        tabs: function () {
            var fields = jQuery('.field-wrap').remove();

            var $zbx_atts_form = $('.zbx-atts-form');
            var $zbx_atts_form_wrap = $('.zbx-atts-form-wrap');

            var $tabs = $('<div class="tabs">');
            $zbx_atts_form.prepend($tabs);

            fields.each(function () {
                var group = $(this).data('group');
                if (0 === $zbx_atts_form_wrap.find('.tab-heading-' + group).length) {
                    $('.zbx-atts-form #zbx-builder-submit').before('<div class="content tab-body-' + group + '"></div>');
                    $tabs.append('<h2 class="trigger tab-heading-' + group + '" data-container="tab-body-' + group + '">' + group + '</h2>');
                }
                $zbx_atts_form.find('.tab-body-' + group).append($(this))
            });
            jQuery('.zbx-atts-form').zbxtabs();

        },

        put_wpeditor_back: function () {
            // Put the editor back where we got it from ready for next form load (only one editor of a name can exist at a time);

            if (0 !== $('#zbx-editor').length) {
                var EDITOR = jQuery('#wp-builder-wrap').detach();
                $('.hidden-editor-container').append(EDITOR);
                tinymce.execCommand('mceRemoveEditor', false, 'builder');
                tinymce.execCommand('mceAddEditor', false, 'builder');
                $('#builder-html').trigger('click'); // WE need to be on the visual tab for reinitialisation
                $('#builder-tmce').trigger('click'); // WE need to be on the visual tab for reinitialisation
            }
        }
        ,

        get_form_data: function () {
            //$('#builder-tmce').trigger('click');

            var $zbx_editor = $('#zbx-editor');
            if (0 !== $zbx_editor.length) {
                // Copy editor contents to textarea for form data retrieval
                if (null !== tinymce.get('builder')) {
                    if (true === jQuery('#wp-builder-wrap').hasClass('tmce-active')) {
                        var editorContents = tinymce.get('builder').getContent();
                    } else {
                        var editorContents = $('#builder').val();
                    }
                } else {
                    var editorContents = $('#builder').val();

                }

                editorContents = zbxbuilder.formatParagraphs(editorContents);

                $zbx_editor.val(editorContents);

                zbxbuilder.put_wpeditor_back()
            }

            return $(".zbx-atts-form input, .zbx-atts-form textarea, .zbx-atts-form select, .zbx-atts-form button").not('#zbx-media-btn').filter(function () {
                return !!this.value;
            }).serializeObject();
        }
        ,

        formSubmit: function (event) {
            event.preventDefault();

            var builder = $('.builder-modal');
            var element = builder.data('element');

            var data = zbxbuilder.get_form_data();

            var sc = element.data('sc');
            sc = jQuery.parseJSON(sc);
            //             sc.attrs = wp.shortcode.attrs( data );
            sc.attrs = {
                named: data,
                numeric: []
                // This must exists for wp.shortcode.string
            };

            sc.content = (data.content) ? data.content : '';

            // Stop the content creating an attribute
            delete sc.attrs.named.content;

            sc = JSON.stringify(sc);
            element.data('sc', sc);
            $('.builder-modal').remove();

            zbxbuilder.update_content();
            zbxbuilder.editor_to_builder();

            // Change col size form size att for columns
            if (sc.tag === 'column' || 'nested-column' === sc.tag) {
                element.removeClass(function (index, css) {
                    return (css.match(/(^|\s)col-\S+/g) || []).join(' ');
                });
                element.addClass(sc.attrs.named.size);
            }

        }
        ,
        removeEmptyStrings: function (obj) {
            for (var key in obj) {

                // value is empty string
                if (obj[key] === '') {
                    delete obj[key];
                }

                // value is array with only emtpy strings
                if (obj[key] instanceof Array) {
                    var empty = true;
                    for (var i = 0; i < obj[key].length; i++) {
                        if (obj[key][i] !== '') {
                            empty = false;
                            break;
                        }
                    }

                    if (empty)
                        delete obj[key];
                }

                // value is object with only empty strings or arrays of empty strings
                if (typeof obj[key] === "object") {
                    obj[key] = self.removeEmptyStrings(obj[key]);

                    var hasKeys = false;
                    for (var objKey in obj[key]) {
                        hasKeys = true;
                        break;
                    }

                    if (!hasKeys)
                        delete obj[key];
                }
            }

            return obj;
        }
        ,

        getForm: function (sc) {
            // We'll pass this variable to the PHP function example_ajax_request
            // This does the ajax request
            var newSc =
            {
                tag: sc.tag,
                attrs: sc.attrs.named
            };

            // Content is sent seperately as JSON decoder may choke on it.
            // Without the map, we don't know if the content is needed,
            // So we must send it anyway
            $.ajax({
                url: zbxbuilder_ajax.url,
                data: {
                    'action': 'example_ajax_request',
                    'content': JSON.stringify(sc.content),
                    'sc': JSON.stringify(newSc)// Needs to go seperately or json_debocode chokes
                },
                success: function (data) {
                    // This outputs the result of the ajax request

                    zbxbuilder.add_form(data);
                },
                error: function (errorThrown) {

                    //
                }
            });
        }
        ,

        copyBlock: function () {
            var $zbx_copy = $('.zbx-copy');
            $zbx_copy.unbind();
            $zbx_copy.click(function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();


                var element = $(this).parent().parent();
                element.clone(true).insertAfter(element);

                zbxbuilder.element_delete_button();
                zbxbuilder.copyBlock();
                zbxbuilder.update_content();
                zbxbuilder.editor_to_builder(); // Forces new elements as cloned elements don't work with sortable
                zbxbuilder.sectionSortable();
                zbxbuilder.sortable();
            });
        },


        addElementButton: function () {

            var $zbx_add_element_open = $('.zbx-add-element-open');
            $zbx_add_element_open.unbind();
            $zbx_add_element_open.click({
                fnc: this
            }, function (e) {

                e.preventDefault();
                var popupElement = $('.zbx-add-stuff-popup');
                popupElement.fadeIn();
                e.data.fnc.sc_filter();

                if ($(this).parent().hasClass('zbx-buttons')) {
                    var parent = $(this).parent().parent();
                } else {
                    var parent = $(this).parent();
                }
                popupElement.data('parentIndex', parent);

                popupElement.find('.close').click(function () {
                    popupElement.remove();
                })
            });

            var $zbx_add_element = $('.zbx-add-element');
            $zbx_add_element.unbind();
            $zbx_add_element.click({
                fnc: this
            }, function (e) {

                e.preventDefault();

                var parentIndex = $(this).parent().parent().parent().parent().data('parentIndex');

                if (undefined === parentIndex) {
                    parentIndex = $(this).parent().parent();
                }

                var sc = {
                    tag: $(this).data('element'),
                    attrs: '',
                    parentIndex: parentIndex,
                    parentType: 'section'// @todo change me
                };

                if ('column' === sc.tag) {
                    sc.attrs = wp.shortcode.attrs('size=' + $(this).data('col'));
                }

                $('.zbx-add-stuff-popup').fadeOut();

                zbxbuilder.element(sc);

                zbxbuilder.update_content();
            });
        },

        element: function (sc) {

            var element = sc.tag,
                fnc = zbxbuilder,
                content = sc.content,
                icon = 'fa fa-arrows',
                col_class = '',
                new_element = '';

            // we are only interested in the contents of shortcodes
            sc.content = '';

            if ('column' === sc.tag) {
                new_element = $(fnc.new_column);
                if (undefined === sc.attrs.named.size) {
                    col_class = 'col-lg-12 col-xs-12';
                } else {
                    col_class = sc.attrs.named.size + ' col-xs-12';
                }
                element += ': <span>' + col_class.replace(/col-/g, '').replace(' ', ', ') + '</span>';
                new_element.addClass(col_class);
            } else if ('nested-column' === sc.tag) {
                new_element = $(fnc.new_nested_column);
            } else if ('container' === sc.tag || 'row' === sc.tag || 'selector' === sc.tag) {
                new_element = $(fnc.new_inner_container);
                new_element.addClass('col-lg-12');
            } else {
                new_element = $(fnc.new_element);
                if (null !== zbxbuilder.ajax.maps[sc.tag] && undefined !== zbxbuilder.ajax.maps[sc.tag]) {
                    icon = zbxbuilder.ajax.maps[sc.tag]['icon'];
                }
                sc.content = content;
            }

            // Create a new unique ID
            var newElementId = fnc.create_id();

            //var sectionIndex = fnc.scope.index;
            var parentDragZone = sc.parentIndex.children('.zbx-drag-zone');

            //var parentDragZone = $('#zbx-drop-zone').find('.zbx-' + sc.parentType + ' > .zbx-drag-zone').eq(sectionIndex);

            parentDragZone.append(new_element);

            // Get name label from tag
            var name = sc.tag;
            if (null !== zbxbuilder.ajax.maps[sc.tag] && undefined !== zbxbuilder.ajax.maps[sc.tag]) {
                name = zbxbuilder.ajax.maps[sc.tag]['name'];
            }
            new_element.attr('id', newElementId);
            new_element.find('h3').html(name);
            new_element.find('h2').html(name);

            // Add icon handel to builder element
            new_element.prepend('<i class="handle ' + icon + '"></i>');

            // Creating element heading
            if (sc.hasOwnProperty('attrs') && sc.attrs.hasOwnProperty('named') && sc.attrs.named['heading']) {
                var heading = sc.attrs.named['heading'];
                new_element.append('<h4>' + heading + '</h4>');
            }

            if (sc.hasOwnProperty('attrs.named')) {
                sc.attrs.named = zbxbuilder.removeEmptyStrings(sc.attrs.named);
            }

            sc = JSON.stringify(sc);
            new_element.data('sc', sc);

            zbxbuilder.sortable();

            fnc.element_delete_button();
            zbxbuilder.copyBlock();
            zbxbuilder.addElementButton();

            return new_element;

        }
        ,

        sectionSortable: function () {
            $('#zbx-drop-zone').sortable({
                start: function (e, ui) {
                    // creates a temporary attribute on the element with the old index
                    ui.item.data('previndex', ui.item.index());
                    $(".item-drop").text("DROP HERE?");

                },
                placeholder: "item-drop",
                tolerance: "pointer",
                cursor: "move",
                handle: ".handle",
                //connectWith: '.zbx-section .zbx-drag-zone ',
                stop: function (e, ui) {


                    zbxbuilder.update_elements(e, ui);
                    if ('sortstop' === e.type) {

                    }
                }
            });
        }
        ,

        sortable: function () {

            $('.zbx-drag-zone').sortable({
                start: function (e, ui) {
                    // creates a temporary attribute on the element with the old index
                    ui.item.data('previndex', ui.item.index());
                    $(".item-drop").text("DROP HERE?");

                },
                handle: ".handle",
                placeholder: "item-drop",
                cursor: "move",
                tolerance: "pointer",
                connectWith: '.zbx-section .zbx-drag-zone ',
                stop: function (e, ui) {


                    zbxbuilder.update_elements(e, ui);
                    if ('sortstop' === e.type) {

                    }
                }
            });
        }
        ,

        update_elements: function (event, ui) {

            var newParentIndex = ui.item.parent().parent().data('index');

            // update parent id
            ui.item.data('parentIndex', newParentIndex);

            window.zbxbuilder.update_content();
        }
        ,

        update_sections: function (event, ui) {

            var newIndex = ui.item.index();
            var oldIndex = ui.item.data('previndex');

            window.zbxbuilder.moveIndex(window.zbxbuilder.builder_obj, oldIndex, newIndex);

            window.zbxbuilder.update_content();
        }
        ,


        moveIndex: function (array, fromIndex, toIndex) {
            array.splice(toIndex, 0, array.splice(fromIndex, 1)[0]);
            return array;
        }
        ,

        innerShortcode: function (element) {


            var containedContent = '';
            var content = '';

            // Illeterate over each contained column
            // Get content
            $(element).children('.zbx-drag-zone').children().each(function () {

                // Get the shortcode object for the child
                var sc = $.parseJSON($(this).data('sc'));


                // Runs through contained columns and atts to content
                containedContent = zbxbuilder.innerShortcode(this);

                // if contained content has been created add it to the shortcode
                if ('' !== containedContent && undefined !== containedContent) {
                    sc.content = containedContent;
                }

                content += zbxbuilder.shortcode_from_obj(sc);

            });

            return content;

            // Needs to return string sc
        }
        ,

        copytext: function (text) {
            var textField = document.createElement('textarea');
            textField.innerText = text;
            document.body.appendChild(textField);
            textField.select();
            document.execCommand('copy');
            $(textField).remove();
        }
        ,

        copy_section: function () {
            $('.zbx-section .copy-shortcodes').click(function () {
                var section = $(this).parent().parent();
                var sc = section.data('sc');
                sc = $.parseJSON(sc);

                sc.content = zbxbuilder.innerShortcode(section);
                var result = zbxbuilder.shortcode_from_obj(sc);

                zbxbuilder.copytext(result);
                zbxbuilder.editor_to_builder(); // Forces new elements as cloned elements don't work with sortable
                zbxbuilder.sectionSortable();
                zbxbuilder.sortable();
            });
        }
        ,


        html_to_shortcodes: function () {
            zbxbuilder.newContent = '';

            // Sections
            $('.zbx-section').each(function () {

                var sc = $(this).data('sc');
                sc = $.parseJSON(sc);

                sc.content = zbxbuilder.innerShortcode(this);

                zbxbuilder.newContent += zbxbuilder.shortcode_from_obj(sc);
            });
        }
        ,

        builder_obj_to_shortcodes: function () {

            this.shortcodes = '';
            var fnc = this;

            wp.html.string();

            if (undefined !== window.zbxbuilder.builder_obj) {
                $.each(this.builder_obj, function () {
                    var children = '';
                    if ($.isArray(this.children)) {
                        $.each(this.children, function () {
                            children += fnc.shortcode_from_obj(this);
                        });
                    }
                    this.content = children;
                    fnc.shortcodes += fnc.shortcode_from_obj(this);
                });
            }

            return this.shortcodes;
        }
        ,

        shortcode_from_obj: function (sc) {
            //             sc =  $.parseJSON(sc);
            return wp.shortcode.string(sc);
        }
        ,


        addSectionButton: function () {
            $('.zbx-add-section').click({
                fnc: this
            }, function (e) {
                e.preventDefault();

                var sc = {
                    tag: $(this).data('tag'),
                    attrs: ''
                };

                zbxbuilder.addSection(sc)
            });
        }
        ,

        addSection: function (sc) {
            var fnc = zbxbuilder;

            var new_section = $(fnc.new_section);
            var newSectionId = fnc.create_id();

            // Add heading
            var name = sc.tag;
            name += ( undefined !== sc.attrs.named && undefined !== sc.attrs.named.type ) ? ': <span>' + sc.attrs.named.type + '</span>' : '';
            new_section.prepend('<h2>' + name + '</h2>');

            sc = JSON.stringify(sc);
            new_section.data('sc', sc);
            var $zbx_drop_zone = $('#zbx-drop-zone');
            $zbx_drop_zone.append(new_section);

            var newSectionIndex = fnc.builder_obj.push({
                    id: newSectionId,
                    tag: sc.tag,
                    content: '',
                    children: []
                }) - 1;

            fnc.scope = {
                type: 'section',
                index: newSectionIndex
            };
            new_section.data('index', newSectionIndex);
            new_section.find('.zbx-add-element-open').data('parent-id', newSectionIndex);


            $zbx_drop_zone.sortable({
                //update: fnc.update_sections,
                handle: ".handle",
                start: function (e, ui) {
                    // creates a temporary attribute on the element with the old index
                    ui.item.data('previndex', ui.item.index());
                }
            });

            // Refresh sortable to make new section draggable
            $zbx_drop_zone.sortable('toArray');

            fnc.addElementButton();

            zbxbuilder.sortable();

            zbxbuilder.copy_section();
            zbxbuilder.element_delete_button();
            $('.zbx-add-snippet').click(this.snippet_click);

            return new_section;
        }
        ,

        sortables_to_array: function () {
            //$('#zbx-drop-zone').sortable();
        }
        ,

        write_content: function () {
            if (typeof tinymce != "undefined" && undefined !== zbxbuilder.newContent) {
                var editor = tinymce.get('content');
                if (editor && editor instanceof tinymce.Editor) {
                    editor.setContent(zbxbuilder.newContent);
                    var zorbixSavedContent = editor.save({
                        no_events: true
                    });
                }
                else {
                    jQuery('textarea#content').val(zbxbuilder.newContent);
                }
            }
        }
        ,

        update_content: function () {
            zbxbuilder.html_to_shortcodes();
            this.write_content();
        },

        templates_process: function () {
            var tabs = zbxbuilder.ajax.templates;
            $.each(tabs, function (key, value) {
                var templates_json = $.parseJSON(value);
                var array = [];
                $.each(templates_json, function (key, value) {
                    array.push({v: value, k: key});
                });
                tabs[key] = array;
            });

            zbxbuilder.ajax.tabs = tabs;
        },

        snippets_process: function () {
            var tabs = zbxbuilder.ajax.snippets;
            $.each(tabs, function (key, value) {
                var templates_json = $.parseJSON(value);
                var array = [];
                $.each(templates_json, function (key, value) {
                    array.push({v: value, k: key});
                });
                tabs[key] = array;
            });

            zbxbuilder.ajax.snippits = tabs;
        },


        template_click: function () {

            var model = $('<div class="builder-modal"></div>');
            var inner = $('<div class="inner"><h2>Add template</h2><a href="#" class="close"><i class="fa fa-times-circle-o close"></i></a></div>');
            $('#page-builder').append(model);
            model.append(inner);

            var tabs = zbxbuilder.ajax.tabs;

            var $tabs = $('<div class="tabs">');
            inner.append($tabs);

            $.each(tabs, function (name, templates) {
                var id = name.replace(' ', '_');
                $tabs.append('<h2 class="trigger tab-heading-' + id + '" data-container="tab-body-' + id + '">' + name + '</h2>');

                var container = $('<div class="content tab-body-' + id + '"></div>');
                $(inner).append(container);

                jQuery.each(templates, function (key, val) {
                    var name = val.k;
                    var id = val.k.replace(/\s/g, '-').toLowerCase().replace(/---/g, '-');
                    var button = $('<a href="#" class="template-btn">' + name + '</a>');
                    var imgSrc = zbxbuilder.ajax.templateImagesUrl + id + '.jpg';
                    var $img = $('<img/>');

                    $img.load(imgSrc, function(response, status, xhr) {
                        if (status == "success") {
                            $(this).attr('src', imgSrc);
                            button.append($img);
                        }
                    });

                    button.data('template', val.v);
                    container.append(button);
                    button.wrap('<div class="col-md-4"></div>');
                    model.fadeIn();
                });
            });


            jQuery('.builder-modal .inner').zbxtabs();

            model.find('.close').click(function () {
                model.remove();
            });

            $('.template-btn').click(function (e) {
                e.preventDefault;
                zbxbuilder.newContent = zbxbuilder.get_content() + $(this).data('template');
                zbxbuilder.write_content();
                zbxbuilder.editor_to_builder();
                zbxbuilder.sectionSortable();
                zbxbuilder.sortable();
                model.remove();
                return false;
            });
            return false;
        },

        snippet_click: function () {

            var $section = $(this).parent().parent()

            var model = $('<div class="builder-modal"></div>');
            var inner = $('<div class="inner"><h2>Add template</h2><a href="#" class="close"><i class="fa fa-times-circle-o close"></i></a></div>');
            $('#page-builder').append(model);
            model.append(inner);

            var tabs = zbxbuilder.ajax.snippits;

            var $tabs = $('<div class="tabs">');
            inner.append($tabs);

            $.each(tabs, function (name, templates) {
                var id = name.replace(/\s/g, '_');
                $tabs.append('<h2 class="trigger tab-heading-' + id + '" data-container="tab-body-' + id + '">' + name + '</h2>');

                var container = $('<div class="content tab-body-' + id + '"></div>');
                $(inner).append(container);

                jQuery.each(templates, function (key, val) {
                    var id = val.k;
                    var name = val.k.replace(/\-/g, ' ');
                    var button = $('<a href="#" class="snippet-btn"></a>');
                    var imgSrc = zbxbuilder.ajax.snippetImagesUrl + id + '.svg';
                    button.append('<img src="' +  imgSrc + '"/>');
                    button.data('template', val.v);
                    container.append(button);
                    button.wrap('<div class="col-md-3"></div>');
                    model.fadeIn();
                });
            });


            jQuery('.builder-modal .inner').zbxtabs();

            model.find('.close').click(function () {
                model.remove();
            });

            $('.snippet-btn').click(function (e) {
                e.preventDefault;

                var content = $(this).data('template');
                var shortcode_reg = wp.shortcode.regexp(zbxbuilder.shortcodes);
                var split_shortcode_reg = zbxbuilder.shortcode_reg(zbxbuilder.shortcodes);
                var matches = content.trim().match(shortcode_reg);
                var passToLoop = {
                    ID: $section
                };
                zbxbuilder.extracted(matches, passToLoop);
                zbxbuilder.update_content();
                model.remove();
                return false;
            });
            return false;
        },

        templates: function () {
            this.templates_process();
            this.snippets_process();
            $('#add-template').click(this.template_click);
        },


    }
    ;

    window.zbxbuilder.init();


})(jQuery, window, document);
