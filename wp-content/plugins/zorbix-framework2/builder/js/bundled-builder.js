/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!******************!*\
  !*** multi main ***!
  \******************/
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(/*! ./zorbix-framework-dev/zorbix-framework2/builder/src-js/builder.js */1);


/***/ },
/* 1 */
/*!**************************************************************************!*\
  !*** ./zorbix-framework-dev/zorbix-framework2/builder/src-js/builder.js ***!
  \**************************************************************************/
/***/ function(module, exports, __webpack_require__) {

	/*
	 Zorbix Page Builder
	 Version: 1.4
	 */
	
	__webpack_require__(/*! jquery-ui-sortable */ 2);
	
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


/***/ },
/* 2 */
/*!********************************************!*\
  !*** jquery-ui-sortable (bower component) ***!
  \********************************************/
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(/*! ././jquery-ui-sortable.min.js */ 3);
	module.exports = __webpack_require__(/*! ././jquery-ui-sortable.js */ 4);

/***/ },
/* 3 */
/*!***********************************************************************!*\
  !*** ./bower_components/jquery-ui-sortable/jquery-ui-sortable.min.js ***!
  \***********************************************************************/
/***/ function(module, exports) {

	/*! http://jqueryui.com
	* Includes: jquery.ui.core.js, jquery.ui.widget.js, jquery.ui.mouse.js, jquery.ui.sortable.js
	* Copyright 2013 jQuery Foundation and other contributors; Licensed MIT */
	
	(function(e,t){function i(t,i){var s,a,o,r=t.nodeName.toLowerCase();return"area"===r?(s=t.parentNode,a=s.name,t.href&&a&&"map"===s.nodeName.toLowerCase()?(o=e("img[usemap=#"+a+"]")[0],!!o&&n(o)):!1):(/input|select|textarea|button|object/.test(r)?!t.disabled:"a"===r?t.href||i:i)&&n(t)}function n(t){return e.expr.filters.visible(t)&&!e(t).parents().addBack().filter(function(){return"hidden"===e.css(this,"visibility")}).length}var s=0,a=/^ui-id-\d+$/;e.ui=e.ui||{},e.extend(e.ui,{version:"1.10.3",keyCode:{BACKSPACE:8,COMMA:188,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,NUMPAD_ADD:107,NUMPAD_DECIMAL:110,NUMPAD_DIVIDE:111,NUMPAD_ENTER:108,NUMPAD_MULTIPLY:106,NUMPAD_SUBTRACT:109,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SPACE:32,TAB:9,UP:38}}),e.fn.extend({focus:function(t){return function(i,n){return"number"==typeof i?this.each(function(){var t=this;setTimeout(function(){e(t).focus(),n&&n.call(t)},i)}):t.apply(this,arguments)}}(e.fn.focus),scrollParent:function(){var t;return t=e.ui.ie&&/(static|relative)/.test(this.css("position"))||/absolute/.test(this.css("position"))?this.parents().filter(function(){return/(relative|absolute|fixed)/.test(e.css(this,"position"))&&/(auto|scroll)/.test(e.css(this,"overflow")+e.css(this,"overflow-y")+e.css(this,"overflow-x"))}).eq(0):this.parents().filter(function(){return/(auto|scroll)/.test(e.css(this,"overflow")+e.css(this,"overflow-y")+e.css(this,"overflow-x"))}).eq(0),/fixed/.test(this.css("position"))||!t.length?e(document):t},zIndex:function(i){if(i!==t)return this.css("zIndex",i);if(this.length)for(var n,s,a=e(this[0]);a.length&&a[0]!==document;){if(n=a.css("position"),("absolute"===n||"relative"===n||"fixed"===n)&&(s=parseInt(a.css("zIndex"),10),!isNaN(s)&&0!==s))return s;a=a.parent()}return 0},uniqueId:function(){return this.each(function(){this.id||(this.id="ui-id-"+ ++s)})},removeUniqueId:function(){return this.each(function(){a.test(this.id)&&e(this).removeAttr("id")})}}),e.extend(e.expr[":"],{data:e.expr.createPseudo?e.expr.createPseudo(function(t){return function(i){return!!e.data(i,t)}}):function(t,i,n){return!!e.data(t,n[3])},focusable:function(t){return i(t,!isNaN(e.attr(t,"tabindex")))},tabbable:function(t){var n=e.attr(t,"tabindex"),s=isNaN(n);return(s||n>=0)&&i(t,!s)}}),e("<a>").outerWidth(1).jquery||e.each(["Width","Height"],function(i,n){function s(t,i,n,s){return e.each(a,function(){i-=parseFloat(e.css(t,"padding"+this))||0,n&&(i-=parseFloat(e.css(t,"border"+this+"Width"))||0),s&&(i-=parseFloat(e.css(t,"margin"+this))||0)}),i}var a="Width"===n?["Left","Right"]:["Top","Bottom"],o=n.toLowerCase(),r={innerWidth:e.fn.innerWidth,innerHeight:e.fn.innerHeight,outerWidth:e.fn.outerWidth,outerHeight:e.fn.outerHeight};e.fn["inner"+n]=function(i){return i===t?r["inner"+n].call(this):this.each(function(){e(this).css(o,s(this,i)+"px")})},e.fn["outer"+n]=function(t,i){return"number"!=typeof t?r["outer"+n].call(this,t):this.each(function(){e(this).css(o,s(this,t,!0,i)+"px")})}}),e.fn.addBack||(e.fn.addBack=function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}),e("<a>").data("a-b","a").removeData("a-b").data("a-b")&&(e.fn.removeData=function(t){return function(i){return arguments.length?t.call(this,e.camelCase(i)):t.call(this)}}(e.fn.removeData)),e.ui.ie=!!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()),e.support.selectstart="onselectstart"in document.createElement("div"),e.fn.extend({disableSelection:function(){return this.bind((e.support.selectstart?"selectstart":"mousedown")+".ui-disableSelection",function(e){e.preventDefault()})},enableSelection:function(){return this.unbind(".ui-disableSelection")}}),e.extend(e.ui,{plugin:{add:function(t,i,n){var s,a=e.ui[t].prototype;for(s in n)a.plugins[s]=a.plugins[s]||[],a.plugins[s].push([i,n[s]])},call:function(e,t,i){var n,s=e.plugins[t];if(s&&e.element[0].parentNode&&11!==e.element[0].parentNode.nodeType)for(n=0;s.length>n;n++)e.options[s[n][0]]&&s[n][1].apply(e.element,i)}},hasScroll:function(t,i){if("hidden"===e(t).css("overflow"))return!1;var n=i&&"left"===i?"scrollLeft":"scrollTop",s=!1;return t[n]>0?!0:(t[n]=1,s=t[n]>0,t[n]=0,s)}})})(jQuery);(function(t,e){var i=0,s=Array.prototype.slice,n=t.cleanData;t.cleanData=function(e){for(var i,s=0;null!=(i=e[s]);s++)try{t(i).triggerHandler("remove")}catch(o){}n(e)},t.widget=function(i,s,n){var o,a,r,h,l={},c=i.split(".")[0];i=i.split(".")[1],o=c+"-"+i,n||(n=s,s=t.Widget),t.expr[":"][o.toLowerCase()]=function(e){return!!t.data(e,o)},t[c]=t[c]||{},a=t[c][i],r=t[c][i]=function(t,i){return this._createWidget?(arguments.length&&this._createWidget(t,i),e):new r(t,i)},t.extend(r,a,{version:n.version,_proto:t.extend({},n),_childConstructors:[]}),h=new s,h.options=t.widget.extend({},h.options),t.each(n,function(i,n){return t.isFunction(n)?(l[i]=function(){var t=function(){return s.prototype[i].apply(this,arguments)},e=function(t){return s.prototype[i].apply(this,t)};return function(){var i,s=this._super,o=this._superApply;return this._super=t,this._superApply=e,i=n.apply(this,arguments),this._super=s,this._superApply=o,i}}(),e):(l[i]=n,e)}),r.prototype=t.widget.extend(h,{widgetEventPrefix:a?h.widgetEventPrefix:i},l,{constructor:r,namespace:c,widgetName:i,widgetFullName:o}),a?(t.each(a._childConstructors,function(e,i){var s=i.prototype;t.widget(s.namespace+"."+s.widgetName,r,i._proto)}),delete a._childConstructors):s._childConstructors.push(r),t.widget.bridge(i,r)},t.widget.extend=function(i){for(var n,o,a=s.call(arguments,1),r=0,h=a.length;h>r;r++)for(n in a[r])o=a[r][n],a[r].hasOwnProperty(n)&&o!==e&&(i[n]=t.isPlainObject(o)?t.isPlainObject(i[n])?t.widget.extend({},i[n],o):t.widget.extend({},o):o);return i},t.widget.bridge=function(i,n){var o=n.prototype.widgetFullName||i;t.fn[i]=function(a){var r="string"==typeof a,h=s.call(arguments,1),l=this;return a=!r&&h.length?t.widget.extend.apply(null,[a].concat(h)):a,r?this.each(function(){var s,n=t.data(this,o);return n?t.isFunction(n[a])&&"_"!==a.charAt(0)?(s=n[a].apply(n,h),s!==n&&s!==e?(l=s&&s.jquery?l.pushStack(s.get()):s,!1):e):t.error("no such method '"+a+"' for "+i+" widget instance"):t.error("cannot call methods on "+i+" prior to initialization; "+"attempted to call method '"+a+"'")}):this.each(function(){var e=t.data(this,o);e?e.option(a||{})._init():t.data(this,o,new n(a,this))}),l}},t.Widget=function(){},t.Widget._childConstructors=[],t.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{disabled:!1,create:null},_createWidget:function(e,s){s=t(s||this.defaultElement||this)[0],this.element=t(s),this.uuid=i++,this.eventNamespace="."+this.widgetName+this.uuid,this.options=t.widget.extend({},this.options,this._getCreateOptions(),e),this.bindings=t(),this.hoverable=t(),this.focusable=t(),s!==this&&(t.data(s,this.widgetFullName,this),this._on(!0,this.element,{remove:function(t){t.target===s&&this.destroy()}}),this.document=t(s.style?s.ownerDocument:s.document||s),this.window=t(this.document[0].defaultView||this.document[0].parentWindow)),this._create(),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:t.noop,_getCreateEventData:t.noop,_create:t.noop,_init:t.noop,destroy:function(){this._destroy(),this.element.unbind(this.eventNamespace).removeData(this.widgetName).removeData(this.widgetFullName).removeData(t.camelCase(this.widgetFullName)),this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName+"-disabled "+"ui-state-disabled"),this.bindings.unbind(this.eventNamespace),this.hoverable.removeClass("ui-state-hover"),this.focusable.removeClass("ui-state-focus")},_destroy:t.noop,widget:function(){return this.element},option:function(i,s){var n,o,a,r=i;if(0===arguments.length)return t.widget.extend({},this.options);if("string"==typeof i)if(r={},n=i.split("."),i=n.shift(),n.length){for(o=r[i]=t.widget.extend({},this.options[i]),a=0;n.length-1>a;a++)o[n[a]]=o[n[a]]||{},o=o[n[a]];if(i=n.pop(),s===e)return o[i]===e?null:o[i];o[i]=s}else{if(s===e)return this.options[i]===e?null:this.options[i];r[i]=s}return this._setOptions(r),this},_setOptions:function(t){var e;for(e in t)this._setOption(e,t[e]);return this},_setOption:function(t,e){return this.options[t]=e,"disabled"===t&&(this.widget().toggleClass(this.widgetFullName+"-disabled ui-state-disabled",!!e).attr("aria-disabled",e),this.hoverable.removeClass("ui-state-hover"),this.focusable.removeClass("ui-state-focus")),this},enable:function(){return this._setOption("disabled",!1)},disable:function(){return this._setOption("disabled",!0)},_on:function(i,s,n){var o,a=this;"boolean"!=typeof i&&(n=s,s=i,i=!1),n?(s=o=t(s),this.bindings=this.bindings.add(s)):(n=s,s=this.element,o=this.widget()),t.each(n,function(n,r){function h(){return i||a.options.disabled!==!0&&!t(this).hasClass("ui-state-disabled")?("string"==typeof r?a[r]:r).apply(a,arguments):e}"string"!=typeof r&&(h.guid=r.guid=r.guid||h.guid||t.guid++);var l=n.match(/^(\w+)\s*(.*)$/),c=l[1]+a.eventNamespace,u=l[2];u?o.delegate(u,c,h):s.bind(c,h)})},_off:function(t,e){e=(e||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,t.unbind(e).undelegate(e)},_delay:function(t,e){function i(){return("string"==typeof t?s[t]:t).apply(s,arguments)}var s=this;return setTimeout(i,e||0)},_hoverable:function(e){this.hoverable=this.hoverable.add(e),this._on(e,{mouseenter:function(e){t(e.currentTarget).addClass("ui-state-hover")},mouseleave:function(e){t(e.currentTarget).removeClass("ui-state-hover")}})},_focusable:function(e){this.focusable=this.focusable.add(e),this._on(e,{focusin:function(e){t(e.currentTarget).addClass("ui-state-focus")},focusout:function(e){t(e.currentTarget).removeClass("ui-state-focus")}})},_trigger:function(e,i,s){var n,o,a=this.options[e];if(s=s||{},i=t.Event(i),i.type=(e===this.widgetEventPrefix?e:this.widgetEventPrefix+e).toLowerCase(),i.target=this.element[0],o=i.originalEvent)for(n in o)n in i||(i[n]=o[n]);return this.element.trigger(i,s),!(t.isFunction(a)&&a.apply(this.element[0],[i].concat(s))===!1||i.isDefaultPrevented())}},t.each({show:"fadeIn",hide:"fadeOut"},function(e,i){t.Widget.prototype["_"+e]=function(s,n,o){"string"==typeof n&&(n={effect:n});var a,r=n?n===!0||"number"==typeof n?i:n.effect||i:e;n=n||{},"number"==typeof n&&(n={duration:n}),a=!t.isEmptyObject(n),n.complete=o,n.delay&&s.delay(n.delay),a&&t.effects&&t.effects.effect[r]?s[e](n):r!==e&&s[r]?s[r](n.duration,n.easing,o):s.queue(function(i){t(this)[e](),o&&o.call(s[0]),i()})}})})(jQuery);(function(t){var e=!1;t(document).mouseup(function(){e=!1}),t.widget("ui.mouse",{version:"1.10.3",options:{cancel:"input,textarea,button,select,option",distance:1,delay:0},_mouseInit:function(){var e=this;this.element.bind("mousedown."+this.widgetName,function(t){return e._mouseDown(t)}).bind("click."+this.widgetName,function(i){return!0===t.data(i.target,e.widgetName+".preventClickEvent")?(t.removeData(i.target,e.widgetName+".preventClickEvent"),i.stopImmediatePropagation(),!1):undefined}),this.started=!1},_mouseDestroy:function(){this.element.unbind("."+this.widgetName),this._mouseMoveDelegate&&t(document).unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate)},_mouseDown:function(i){if(!e){this._mouseStarted&&this._mouseUp(i),this._mouseDownEvent=i;var s=this,n=1===i.which,a="string"==typeof this.options.cancel&&i.target.nodeName?t(i.target).closest(this.options.cancel).length:!1;return n&&!a&&this._mouseCapture(i)?(this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){s.mouseDelayMet=!0},this.options.delay)),this._mouseDistanceMet(i)&&this._mouseDelayMet(i)&&(this._mouseStarted=this._mouseStart(i)!==!1,!this._mouseStarted)?(i.preventDefault(),!0):(!0===t.data(i.target,this.widgetName+".preventClickEvent")&&t.removeData(i.target,this.widgetName+".preventClickEvent"),this._mouseMoveDelegate=function(t){return s._mouseMove(t)},this._mouseUpDelegate=function(t){return s._mouseUp(t)},t(document).bind("mousemove."+this.widgetName,this._mouseMoveDelegate).bind("mouseup."+this.widgetName,this._mouseUpDelegate),i.preventDefault(),e=!0,!0)):!0}},_mouseMove:function(e){return t.ui.ie&&(!document.documentMode||9>document.documentMode)&&!e.button?this._mouseUp(e):this._mouseStarted?(this._mouseDrag(e),e.preventDefault()):(this._mouseDistanceMet(e)&&this._mouseDelayMet(e)&&(this._mouseStarted=this._mouseStart(this._mouseDownEvent,e)!==!1,this._mouseStarted?this._mouseDrag(e):this._mouseUp(e)),!this._mouseStarted)},_mouseUp:function(e){return t(document).unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,e.target===this._mouseDownEvent.target&&t.data(e.target,this.widgetName+".preventClickEvent",!0),this._mouseStop(e)),!1},_mouseDistanceMet:function(t){return Math.max(Math.abs(this._mouseDownEvent.pageX-t.pageX),Math.abs(this._mouseDownEvent.pageY-t.pageY))>=this.options.distance},_mouseDelayMet:function(){return this.mouseDelayMet},_mouseStart:function(){},_mouseDrag:function(){},_mouseStop:function(){},_mouseCapture:function(){return!0}})})(jQuery);(function(t){function e(t,e,i){return t>e&&e+i>t}function i(t){return/left|right/.test(t.css("float"))||/inline|table-cell/.test(t.css("display"))}t.widget("ui.sortable",t.ui.mouse,{version:"1.10.3",widgetEventPrefix:"sort",ready:!1,options:{appendTo:"parent",axis:!1,connectWith:!1,containment:!1,cursor:"auto",cursorAt:!1,dropOnEmpty:!0,forcePlaceholderSize:!1,forceHelperSize:!1,grid:!1,handle:!1,helper:"original",items:"> *",opacity:!1,placeholder:!1,revert:!1,scroll:!0,scrollSensitivity:20,scrollSpeed:20,scope:"default",tolerance:"intersect",zIndex:1e3,activate:null,beforeStop:null,change:null,deactivate:null,out:null,over:null,receive:null,remove:null,sort:null,start:null,stop:null,update:null},_create:function(){var t=this.options;this.containerCache={},this.element.addClass("ui-sortable"),this.refresh(),this.floating=this.items.length?"x"===t.axis||i(this.items[0].item):!1,this.offset=this.element.offset(),this._mouseInit(),this.ready=!0},_destroy:function(){this.element.removeClass("ui-sortable ui-sortable-disabled"),this._mouseDestroy();for(var t=this.items.length-1;t>=0;t--)this.items[t].item.removeData(this.widgetName+"-item");return this},_setOption:function(e,i){"disabled"===e?(this.options[e]=i,this.widget().toggleClass("ui-sortable-disabled",!!i)):t.Widget.prototype._setOption.apply(this,arguments)},_mouseCapture:function(e,i){var s=null,n=!1,o=this;return this.reverting?!1:this.options.disabled||"static"===this.options.type?!1:(this._refreshItems(e),t(e.target).parents().each(function(){return t.data(this,o.widgetName+"-item")===o?(s=t(this),!1):undefined}),t.data(e.target,o.widgetName+"-item")===o&&(s=t(e.target)),s?!this.options.handle||i||(t(this.options.handle,s).find("*").addBack().each(function(){this===e.target&&(n=!0)}),n)?(this.currentItem=s,this._removeCurrentsFromItems(),!0):!1:!1)},_mouseStart:function(e,i,s){var n,o,a=this.options;if(this.currentContainer=this,this.refreshPositions(),this.helper=this._createHelper(e),this._cacheHelperProportions(),this._cacheMargins(),this.scrollParent=this.helper.scrollParent(),this.offset=this.currentItem.offset(),this.offset={top:this.offset.top-this.margins.top,left:this.offset.left-this.margins.left},t.extend(this.offset,{click:{left:e.pageX-this.offset.left,top:e.pageY-this.offset.top},parent:this._getParentOffset(),relative:this._getRelativeOffset()}),this.helper.css("position","absolute"),this.cssPosition=this.helper.css("position"),this.originalPosition=this._generatePosition(e),this.originalPageX=e.pageX,this.originalPageY=e.pageY,a.cursorAt&&this._adjustOffsetFromHelper(a.cursorAt),this.domPosition={prev:this.currentItem.prev()[0],parent:this.currentItem.parent()[0]},this.helper[0]!==this.currentItem[0]&&this.currentItem.hide(),this._createPlaceholder(),a.containment&&this._setContainment(),a.cursor&&"auto"!==a.cursor&&(o=this.document.find("body"),this.storedCursor=o.css("cursor"),o.css("cursor",a.cursor),this.storedStylesheet=t("<style>*{ cursor: "+a.cursor+" !important; }</style>").appendTo(o)),a.opacity&&(this.helper.css("opacity")&&(this._storedOpacity=this.helper.css("opacity")),this.helper.css("opacity",a.opacity)),a.zIndex&&(this.helper.css("zIndex")&&(this._storedZIndex=this.helper.css("zIndex")),this.helper.css("zIndex",a.zIndex)),this.scrollParent[0]!==document&&"HTML"!==this.scrollParent[0].tagName&&(this.overflowOffset=this.scrollParent.offset()),this._trigger("start",e,this._uiHash()),this._preserveHelperProportions||this._cacheHelperProportions(),!s)for(n=this.containers.length-1;n>=0;n--)this.containers[n]._trigger("activate",e,this._uiHash(this));return t.ui.ddmanager&&(t.ui.ddmanager.current=this),t.ui.ddmanager&&!a.dropBehaviour&&t.ui.ddmanager.prepareOffsets(this,e),this.dragging=!0,this.helper.addClass("ui-sortable-helper"),this._mouseDrag(e),!0},_mouseDrag:function(e){var i,s,n,o,a=this.options,r=!1;for(this.position=this._generatePosition(e),this.positionAbs=this._convertPositionTo("absolute"),this.lastPositionAbs||(this.lastPositionAbs=this.positionAbs),this.options.scroll&&(this.scrollParent[0]!==document&&"HTML"!==this.scrollParent[0].tagName?(this.overflowOffset.top+this.scrollParent[0].offsetHeight-e.pageY<a.scrollSensitivity?this.scrollParent[0].scrollTop=r=this.scrollParent[0].scrollTop+a.scrollSpeed:e.pageY-this.overflowOffset.top<a.scrollSensitivity&&(this.scrollParent[0].scrollTop=r=this.scrollParent[0].scrollTop-a.scrollSpeed),this.overflowOffset.left+this.scrollParent[0].offsetWidth-e.pageX<a.scrollSensitivity?this.scrollParent[0].scrollLeft=r=this.scrollParent[0].scrollLeft+a.scrollSpeed:e.pageX-this.overflowOffset.left<a.scrollSensitivity&&(this.scrollParent[0].scrollLeft=r=this.scrollParent[0].scrollLeft-a.scrollSpeed)):(e.pageY-t(document).scrollTop()<a.scrollSensitivity?r=t(document).scrollTop(t(document).scrollTop()-a.scrollSpeed):t(window).height()-(e.pageY-t(document).scrollTop())<a.scrollSensitivity&&(r=t(document).scrollTop(t(document).scrollTop()+a.scrollSpeed)),e.pageX-t(document).scrollLeft()<a.scrollSensitivity?r=t(document).scrollLeft(t(document).scrollLeft()-a.scrollSpeed):t(window).width()-(e.pageX-t(document).scrollLeft())<a.scrollSensitivity&&(r=t(document).scrollLeft(t(document).scrollLeft()+a.scrollSpeed))),r!==!1&&t.ui.ddmanager&&!a.dropBehaviour&&t.ui.ddmanager.prepareOffsets(this,e)),this.positionAbs=this._convertPositionTo("absolute"),this.options.axis&&"y"===this.options.axis||(this.helper[0].style.left=this.position.left+"px"),this.options.axis&&"x"===this.options.axis||(this.helper[0].style.top=this.position.top+"px"),i=this.items.length-1;i>=0;i--)if(s=this.items[i],n=s.item[0],o=this._intersectsWithPointer(s),o&&s.instance===this.currentContainer&&n!==this.currentItem[0]&&this.placeholder[1===o?"next":"prev"]()[0]!==n&&!t.contains(this.placeholder[0],n)&&("semi-dynamic"===this.options.type?!t.contains(this.element[0],n):!0)){if(this.direction=1===o?"down":"up","pointer"!==this.options.tolerance&&!this._intersectsWithSides(s))break;this._rearrange(e,s),this._trigger("change",e,this._uiHash());break}return this._contactContainers(e),t.ui.ddmanager&&t.ui.ddmanager.drag(this,e),this._trigger("sort",e,this._uiHash()),this.lastPositionAbs=this.positionAbs,!1},_mouseStop:function(e,i){if(e){if(t.ui.ddmanager&&!this.options.dropBehaviour&&t.ui.ddmanager.drop(this,e),this.options.revert){var s=this,n=this.placeholder.offset(),o=this.options.axis,a={};o&&"x"!==o||(a.left=n.left-this.offset.parent.left-this.margins.left+(this.offsetParent[0]===document.body?0:this.offsetParent[0].scrollLeft)),o&&"y"!==o||(a.top=n.top-this.offset.parent.top-this.margins.top+(this.offsetParent[0]===document.body?0:this.offsetParent[0].scrollTop)),this.reverting=!0,t(this.helper).animate(a,parseInt(this.options.revert,10)||500,function(){s._clear(e)})}else this._clear(e,i);return!1}},cancel:function(){if(this.dragging){this._mouseUp({target:null}),"original"===this.options.helper?this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper"):this.currentItem.show();for(var e=this.containers.length-1;e>=0;e--)this.containers[e]._trigger("deactivate",null,this._uiHash(this)),this.containers[e].containerCache.over&&(this.containers[e]._trigger("out",null,this._uiHash(this)),this.containers[e].containerCache.over=0)}return this.placeholder&&(this.placeholder[0].parentNode&&this.placeholder[0].parentNode.removeChild(this.placeholder[0]),"original"!==this.options.helper&&this.helper&&this.helper[0].parentNode&&this.helper.remove(),t.extend(this,{helper:null,dragging:!1,reverting:!1,_noFinalSort:null}),this.domPosition.prev?t(this.domPosition.prev).after(this.currentItem):t(this.domPosition.parent).prepend(this.currentItem)),this},serialize:function(e){var i=this._getItemsAsjQuery(e&&e.connected),s=[];return e=e||{},t(i).each(function(){var i=(t(e.item||this).attr(e.attribute||"id")||"").match(e.expression||/(.+)[\-=_](.+)/);i&&s.push((e.key||i[1]+"[]")+"="+(e.key&&e.expression?i[1]:i[2]))}),!s.length&&e.key&&s.push(e.key+"="),s.join("&")},toArray:function(e){var i=this._getItemsAsjQuery(e&&e.connected),s=[];return e=e||{},i.each(function(){s.push(t(e.item||this).attr(e.attribute||"id")||"")}),s},_intersectsWith:function(t){var e=this.positionAbs.left,i=e+this.helperProportions.width,s=this.positionAbs.top,n=s+this.helperProportions.height,o=t.left,a=o+t.width,r=t.top,h=r+t.height,l=this.offset.click.top,c=this.offset.click.left,u="x"===this.options.axis||s+l>r&&h>s+l,d="y"===this.options.axis||e+c>o&&a>e+c,p=u&&d;return"pointer"===this.options.tolerance||this.options.forcePointerForContainers||"pointer"!==this.options.tolerance&&this.helperProportions[this.floating?"width":"height"]>t[this.floating?"width":"height"]?p:e+this.helperProportions.width/2>o&&a>i-this.helperProportions.width/2&&s+this.helperProportions.height/2>r&&h>n-this.helperProportions.height/2},_intersectsWithPointer:function(t){var i="x"===this.options.axis||e(this.positionAbs.top+this.offset.click.top,t.top,t.height),s="y"===this.options.axis||e(this.positionAbs.left+this.offset.click.left,t.left,t.width),n=i&&s,o=this._getDragVerticalDirection(),a=this._getDragHorizontalDirection();return n?this.floating?a&&"right"===a||"down"===o?2:1:o&&("down"===o?2:1):!1},_intersectsWithSides:function(t){var i=e(this.positionAbs.top+this.offset.click.top,t.top+t.height/2,t.height),s=e(this.positionAbs.left+this.offset.click.left,t.left+t.width/2,t.width),n=this._getDragVerticalDirection(),o=this._getDragHorizontalDirection();return this.floating&&o?"right"===o&&s||"left"===o&&!s:n&&("down"===n&&i||"up"===n&&!i)},_getDragVerticalDirection:function(){var t=this.positionAbs.top-this.lastPositionAbs.top;return 0!==t&&(t>0?"down":"up")},_getDragHorizontalDirection:function(){var t=this.positionAbs.left-this.lastPositionAbs.left;return 0!==t&&(t>0?"right":"left")},refresh:function(t){return this._refreshItems(t),this.refreshPositions(),this},_connectWith:function(){var t=this.options;return t.connectWith.constructor===String?[t.connectWith]:t.connectWith},_getItemsAsjQuery:function(e){var i,s,n,o,a=[],r=[],h=this._connectWith();if(h&&e)for(i=h.length-1;i>=0;i--)for(n=t(h[i]),s=n.length-1;s>=0;s--)o=t.data(n[s],this.widgetFullName),o&&o!==this&&!o.options.disabled&&r.push([t.isFunction(o.options.items)?o.options.items.call(o.element):t(o.options.items,o.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),o]);for(r.push([t.isFunction(this.options.items)?this.options.items.call(this.element,null,{options:this.options,item:this.currentItem}):t(this.options.items,this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),this]),i=r.length-1;i>=0;i--)r[i][0].each(function(){a.push(this)});return t(a)},_removeCurrentsFromItems:function(){var e=this.currentItem.find(":data("+this.widgetName+"-item)");this.items=t.grep(this.items,function(t){for(var i=0;e.length>i;i++)if(e[i]===t.item[0])return!1;return!0})},_refreshItems:function(e){this.items=[],this.containers=[this];var i,s,n,o,a,r,h,l,c=this.items,u=[[t.isFunction(this.options.items)?this.options.items.call(this.element[0],e,{item:this.currentItem}):t(this.options.items,this.element),this]],d=this._connectWith();if(d&&this.ready)for(i=d.length-1;i>=0;i--)for(n=t(d[i]),s=n.length-1;s>=0;s--)o=t.data(n[s],this.widgetFullName),o&&o!==this&&!o.options.disabled&&(u.push([t.isFunction(o.options.items)?o.options.items.call(o.element[0],e,{item:this.currentItem}):t(o.options.items,o.element),o]),this.containers.push(o));for(i=u.length-1;i>=0;i--)for(a=u[i][1],r=u[i][0],s=0,l=r.length;l>s;s++)h=t(r[s]),h.data(this.widgetName+"-item",a),c.push({item:h,instance:a,width:0,height:0,left:0,top:0})},refreshPositions:function(e){this.offsetParent&&this.helper&&(this.offset.parent=this._getParentOffset());var i,s,n,o;for(i=this.items.length-1;i>=0;i--)s=this.items[i],s.instance!==this.currentContainer&&this.currentContainer&&s.item[0]!==this.currentItem[0]||(n=this.options.toleranceElement?t(this.options.toleranceElement,s.item):s.item,e||(s.width=n.outerWidth(),s.height=n.outerHeight()),o=n.offset(),s.left=o.left,s.top=o.top);if(this.options.custom&&this.options.custom.refreshContainers)this.options.custom.refreshContainers.call(this);else for(i=this.containers.length-1;i>=0;i--)o=this.containers[i].element.offset(),this.containers[i].containerCache.left=o.left,this.containers[i].containerCache.top=o.top,this.containers[i].containerCache.width=this.containers[i].element.outerWidth(),this.containers[i].containerCache.height=this.containers[i].element.outerHeight();return this},_createPlaceholder:function(e){e=e||this;var i,s=e.options;s.placeholder&&s.placeholder.constructor!==String||(i=s.placeholder,s.placeholder={element:function(){var s=e.currentItem[0].nodeName.toLowerCase(),n=t("<"+s+">",e.document[0]).addClass(i||e.currentItem[0].className+" ui-sortable-placeholder").removeClass("ui-sortable-helper");return"tr"===s?e.currentItem.children().each(function(){t("<td>&#160;</td>",e.document[0]).attr("colspan",t(this).attr("colspan")||1).appendTo(n)}):"img"===s&&n.attr("src",e.currentItem.attr("src")),i||n.css("visibility","hidden"),n},update:function(t,n){(!i||s.forcePlaceholderSize)&&(n.height()||n.height(e.currentItem.innerHeight()-parseInt(e.currentItem.css("paddingTop")||0,10)-parseInt(e.currentItem.css("paddingBottom")||0,10)),n.width()||n.width(e.currentItem.innerWidth()-parseInt(e.currentItem.css("paddingLeft")||0,10)-parseInt(e.currentItem.css("paddingRight")||0,10)))}}),e.placeholder=t(s.placeholder.element.call(e.element,e.currentItem)),e.currentItem.after(e.placeholder),s.placeholder.update(e,e.placeholder)},_contactContainers:function(s){var n,o,a,r,h,l,c,u,d,p,f=null,g=null;for(n=this.containers.length-1;n>=0;n--)if(!t.contains(this.currentItem[0],this.containers[n].element[0]))if(this._intersectsWith(this.containers[n].containerCache)){if(f&&t.contains(this.containers[n].element[0],f.element[0]))continue;f=this.containers[n],g=n}else this.containers[n].containerCache.over&&(this.containers[n]._trigger("out",s,this._uiHash(this)),this.containers[n].containerCache.over=0);if(f)if(1===this.containers.length)this.containers[g].containerCache.over||(this.containers[g]._trigger("over",s,this._uiHash(this)),this.containers[g].containerCache.over=1);else{for(a=1e4,r=null,p=f.floating||i(this.currentItem),h=p?"left":"top",l=p?"width":"height",c=this.positionAbs[h]+this.offset.click[h],o=this.items.length-1;o>=0;o--)t.contains(this.containers[g].element[0],this.items[o].item[0])&&this.items[o].item[0]!==this.currentItem[0]&&(!p||e(this.positionAbs.top+this.offset.click.top,this.items[o].top,this.items[o].height))&&(u=this.items[o].item.offset()[h],d=!1,Math.abs(u-c)>Math.abs(u+this.items[o][l]-c)&&(d=!0,u+=this.items[o][l]),a>Math.abs(u-c)&&(a=Math.abs(u-c),r=this.items[o],this.direction=d?"up":"down"));if(!r&&!this.options.dropOnEmpty)return;if(this.currentContainer===this.containers[g])return;r?this._rearrange(s,r,null,!0):this._rearrange(s,null,this.containers[g].element,!0),this._trigger("change",s,this._uiHash()),this.containers[g]._trigger("change",s,this._uiHash(this)),this.currentContainer=this.containers[g],this.options.placeholder.update(this.currentContainer,this.placeholder),this.containers[g]._trigger("over",s,this._uiHash(this)),this.containers[g].containerCache.over=1}},_createHelper:function(e){var i=this.options,s=t.isFunction(i.helper)?t(i.helper.apply(this.element[0],[e,this.currentItem])):"clone"===i.helper?this.currentItem.clone():this.currentItem;return s.parents("body").length||t("parent"!==i.appendTo?i.appendTo:this.currentItem[0].parentNode)[0].appendChild(s[0]),s[0]===this.currentItem[0]&&(this._storedCSS={width:this.currentItem[0].style.width,height:this.currentItem[0].style.height,position:this.currentItem.css("position"),top:this.currentItem.css("top"),left:this.currentItem.css("left")}),(!s[0].style.width||i.forceHelperSize)&&s.width(this.currentItem.width()),(!s[0].style.height||i.forceHelperSize)&&s.height(this.currentItem.height()),s},_adjustOffsetFromHelper:function(e){"string"==typeof e&&(e=e.split(" ")),t.isArray(e)&&(e={left:+e[0],top:+e[1]||0}),"left"in e&&(this.offset.click.left=e.left+this.margins.left),"right"in e&&(this.offset.click.left=this.helperProportions.width-e.right+this.margins.left),"top"in e&&(this.offset.click.top=e.top+this.margins.top),"bottom"in e&&(this.offset.click.top=this.helperProportions.height-e.bottom+this.margins.top)},_getParentOffset:function(){this.offsetParent=this.helper.offsetParent();var e=this.offsetParent.offset();return"absolute"===this.cssPosition&&this.scrollParent[0]!==document&&t.contains(this.scrollParent[0],this.offsetParent[0])&&(e.left+=this.scrollParent.scrollLeft(),e.top+=this.scrollParent.scrollTop()),(this.offsetParent[0]===document.body||this.offsetParent[0].tagName&&"html"===this.offsetParent[0].tagName.toLowerCase()&&t.ui.ie)&&(e={top:0,left:0}),{top:e.top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),left:e.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)}},_getRelativeOffset:function(){if("relative"===this.cssPosition){var t=this.currentItem.position();return{top:t.top-(parseInt(this.helper.css("top"),10)||0)+this.scrollParent.scrollTop(),left:t.left-(parseInt(this.helper.css("left"),10)||0)+this.scrollParent.scrollLeft()}}return{top:0,left:0}},_cacheMargins:function(){this.margins={left:parseInt(this.currentItem.css("marginLeft"),10)||0,top:parseInt(this.currentItem.css("marginTop"),10)||0}},_cacheHelperProportions:function(){this.helperProportions={width:this.helper.outerWidth(),height:this.helper.outerHeight()}},_setContainment:function(){var e,i,s,n=this.options;"parent"===n.containment&&(n.containment=this.helper[0].parentNode),("document"===n.containment||"window"===n.containment)&&(this.containment=[0-this.offset.relative.left-this.offset.parent.left,0-this.offset.relative.top-this.offset.parent.top,t("document"===n.containment?document:window).width()-this.helperProportions.width-this.margins.left,(t("document"===n.containment?document:window).height()||document.body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top]),/^(document|window|parent)$/.test(n.containment)||(e=t(n.containment)[0],i=t(n.containment).offset(),s="hidden"!==t(e).css("overflow"),this.containment=[i.left+(parseInt(t(e).css("borderLeftWidth"),10)||0)+(parseInt(t(e).css("paddingLeft"),10)||0)-this.margins.left,i.top+(parseInt(t(e).css("borderTopWidth"),10)||0)+(parseInt(t(e).css("paddingTop"),10)||0)-this.margins.top,i.left+(s?Math.max(e.scrollWidth,e.offsetWidth):e.offsetWidth)-(parseInt(t(e).css("borderLeftWidth"),10)||0)-(parseInt(t(e).css("paddingRight"),10)||0)-this.helperProportions.width-this.margins.left,i.top+(s?Math.max(e.scrollHeight,e.offsetHeight):e.offsetHeight)-(parseInt(t(e).css("borderTopWidth"),10)||0)-(parseInt(t(e).css("paddingBottom"),10)||0)-this.helperProportions.height-this.margins.top])},_convertPositionTo:function(e,i){i||(i=this.position);var s="absolute"===e?1:-1,n="absolute"!==this.cssPosition||this.scrollParent[0]!==document&&t.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,o=/(html|body)/i.test(n[0].tagName);return{top:i.top+this.offset.relative.top*s+this.offset.parent.top*s-("fixed"===this.cssPosition?-this.scrollParent.scrollTop():o?0:n.scrollTop())*s,left:i.left+this.offset.relative.left*s+this.offset.parent.left*s-("fixed"===this.cssPosition?-this.scrollParent.scrollLeft():o?0:n.scrollLeft())*s}},_generatePosition:function(e){var i,s,n=this.options,o=e.pageX,a=e.pageY,r="absolute"!==this.cssPosition||this.scrollParent[0]!==document&&t.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,h=/(html|body)/i.test(r[0].tagName);return"relative"!==this.cssPosition||this.scrollParent[0]!==document&&this.scrollParent[0]!==this.offsetParent[0]||(this.offset.relative=this._getRelativeOffset()),this.originalPosition&&(this.containment&&(e.pageX-this.offset.click.left<this.containment[0]&&(o=this.containment[0]+this.offset.click.left),e.pageY-this.offset.click.top<this.containment[1]&&(a=this.containment[1]+this.offset.click.top),e.pageX-this.offset.click.left>this.containment[2]&&(o=this.containment[2]+this.offset.click.left),e.pageY-this.offset.click.top>this.containment[3]&&(a=this.containment[3]+this.offset.click.top)),n.grid&&(i=this.originalPageY+Math.round((a-this.originalPageY)/n.grid[1])*n.grid[1],a=this.containment?i-this.offset.click.top>=this.containment[1]&&i-this.offset.click.top<=this.containment[3]?i:i-this.offset.click.top>=this.containment[1]?i-n.grid[1]:i+n.grid[1]:i,s=this.originalPageX+Math.round((o-this.originalPageX)/n.grid[0])*n.grid[0],o=this.containment?s-this.offset.click.left>=this.containment[0]&&s-this.offset.click.left<=this.containment[2]?s:s-this.offset.click.left>=this.containment[0]?s-n.grid[0]:s+n.grid[0]:s)),{top:a-this.offset.click.top-this.offset.relative.top-this.offset.parent.top+("fixed"===this.cssPosition?-this.scrollParent.scrollTop():h?0:r.scrollTop()),left:o-this.offset.click.left-this.offset.relative.left-this.offset.parent.left+("fixed"===this.cssPosition?-this.scrollParent.scrollLeft():h?0:r.scrollLeft())}},_rearrange:function(t,e,i,s){i?i[0].appendChild(this.placeholder[0]):e.item[0].parentNode.insertBefore(this.placeholder[0],"down"===this.direction?e.item[0]:e.item[0].nextSibling),this.counter=this.counter?++this.counter:1;var n=this.counter;this._delay(function(){n===this.counter&&this.refreshPositions(!s)})},_clear:function(t,e){this.reverting=!1;var i,s=[];if(!this._noFinalSort&&this.currentItem.parent().length&&this.placeholder.before(this.currentItem),this._noFinalSort=null,this.helper[0]===this.currentItem[0]){for(i in this._storedCSS)("auto"===this._storedCSS[i]||"static"===this._storedCSS[i])&&(this._storedCSS[i]="");this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")}else this.currentItem.show();for(this.fromOutside&&!e&&s.push(function(t){this._trigger("receive",t,this._uiHash(this.fromOutside))}),!this.fromOutside&&this.domPosition.prev===this.currentItem.prev().not(".ui-sortable-helper")[0]&&this.domPosition.parent===this.currentItem.parent()[0]||e||s.push(function(t){this._trigger("update",t,this._uiHash())}),this!==this.currentContainer&&(e||(s.push(function(t){this._trigger("remove",t,this._uiHash())}),s.push(function(t){return function(e){t._trigger("receive",e,this._uiHash(this))}}.call(this,this.currentContainer)),s.push(function(t){return function(e){t._trigger("update",e,this._uiHash(this))}}.call(this,this.currentContainer)))),i=this.containers.length-1;i>=0;i--)e||s.push(function(t){return function(e){t._trigger("deactivate",e,this._uiHash(this))}}.call(this,this.containers[i])),this.containers[i].containerCache.over&&(s.push(function(t){return function(e){t._trigger("out",e,this._uiHash(this))}}.call(this,this.containers[i])),this.containers[i].containerCache.over=0);if(this.storedCursor&&(this.document.find("body").css("cursor",this.storedCursor),this.storedStylesheet.remove()),this._storedOpacity&&this.helper.css("opacity",this._storedOpacity),this._storedZIndex&&this.helper.css("zIndex","auto"===this._storedZIndex?"":this._storedZIndex),this.dragging=!1,this.cancelHelperRemoval){if(!e){for(this._trigger("beforeStop",t,this._uiHash()),i=0;s.length>i;i++)s[i].call(this,t);this._trigger("stop",t,this._uiHash())}return this.fromOutside=!1,!1}if(e||this._trigger("beforeStop",t,this._uiHash()),this.placeholder[0].parentNode.removeChild(this.placeholder[0]),this.helper[0]!==this.currentItem[0]&&this.helper.remove(),this.helper=null,!e){for(i=0;s.length>i;i++)s[i].call(this,t);this._trigger("stop",t,this._uiHash())}return this.fromOutside=!1,!0},_trigger:function(){t.Widget.prototype._trigger.apply(this,arguments)===!1&&this.cancel()},_uiHash:function(e){var i=e||this;return{helper:i.helper,placeholder:i.placeholder||t([]),position:i.position,originalPosition:i.originalPosition,offset:i.positionAbs,item:i.currentItem,sender:e?e.element:null}}})})(jQuery);

/***/ },
/* 4 */
/*!*******************************************************************!*\
  !*** ./bower_components/jquery-ui-sortable/jquery-ui-sortable.js ***!
  \*******************************************************************/
/***/ function(module, exports) {

	/*! http://jqueryui.com
	* Includes: jquery.ui.core.js, jquery.ui.widget.js, jquery.ui.mouse.js, jquery.ui.sortable.js
	* Copyright 2013 jQuery Foundation and other contributors; Licensed MIT */
	
	(function( $, undefined ) {
	
	var uuid = 0,
		runiqueId = /^ui-id-\d+$/;
	
	// $.ui might exist from components with no dependencies, e.g., $.ui.position
	$.ui = $.ui || {};
	
	$.extend( $.ui, {
		version: "1.10.3",
	
		keyCode: {
			BACKSPACE: 8,
			COMMA: 188,
			DELETE: 46,
			DOWN: 40,
			END: 35,
			ENTER: 13,
			ESCAPE: 27,
			HOME: 36,
			LEFT: 37,
			NUMPAD_ADD: 107,
			NUMPAD_DECIMAL: 110,
			NUMPAD_DIVIDE: 111,
			NUMPAD_ENTER: 108,
			NUMPAD_MULTIPLY: 106,
			NUMPAD_SUBTRACT: 109,
			PAGE_DOWN: 34,
			PAGE_UP: 33,
			PERIOD: 190,
			RIGHT: 39,
			SPACE: 32,
			TAB: 9,
			UP: 38
		}
	});
	
	// plugins
	$.fn.extend({
		focus: (function( orig ) {
			return function( delay, fn ) {
				return typeof delay === "number" ?
					this.each(function() {
						var elem = this;
						setTimeout(function() {
							$( elem ).focus();
							if ( fn ) {
								fn.call( elem );
							}
						}, delay );
					}) :
					orig.apply( this, arguments );
			};
		})( $.fn.focus ),
	
		scrollParent: function() {
			var scrollParent;
			if (($.ui.ie && (/(static|relative)/).test(this.css("position"))) || (/absolute/).test(this.css("position"))) {
				scrollParent = this.parents().filter(function() {
					return (/(relative|absolute|fixed)/).test($.css(this,"position")) && (/(auto|scroll)/).test($.css(this,"overflow")+$.css(this,"overflow-y")+$.css(this,"overflow-x"));
				}).eq(0);
			} else {
				scrollParent = this.parents().filter(function() {
					return (/(auto|scroll)/).test($.css(this,"overflow")+$.css(this,"overflow-y")+$.css(this,"overflow-x"));
				}).eq(0);
			}
	
			return (/fixed/).test(this.css("position")) || !scrollParent.length ? $(document) : scrollParent;
		},
	
		zIndex: function( zIndex ) {
			if ( zIndex !== undefined ) {
				return this.css( "zIndex", zIndex );
			}
	
			if ( this.length ) {
				var elem = $( this[ 0 ] ), position, value;
				while ( elem.length && elem[ 0 ] !== document ) {
					// Ignore z-index if position is set to a value where z-index is ignored by the browser
					// This makes behavior of this function consistent across browsers
					// WebKit always returns auto if the element is positioned
					position = elem.css( "position" );
					if ( position === "absolute" || position === "relative" || position === "fixed" ) {
						// IE returns 0 when zIndex is not specified
						// other browsers return a string
						// we ignore the case of nested elements with an explicit value of 0
						// <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
						value = parseInt( elem.css( "zIndex" ), 10 );
						if ( !isNaN( value ) && value !== 0 ) {
							return value;
						}
					}
					elem = elem.parent();
				}
			}
	
			return 0;
		},
	
		uniqueId: function() {
			return this.each(function() {
				if ( !this.id ) {
					this.id = "ui-id-" + (++uuid);
				}
			});
		},
	
		removeUniqueId: function() {
			return this.each(function() {
				if ( runiqueId.test( this.id ) ) {
					$( this ).removeAttr( "id" );
				}
			});
		}
	});
	
	// selectors
	function focusable( element, isTabIndexNotNaN ) {
		var map, mapName, img,
			nodeName = element.nodeName.toLowerCase();
		if ( "area" === nodeName ) {
			map = element.parentNode;
			mapName = map.name;
			if ( !element.href || !mapName || map.nodeName.toLowerCase() !== "map" ) {
				return false;
			}
			img = $( "img[usemap=#" + mapName + "]" )[0];
			return !!img && visible( img );
		}
		return ( /input|select|textarea|button|object/.test( nodeName ) ?
			!element.disabled :
			"a" === nodeName ?
				element.href || isTabIndexNotNaN :
				isTabIndexNotNaN) &&
			// the element and all of its ancestors must be visible
			visible( element );
	}
	
	function visible( element ) {
		return $.expr.filters.visible( element ) &&
			!$( element ).parents().addBack().filter(function() {
				return $.css( this, "visibility" ) === "hidden";
			}).length;
	}
	
	$.extend( $.expr[ ":" ], {
		data: $.expr.createPseudo ?
			$.expr.createPseudo(function( dataName ) {
				return function( elem ) {
					return !!$.data( elem, dataName );
				};
			}) :
			// support: jQuery <1.8
			function( elem, i, match ) {
				return !!$.data( elem, match[ 3 ] );
			},
	
		focusable: function( element ) {
			return focusable( element, !isNaN( $.attr( element, "tabindex" ) ) );
		},
	
		tabbable: function( element ) {
			var tabIndex = $.attr( element, "tabindex" ),
				isTabIndexNaN = isNaN( tabIndex );
			return ( isTabIndexNaN || tabIndex >= 0 ) && focusable( element, !isTabIndexNaN );
		}
	});
	
	// support: jQuery <1.8
	if ( !$( "<a>" ).outerWidth( 1 ).jquery ) {
		$.each( [ "Width", "Height" ], function( i, name ) {
			var side = name === "Width" ? [ "Left", "Right" ] : [ "Top", "Bottom" ],
				type = name.toLowerCase(),
				orig = {
					innerWidth: $.fn.innerWidth,
					innerHeight: $.fn.innerHeight,
					outerWidth: $.fn.outerWidth,
					outerHeight: $.fn.outerHeight
				};
	
			function reduce( elem, size, border, margin ) {
				$.each( side, function() {
					size -= parseFloat( $.css( elem, "padding" + this ) ) || 0;
					if ( border ) {
						size -= parseFloat( $.css( elem, "border" + this + "Width" ) ) || 0;
					}
					if ( margin ) {
						size -= parseFloat( $.css( elem, "margin" + this ) ) || 0;
					}
				});
				return size;
			}
	
			$.fn[ "inner" + name ] = function( size ) {
				if ( size === undefined ) {
					return orig[ "inner" + name ].call( this );
				}
	
				return this.each(function() {
					$( this ).css( type, reduce( this, size ) + "px" );
				});
			};
	
			$.fn[ "outer" + name] = function( size, margin ) {
				if ( typeof size !== "number" ) {
					return orig[ "outer" + name ].call( this, size );
				}
	
				return this.each(function() {
					$( this).css( type, reduce( this, size, true, margin ) + "px" );
				});
			};
		});
	}
	
	// support: jQuery <1.8
	if ( !$.fn.addBack ) {
		$.fn.addBack = function( selector ) {
			return this.add( selector == null ?
				this.prevObject : this.prevObject.filter( selector )
			);
		};
	}
	
	// support: jQuery 1.6.1, 1.6.2 (http://bugs.jquery.com/ticket/9413)
	if ( $( "<a>" ).data( "a-b", "a" ).removeData( "a-b" ).data( "a-b" ) ) {
		$.fn.removeData = (function( removeData ) {
			return function( key ) {
				if ( arguments.length ) {
					return removeData.call( this, $.camelCase( key ) );
				} else {
					return removeData.call( this );
				}
			};
		})( $.fn.removeData );
	}
	
	
	
	
	
	// deprecated
	$.ui.ie = !!/msie [\w.]+/.exec( navigator.userAgent.toLowerCase() );
	
	$.support.selectstart = "onselectstart" in document.createElement( "div" );
	$.fn.extend({
		disableSelection: function() {
			return this.bind( ( $.support.selectstart ? "selectstart" : "mousedown" ) +
				".ui-disableSelection", function( event ) {
					event.preventDefault();
				});
		},
	
		enableSelection: function() {
			return this.unbind( ".ui-disableSelection" );
		}
	});
	
	$.extend( $.ui, {
		// $.ui.plugin is deprecated. Use $.widget() extensions instead.
		plugin: {
			add: function( module, option, set ) {
				var i,
					proto = $.ui[ module ].prototype;
				for ( i in set ) {
					proto.plugins[ i ] = proto.plugins[ i ] || [];
					proto.plugins[ i ].push( [ option, set[ i ] ] );
				}
			},
			call: function( instance, name, args ) {
				var i,
					set = instance.plugins[ name ];
				if ( !set || !instance.element[ 0 ].parentNode || instance.element[ 0 ].parentNode.nodeType === 11 ) {
					return;
				}
	
				for ( i = 0; i < set.length; i++ ) {
					if ( instance.options[ set[ i ][ 0 ] ] ) {
						set[ i ][ 1 ].apply( instance.element, args );
					}
				}
			}
		},
	
		// only used by resizable
		hasScroll: function( el, a ) {
	
			//If overflow is hidden, the element might have extra content, but the user wants to hide it
			if ( $( el ).css( "overflow" ) === "hidden") {
				return false;
			}
	
			var scroll = ( a && a === "left" ) ? "scrollLeft" : "scrollTop",
				has = false;
	
			if ( el[ scroll ] > 0 ) {
				return true;
			}
	
			// TODO: determine which cases actually cause this to happen
			// if the element doesn't have the scroll set, see if it's possible to
			// set the scroll
			el[ scroll ] = 1;
			has = ( el[ scroll ] > 0 );
			el[ scroll ] = 0;
			return has;
		}
	});
	
	})( jQuery );
	(function( $, undefined ) {
	
	var uuid = 0,
		slice = Array.prototype.slice,
		_cleanData = $.cleanData;
	$.cleanData = function( elems ) {
		for ( var i = 0, elem; (elem = elems[i]) != null; i++ ) {
			try {
				$( elem ).triggerHandler( "remove" );
			// http://bugs.jquery.com/ticket/8235
			} catch( e ) {}
		}
		_cleanData( elems );
	};
	
	$.widget = function( name, base, prototype ) {
		var fullName, existingConstructor, constructor, basePrototype,
			// proxiedPrototype allows the provided prototype to remain unmodified
			// so that it can be used as a mixin for multiple widgets (#8876)
			proxiedPrototype = {},
			namespace = name.split( "." )[ 0 ];
	
		name = name.split( "." )[ 1 ];
		fullName = namespace + "-" + name;
	
		if ( !prototype ) {
			prototype = base;
			base = $.Widget;
		}
	
		// create selector for plugin
		$.expr[ ":" ][ fullName.toLowerCase() ] = function( elem ) {
			return !!$.data( elem, fullName );
		};
	
		$[ namespace ] = $[ namespace ] || {};
		existingConstructor = $[ namespace ][ name ];
		constructor = $[ namespace ][ name ] = function( options, element ) {
			// allow instantiation without "new" keyword
			if ( !this._createWidget ) {
				return new constructor( options, element );
			}
	
			// allow instantiation without initializing for simple inheritance
			// must use "new" keyword (the code above always passes args)
			if ( arguments.length ) {
				this._createWidget( options, element );
			}
		};
		// extend with the existing constructor to carry over any static properties
		$.extend( constructor, existingConstructor, {
			version: prototype.version,
			// copy the object used to create the prototype in case we need to
			// redefine the widget later
			_proto: $.extend( {}, prototype ),
			// track widgets that inherit from this widget in case this widget is
			// redefined after a widget inherits from it
			_childConstructors: []
		});
	
		basePrototype = new base();
		// we need to make the options hash a property directly on the new instance
		// otherwise we'll modify the options hash on the prototype that we're
		// inheriting from
		basePrototype.options = $.widget.extend( {}, basePrototype.options );
		$.each( prototype, function( prop, value ) {
			if ( !$.isFunction( value ) ) {
				proxiedPrototype[ prop ] = value;
				return;
			}
			proxiedPrototype[ prop ] = (function() {
				var _super = function() {
						return base.prototype[ prop ].apply( this, arguments );
					},
					_superApply = function( args ) {
						return base.prototype[ prop ].apply( this, args );
					};
				return function() {
					var __super = this._super,
						__superApply = this._superApply,
						returnValue;
	
					this._super = _super;
					this._superApply = _superApply;
	
					returnValue = value.apply( this, arguments );
	
					this._super = __super;
					this._superApply = __superApply;
	
					return returnValue;
				};
			})();
		});
		constructor.prototype = $.widget.extend( basePrototype, {
			// TODO: remove support for widgetEventPrefix
			// always use the name + a colon as the prefix, e.g., draggable:start
			// don't prefix for widgets that aren't DOM-based
			widgetEventPrefix: existingConstructor ? basePrototype.widgetEventPrefix : name
		}, proxiedPrototype, {
			constructor: constructor,
			namespace: namespace,
			widgetName: name,
			widgetFullName: fullName
		});
	
		// If this widget is being redefined then we need to find all widgets that
		// are inheriting from it and redefine all of them so that they inherit from
		// the new version of this widget. We're essentially trying to replace one
		// level in the prototype chain.
		if ( existingConstructor ) {
			$.each( existingConstructor._childConstructors, function( i, child ) {
				var childPrototype = child.prototype;
	
				// redefine the child widget using the same prototype that was
				// originally used, but inherit from the new version of the base
				$.widget( childPrototype.namespace + "." + childPrototype.widgetName, constructor, child._proto );
			});
			// remove the list of existing child constructors from the old constructor
			// so the old child constructors can be garbage collected
			delete existingConstructor._childConstructors;
		} else {
			base._childConstructors.push( constructor );
		}
	
		$.widget.bridge( name, constructor );
	};
	
	$.widget.extend = function( target ) {
		var input = slice.call( arguments, 1 ),
			inputIndex = 0,
			inputLength = input.length,
			key,
			value;
		for ( ; inputIndex < inputLength; inputIndex++ ) {
			for ( key in input[ inputIndex ] ) {
				value = input[ inputIndex ][ key ];
				if ( input[ inputIndex ].hasOwnProperty( key ) && value !== undefined ) {
					// Clone objects
					if ( $.isPlainObject( value ) ) {
						target[ key ] = $.isPlainObject( target[ key ] ) ?
							$.widget.extend( {}, target[ key ], value ) :
							// Don't extend strings, arrays, etc. with objects
							$.widget.extend( {}, value );
					// Copy everything else by reference
					} else {
						target[ key ] = value;
					}
				}
			}
		}
		return target;
	};
	
	$.widget.bridge = function( name, object ) {
		var fullName = object.prototype.widgetFullName || name;
		$.fn[ name ] = function( options ) {
			var isMethodCall = typeof options === "string",
				args = slice.call( arguments, 1 ),
				returnValue = this;
	
			// allow multiple hashes to be passed on init
			options = !isMethodCall && args.length ?
				$.widget.extend.apply( null, [ options ].concat(args) ) :
				options;
	
			if ( isMethodCall ) {
				this.each(function() {
					var methodValue,
						instance = $.data( this, fullName );
					if ( !instance ) {
						return $.error( "cannot call methods on " + name + " prior to initialization; " +
							"attempted to call method '" + options + "'" );
					}
					if ( !$.isFunction( instance[options] ) || options.charAt( 0 ) === "_" ) {
						return $.error( "no such method '" + options + "' for " + name + " widget instance" );
					}
					methodValue = instance[ options ].apply( instance, args );
					if ( methodValue !== instance && methodValue !== undefined ) {
						returnValue = methodValue && methodValue.jquery ?
							returnValue.pushStack( methodValue.get() ) :
							methodValue;
						return false;
					}
				});
			} else {
				this.each(function() {
					var instance = $.data( this, fullName );
					if ( instance ) {
						instance.option( options || {} )._init();
					} else {
						$.data( this, fullName, new object( options, this ) );
					}
				});
			}
	
			return returnValue;
		};
	};
	
	$.Widget = function( /* options, element */ ) {};
	$.Widget._childConstructors = [];
	
	$.Widget.prototype = {
		widgetName: "widget",
		widgetEventPrefix: "",
		defaultElement: "<div>",
		options: {
			disabled: false,
	
			// callbacks
			create: null
		},
		_createWidget: function( options, element ) {
			element = $( element || this.defaultElement || this )[ 0 ];
			this.element = $( element );
			this.uuid = uuid++;
			this.eventNamespace = "." + this.widgetName + this.uuid;
			this.options = $.widget.extend( {},
				this.options,
				this._getCreateOptions(),
				options );
	
			this.bindings = $();
			this.hoverable = $();
			this.focusable = $();
	
			if ( element !== this ) {
				$.data( element, this.widgetFullName, this );
				this._on( true, this.element, {
					remove: function( event ) {
						if ( event.target === element ) {
							this.destroy();
						}
					}
				});
				this.document = $( element.style ?
					// element within the document
					element.ownerDocument :
					// element is window or document
					element.document || element );
				this.window = $( this.document[0].defaultView || this.document[0].parentWindow );
			}
	
			this._create();
			this._trigger( "create", null, this._getCreateEventData() );
			this._init();
		},
		_getCreateOptions: $.noop,
		_getCreateEventData: $.noop,
		_create: $.noop,
		_init: $.noop,
	
		destroy: function() {
			this._destroy();
			// we can probably remove the unbind calls in 2.0
			// all event bindings should go through this._on()
			this.element
				.unbind( this.eventNamespace )
				// 1.9 BC for #7810
				// TODO remove dual storage
				.removeData( this.widgetName )
				.removeData( this.widgetFullName )
				// support: jquery <1.6.3
				// http://bugs.jquery.com/ticket/9413
				.removeData( $.camelCase( this.widgetFullName ) );
			this.widget()
				.unbind( this.eventNamespace )
				.removeAttr( "aria-disabled" )
				.removeClass(
					this.widgetFullName + "-disabled " +
					"ui-state-disabled" );
	
			// clean up events and states
			this.bindings.unbind( this.eventNamespace );
			this.hoverable.removeClass( "ui-state-hover" );
			this.focusable.removeClass( "ui-state-focus" );
		},
		_destroy: $.noop,
	
		widget: function() {
			return this.element;
		},
	
		option: function( key, value ) {
			var options = key,
				parts,
				curOption,
				i;
	
			if ( arguments.length === 0 ) {
				// don't return a reference to the internal hash
				return $.widget.extend( {}, this.options );
			}
	
			if ( typeof key === "string" ) {
				// handle nested keys, e.g., "foo.bar" => { foo: { bar: ___ } }
				options = {};
				parts = key.split( "." );
				key = parts.shift();
				if ( parts.length ) {
					curOption = options[ key ] = $.widget.extend( {}, this.options[ key ] );
					for ( i = 0; i < parts.length - 1; i++ ) {
						curOption[ parts[ i ] ] = curOption[ parts[ i ] ] || {};
						curOption = curOption[ parts[ i ] ];
					}
					key = parts.pop();
					if ( value === undefined ) {
						return curOption[ key ] === undefined ? null : curOption[ key ];
					}
					curOption[ key ] = value;
				} else {
					if ( value === undefined ) {
						return this.options[ key ] === undefined ? null : this.options[ key ];
					}
					options[ key ] = value;
				}
			}
	
			this._setOptions( options );
	
			return this;
		},
		_setOptions: function( options ) {
			var key;
	
			for ( key in options ) {
				this._setOption( key, options[ key ] );
			}
	
			return this;
		},
		_setOption: function( key, value ) {
			this.options[ key ] = value;
	
			if ( key === "disabled" ) {
				this.widget()
					.toggleClass( this.widgetFullName + "-disabled ui-state-disabled", !!value )
					.attr( "aria-disabled", value );
				this.hoverable.removeClass( "ui-state-hover" );
				this.focusable.removeClass( "ui-state-focus" );
			}
	
			return this;
		},
	
		enable: function() {
			return this._setOption( "disabled", false );
		},
		disable: function() {
			return this._setOption( "disabled", true );
		},
	
		_on: function( suppressDisabledCheck, element, handlers ) {
			var delegateElement,
				instance = this;
	
			// no suppressDisabledCheck flag, shuffle arguments
			if ( typeof suppressDisabledCheck !== "boolean" ) {
				handlers = element;
				element = suppressDisabledCheck;
				suppressDisabledCheck = false;
			}
	
			// no element argument, shuffle and use this.element
			if ( !handlers ) {
				handlers = element;
				element = this.element;
				delegateElement = this.widget();
			} else {
				// accept selectors, DOM elements
				element = delegateElement = $( element );
				this.bindings = this.bindings.add( element );
			}
	
			$.each( handlers, function( event, handler ) {
				function handlerProxy() {
					// allow widgets to customize the disabled handling
					// - disabled as an array instead of boolean
					// - disabled class as method for disabling individual parts
					if ( !suppressDisabledCheck &&
							( instance.options.disabled === true ||
								$( this ).hasClass( "ui-state-disabled" ) ) ) {
						return;
					}
					return ( typeof handler === "string" ? instance[ handler ] : handler )
						.apply( instance, arguments );
				}
	
				// copy the guid so direct unbinding works
				if ( typeof handler !== "string" ) {
					handlerProxy.guid = handler.guid =
						handler.guid || handlerProxy.guid || $.guid++;
				}
	
				var match = event.match( /^(\w+)\s*(.*)$/ ),
					eventName = match[1] + instance.eventNamespace,
					selector = match[2];
				if ( selector ) {
					delegateElement.delegate( selector, eventName, handlerProxy );
				} else {
					element.bind( eventName, handlerProxy );
				}
			});
		},
	
		_off: function( element, eventName ) {
			eventName = (eventName || "").split( " " ).join( this.eventNamespace + " " ) + this.eventNamespace;
			element.unbind( eventName ).undelegate( eventName );
		},
	
		_delay: function( handler, delay ) {
			function handlerProxy() {
				return ( typeof handler === "string" ? instance[ handler ] : handler )
					.apply( instance, arguments );
			}
			var instance = this;
			return setTimeout( handlerProxy, delay || 0 );
		},
	
		_hoverable: function( element ) {
			this.hoverable = this.hoverable.add( element );
			this._on( element, {
				mouseenter: function( event ) {
					$( event.currentTarget ).addClass( "ui-state-hover" );
				},
				mouseleave: function( event ) {
					$( event.currentTarget ).removeClass( "ui-state-hover" );
				}
			});
		},
	
		_focusable: function( element ) {
			this.focusable = this.focusable.add( element );
			this._on( element, {
				focusin: function( event ) {
					$( event.currentTarget ).addClass( "ui-state-focus" );
				},
				focusout: function( event ) {
					$( event.currentTarget ).removeClass( "ui-state-focus" );
				}
			});
		},
	
		_trigger: function( type, event, data ) {
			var prop, orig,
				callback = this.options[ type ];
	
			data = data || {};
			event = $.Event( event );
			event.type = ( type === this.widgetEventPrefix ?
				type :
				this.widgetEventPrefix + type ).toLowerCase();
			// the original event may come from any element
			// so we need to reset the target on the new event
			event.target = this.element[ 0 ];
	
			// copy original event properties over to the new event
			orig = event.originalEvent;
			if ( orig ) {
				for ( prop in orig ) {
					if ( !( prop in event ) ) {
						event[ prop ] = orig[ prop ];
					}
				}
			}
	
			this.element.trigger( event, data );
			return !( $.isFunction( callback ) &&
				callback.apply( this.element[0], [ event ].concat( data ) ) === false ||
				event.isDefaultPrevented() );
		}
	};
	
	$.each( { show: "fadeIn", hide: "fadeOut" }, function( method, defaultEffect ) {
		$.Widget.prototype[ "_" + method ] = function( element, options, callback ) {
			if ( typeof options === "string" ) {
				options = { effect: options };
			}
			var hasOptions,
				effectName = !options ?
					method :
					options === true || typeof options === "number" ?
						defaultEffect :
						options.effect || defaultEffect;
			options = options || {};
			if ( typeof options === "number" ) {
				options = { duration: options };
			}
			hasOptions = !$.isEmptyObject( options );
			options.complete = callback;
			if ( options.delay ) {
				element.delay( options.delay );
			}
			if ( hasOptions && $.effects && $.effects.effect[ effectName ] ) {
				element[ method ]( options );
			} else if ( effectName !== method && element[ effectName ] ) {
				element[ effectName ]( options.duration, options.easing, callback );
			} else {
				element.queue(function( next ) {
					$( this )[ method ]();
					if ( callback ) {
						callback.call( element[ 0 ] );
					}
					next();
				});
			}
		};
	});
	
	})( jQuery );
	(function( $, undefined ) {
	
	var mouseHandled = false;
	$( document ).mouseup( function() {
		mouseHandled = false;
	});
	
	$.widget("ui.mouse", {
		version: "1.10.3",
		options: {
			cancel: "input,textarea,button,select,option",
			distance: 1,
			delay: 0
		},
		_mouseInit: function() {
			var that = this;
	
			this.element
				.bind("mousedown."+this.widgetName, function(event) {
					return that._mouseDown(event);
				})
				.bind("click."+this.widgetName, function(event) {
					if (true === $.data(event.target, that.widgetName + ".preventClickEvent")) {
						$.removeData(event.target, that.widgetName + ".preventClickEvent");
						event.stopImmediatePropagation();
						return false;
					}
				});
	
			this.started = false;
		},
	
		// TODO: make sure destroying one instance of mouse doesn't mess with
		// other instances of mouse
		_mouseDestroy: function() {
			this.element.unbind("."+this.widgetName);
			if ( this._mouseMoveDelegate ) {
				$(document)
					.unbind("mousemove."+this.widgetName, this._mouseMoveDelegate)
					.unbind("mouseup."+this.widgetName, this._mouseUpDelegate);
			}
		},
	
		_mouseDown: function(event) {
			// don't let more than one widget handle mouseStart
			if( mouseHandled ) { return; }
	
			// we may have missed mouseup (out of window)
			(this._mouseStarted && this._mouseUp(event));
	
			this._mouseDownEvent = event;
	
			var that = this,
				btnIsLeft = (event.which === 1),
				// event.target.nodeName works around a bug in IE 8 with
				// disabled inputs (#7620)
				elIsCancel = (typeof this.options.cancel === "string" && event.target.nodeName ? $(event.target).closest(this.options.cancel).length : false);
			if (!btnIsLeft || elIsCancel || !this._mouseCapture(event)) {
				return true;
			}
	
			this.mouseDelayMet = !this.options.delay;
			if (!this.mouseDelayMet) {
				this._mouseDelayTimer = setTimeout(function() {
					that.mouseDelayMet = true;
				}, this.options.delay);
			}
	
			if (this._mouseDistanceMet(event) && this._mouseDelayMet(event)) {
				this._mouseStarted = (this._mouseStart(event) !== false);
				if (!this._mouseStarted) {
					event.preventDefault();
					return true;
				}
			}
	
			// Click event may never have fired (Gecko & Opera)
			if (true === $.data(event.target, this.widgetName + ".preventClickEvent")) {
				$.removeData(event.target, this.widgetName + ".preventClickEvent");
			}
	
			// these delegates are required to keep context
			this._mouseMoveDelegate = function(event) {
				return that._mouseMove(event);
			};
			this._mouseUpDelegate = function(event) {
				return that._mouseUp(event);
			};
			$(document)
				.bind("mousemove."+this.widgetName, this._mouseMoveDelegate)
				.bind("mouseup."+this.widgetName, this._mouseUpDelegate);
	
			event.preventDefault();
	
			mouseHandled = true;
			return true;
		},
	
		_mouseMove: function(event) {
			// IE mouseup check - mouseup happened when mouse was out of window
			if ($.ui.ie && ( !document.documentMode || document.documentMode < 9 ) && !event.button) {
				return this._mouseUp(event);
			}
	
			if (this._mouseStarted) {
				this._mouseDrag(event);
				return event.preventDefault();
			}
	
			if (this._mouseDistanceMet(event) && this._mouseDelayMet(event)) {
				this._mouseStarted =
					(this._mouseStart(this._mouseDownEvent, event) !== false);
				(this._mouseStarted ? this._mouseDrag(event) : this._mouseUp(event));
			}
	
			return !this._mouseStarted;
		},
	
		_mouseUp: function(event) {
			$(document)
				.unbind("mousemove."+this.widgetName, this._mouseMoveDelegate)
				.unbind("mouseup."+this.widgetName, this._mouseUpDelegate);
	
			if (this._mouseStarted) {
				this._mouseStarted = false;
	
				if (event.target === this._mouseDownEvent.target) {
					$.data(event.target, this.widgetName + ".preventClickEvent", true);
				}
	
				this._mouseStop(event);
			}
	
			return false;
		},
	
		_mouseDistanceMet: function(event) {
			return (Math.max(
					Math.abs(this._mouseDownEvent.pageX - event.pageX),
					Math.abs(this._mouseDownEvent.pageY - event.pageY)
				) >= this.options.distance
			);
		},
	
		_mouseDelayMet: function(/* event */) {
			return this.mouseDelayMet;
		},
	
		// These are placeholder methods, to be overriden by extending plugin
		_mouseStart: function(/* event */) {},
		_mouseDrag: function(/* event */) {},
		_mouseStop: function(/* event */) {},
		_mouseCapture: function(/* event */) { return true; }
	});
	
	})(jQuery);
	(function( $, undefined ) {
	
	/*jshint loopfunc: true */
	
	function isOverAxis( x, reference, size ) {
		return ( x > reference ) && ( x < ( reference + size ) );
	}
	
	function isFloating(item) {
		return (/left|right/).test(item.css("float")) || (/inline|table-cell/).test(item.css("display"));
	}
	
	$.widget("ui.sortable", $.ui.mouse, {
		version: "1.10.3",
		widgetEventPrefix: "sort",
		ready: false,
		options: {
			appendTo: "parent",
			axis: false,
			connectWith: false,
			containment: false,
			cursor: "auto",
			cursorAt: false,
			dropOnEmpty: true,
			forcePlaceholderSize: false,
			forceHelperSize: false,
			grid: false,
			handle: false,
			helper: "original",
			items: "> *",
			opacity: false,
			placeholder: false,
			revert: false,
			scroll: true,
			scrollSensitivity: 20,
			scrollSpeed: 20,
			scope: "default",
			tolerance: "intersect",
			zIndex: 1000,
	
			// callbacks
			activate: null,
			beforeStop: null,
			change: null,
			deactivate: null,
			out: null,
			over: null,
			receive: null,
			remove: null,
			sort: null,
			start: null,
			stop: null,
			update: null
		},
		_create: function() {
	
			var o = this.options;
			this.containerCache = {};
			this.element.addClass("ui-sortable");
	
			//Get the items
			this.refresh();
	
			//Let's determine if the items are being displayed horizontally
			this.floating = this.items.length ? o.axis === "x" || isFloating(this.items[0].item) : false;
	
			//Let's determine the parent's offset
			this.offset = this.element.offset();
	
			//Initialize mouse events for interaction
			this._mouseInit();
	
			//We're ready to go
			this.ready = true;
	
		},
	
		_destroy: function() {
			this.element
				.removeClass("ui-sortable ui-sortable-disabled");
			this._mouseDestroy();
	
			for ( var i = this.items.length - 1; i >= 0; i-- ) {
				this.items[i].item.removeData(this.widgetName + "-item");
			}
	
			return this;
		},
	
		_setOption: function(key, value){
			if ( key === "disabled" ) {
				this.options[ key ] = value;
	
				this.widget().toggleClass( "ui-sortable-disabled", !!value );
			} else {
				// Don't call widget base _setOption for disable as it adds ui-state-disabled class
				$.Widget.prototype._setOption.apply(this, arguments);
			}
		},
	
		_mouseCapture: function(event, overrideHandle) {
			var currentItem = null,
				validHandle = false,
				that = this;
	
			if (this.reverting) {
				return false;
			}
	
			if(this.options.disabled || this.options.type === "static") {
				return false;
			}
	
			//We have to refresh the items data once first
			this._refreshItems(event);
	
			//Find out if the clicked node (or one of its parents) is a actual item in this.items
			$(event.target).parents().each(function() {
				if($.data(this, that.widgetName + "-item") === that) {
					currentItem = $(this);
					return false;
				}
			});
			if($.data(event.target, that.widgetName + "-item") === that) {
				currentItem = $(event.target);
			}
	
			if(!currentItem) {
				return false;
			}
			if(this.options.handle && !overrideHandle) {
				$(this.options.handle, currentItem).find("*").addBack().each(function() {
					if(this === event.target) {
						validHandle = true;
					}
				});
				if(!validHandle) {
					return false;
				}
			}
	
			this.currentItem = currentItem;
			this._removeCurrentsFromItems();
			return true;
	
		},
	
		_mouseStart: function(event, overrideHandle, noActivation) {
	
			var i, body,
				o = this.options;
	
			this.currentContainer = this;
	
			//We only need to call refreshPositions, because the refreshItems call has been moved to mouseCapture
			this.refreshPositions();
	
			//Create and append the visible helper
			this.helper = this._createHelper(event);
	
			//Cache the helper size
			this._cacheHelperProportions();
	
			/*
			 * - Position generation -
			 * This block generates everything position related - it's the core of draggables.
			 */
	
			//Cache the margins of the original element
			this._cacheMargins();
	
			//Get the next scrolling parent
			this.scrollParent = this.helper.scrollParent();
	
			//The element's absolute position on the page minus margins
			this.offset = this.currentItem.offset();
			this.offset = {
				top: this.offset.top - this.margins.top,
				left: this.offset.left - this.margins.left
			};
	
			$.extend(this.offset, {
				click: { //Where the click happened, relative to the element
					left: event.pageX - this.offset.left,
					top: event.pageY - this.offset.top
				},
				parent: this._getParentOffset(),
				relative: this._getRelativeOffset() //This is a relative to absolute position minus the actual position calculation - only used for relative positioned helper
			});
	
			// Only after we got the offset, we can change the helper's position to absolute
			// TODO: Still need to figure out a way to make relative sorting possible
			this.helper.css("position", "absolute");
			this.cssPosition = this.helper.css("position");
	
			//Generate the original position
			this.originalPosition = this._generatePosition(event);
			this.originalPageX = event.pageX;
			this.originalPageY = event.pageY;
	
			//Adjust the mouse offset relative to the helper if "cursorAt" is supplied
			(o.cursorAt && this._adjustOffsetFromHelper(o.cursorAt));
	
			//Cache the former DOM position
			this.domPosition = { prev: this.currentItem.prev()[0], parent: this.currentItem.parent()[0] };
	
			//If the helper is not the original, hide the original so it's not playing any role during the drag, won't cause anything bad this way
			if(this.helper[0] !== this.currentItem[0]) {
				this.currentItem.hide();
			}
	
			//Create the placeholder
			this._createPlaceholder();
	
			//Set a containment if given in the options
			if(o.containment) {
				this._setContainment();
			}
	
			if( o.cursor && o.cursor !== "auto" ) { // cursor option
				body = this.document.find( "body" );
	
				// support: IE
				this.storedCursor = body.css( "cursor" );
				body.css( "cursor", o.cursor );
	
				this.storedStylesheet = $( "<style>*{ cursor: "+o.cursor+" !important; }</style>" ).appendTo( body );
			}
	
			if(o.opacity) { // opacity option
				if (this.helper.css("opacity")) {
					this._storedOpacity = this.helper.css("opacity");
				}
				this.helper.css("opacity", o.opacity);
			}
	
			if(o.zIndex) { // zIndex option
				if (this.helper.css("zIndex")) {
					this._storedZIndex = this.helper.css("zIndex");
				}
				this.helper.css("zIndex", o.zIndex);
			}
	
			//Prepare scrolling
			if(this.scrollParent[0] !== document && this.scrollParent[0].tagName !== "HTML") {
				this.overflowOffset = this.scrollParent.offset();
			}
	
			//Call callbacks
			this._trigger("start", event, this._uiHash());
	
			//Recache the helper size
			if(!this._preserveHelperProportions) {
				this._cacheHelperProportions();
			}
	
	
			//Post "activate" events to possible containers
			if( !noActivation ) {
				for ( i = this.containers.length - 1; i >= 0; i-- ) {
					this.containers[ i ]._trigger( "activate", event, this._uiHash( this ) );
				}
			}
	
			//Prepare possible droppables
			if($.ui.ddmanager) {
				$.ui.ddmanager.current = this;
			}
	
			if ($.ui.ddmanager && !o.dropBehaviour) {
				$.ui.ddmanager.prepareOffsets(this, event);
			}
	
			this.dragging = true;
	
			this.helper.addClass("ui-sortable-helper");
			this._mouseDrag(event); //Execute the drag once - this causes the helper not to be visible before getting its correct position
			return true;
	
		},
	
		_mouseDrag: function(event) {
			var i, item, itemElement, intersection,
				o = this.options,
				scrolled = false;
	
			//Compute the helpers position
			this.position = this._generatePosition(event);
			this.positionAbs = this._convertPositionTo("absolute");
	
			if (!this.lastPositionAbs) {
				this.lastPositionAbs = this.positionAbs;
			}
	
			//Do scrolling
			if(this.options.scroll) {
				if(this.scrollParent[0] !== document && this.scrollParent[0].tagName !== "HTML") {
	
					if((this.overflowOffset.top + this.scrollParent[0].offsetHeight) - event.pageY < o.scrollSensitivity) {
						this.scrollParent[0].scrollTop = scrolled = this.scrollParent[0].scrollTop + o.scrollSpeed;
					} else if(event.pageY - this.overflowOffset.top < o.scrollSensitivity) {
						this.scrollParent[0].scrollTop = scrolled = this.scrollParent[0].scrollTop - o.scrollSpeed;
					}
	
					if((this.overflowOffset.left + this.scrollParent[0].offsetWidth) - event.pageX < o.scrollSensitivity) {
						this.scrollParent[0].scrollLeft = scrolled = this.scrollParent[0].scrollLeft + o.scrollSpeed;
					} else if(event.pageX - this.overflowOffset.left < o.scrollSensitivity) {
						this.scrollParent[0].scrollLeft = scrolled = this.scrollParent[0].scrollLeft - o.scrollSpeed;
					}
	
				} else {
	
					if(event.pageY - $(document).scrollTop() < o.scrollSensitivity) {
						scrolled = $(document).scrollTop($(document).scrollTop() - o.scrollSpeed);
					} else if($(window).height() - (event.pageY - $(document).scrollTop()) < o.scrollSensitivity) {
						scrolled = $(document).scrollTop($(document).scrollTop() + o.scrollSpeed);
					}
	
					if(event.pageX - $(document).scrollLeft() < o.scrollSensitivity) {
						scrolled = $(document).scrollLeft($(document).scrollLeft() - o.scrollSpeed);
					} else if($(window).width() - (event.pageX - $(document).scrollLeft()) < o.scrollSensitivity) {
						scrolled = $(document).scrollLeft($(document).scrollLeft() + o.scrollSpeed);
					}
	
				}
	
				if(scrolled !== false && $.ui.ddmanager && !o.dropBehaviour) {
					$.ui.ddmanager.prepareOffsets(this, event);
				}
			}
	
			//Regenerate the absolute position used for position checks
			this.positionAbs = this._convertPositionTo("absolute");
	
			//Set the helper position
			if(!this.options.axis || this.options.axis !== "y") {
				this.helper[0].style.left = this.position.left+"px";
			}
			if(!this.options.axis || this.options.axis !== "x") {
				this.helper[0].style.top = this.position.top+"px";
			}
	
			//Rearrange
			for (i = this.items.length - 1; i >= 0; i--) {
	
				//Cache variables and intersection, continue if no intersection
				item = this.items[i];
				itemElement = item.item[0];
				intersection = this._intersectsWithPointer(item);
				if (!intersection) {
					continue;
				}
	
				// Only put the placeholder inside the current Container, skip all
				// items form other containers. This works because when moving
				// an item from one container to another the
				// currentContainer is switched before the placeholder is moved.
				//
				// Without this moving items in "sub-sortables" can cause the placeholder to jitter
				// beetween the outer and inner container.
				if (item.instance !== this.currentContainer) {
					continue;
				}
	
				// cannot intersect with itself
				// no useless actions that have been done before
				// no action if the item moved is the parent of the item checked
				if (itemElement !== this.currentItem[0] &&
					this.placeholder[intersection === 1 ? "next" : "prev"]()[0] !== itemElement &&
					!$.contains(this.placeholder[0], itemElement) &&
					(this.options.type === "semi-dynamic" ? !$.contains(this.element[0], itemElement) : true)
				) {
	
					this.direction = intersection === 1 ? "down" : "up";
	
					if (this.options.tolerance === "pointer" || this._intersectsWithSides(item)) {
						this._rearrange(event, item);
					} else {
						break;
					}
	
					this._trigger("change", event, this._uiHash());
					break;
				}
			}
	
			//Post events to containers
			this._contactContainers(event);
	
			//Interconnect with droppables
			if($.ui.ddmanager) {
				$.ui.ddmanager.drag(this, event);
			}
	
			//Call callbacks
			this._trigger("sort", event, this._uiHash());
	
			this.lastPositionAbs = this.positionAbs;
			return false;
	
		},
	
		_mouseStop: function(event, noPropagation) {
	
			if(!event) {
				return;
			}
	
			//If we are using droppables, inform the manager about the drop
			if ($.ui.ddmanager && !this.options.dropBehaviour) {
				$.ui.ddmanager.drop(this, event);
			}
	
			if(this.options.revert) {
				var that = this,
					cur = this.placeholder.offset(),
					axis = this.options.axis,
					animation = {};
	
				if ( !axis || axis === "x" ) {
					animation.left = cur.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollLeft);
				}
				if ( !axis || axis === "y" ) {
					animation.top = cur.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollTop);
				}
				this.reverting = true;
				$(this.helper).animate( animation, parseInt(this.options.revert, 10) || 500, function() {
					that._clear(event);
				});
			} else {
				this._clear(event, noPropagation);
			}
	
			return false;
	
		},
	
		cancel: function() {
	
			if(this.dragging) {
	
				this._mouseUp({ target: null });
	
				if(this.options.helper === "original") {
					this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper");
				} else {
					this.currentItem.show();
				}
	
				//Post deactivating events to containers
				for (var i = this.containers.length - 1; i >= 0; i--){
					this.containers[i]._trigger("deactivate", null, this._uiHash(this));
					if(this.containers[i].containerCache.over) {
						this.containers[i]._trigger("out", null, this._uiHash(this));
						this.containers[i].containerCache.over = 0;
					}
				}
	
			}
	
			if (this.placeholder) {
				//$(this.placeholder[0]).remove(); would have been the jQuery way - unfortunately, it unbinds ALL events from the original node!
				if(this.placeholder[0].parentNode) {
					this.placeholder[0].parentNode.removeChild(this.placeholder[0]);
				}
				if(this.options.helper !== "original" && this.helper && this.helper[0].parentNode) {
					this.helper.remove();
				}
	
				$.extend(this, {
					helper: null,
					dragging: false,
					reverting: false,
					_noFinalSort: null
				});
	
				if(this.domPosition.prev) {
					$(this.domPosition.prev).after(this.currentItem);
				} else {
					$(this.domPosition.parent).prepend(this.currentItem);
				}
			}
	
			return this;
	
		},
	
		serialize: function(o) {
	
			var items = this._getItemsAsjQuery(o && o.connected),
				str = [];
			o = o || {};
	
			$(items).each(function() {
				var res = ($(o.item || this).attr(o.attribute || "id") || "").match(o.expression || (/(.+)[\-=_](.+)/));
				if (res) {
					str.push((o.key || res[1]+"[]")+"="+(o.key && o.expression ? res[1] : res[2]));
				}
			});
	
			if(!str.length && o.key) {
				str.push(o.key + "=");
			}
	
			return str.join("&");
	
		},
	
		toArray: function(o) {
	
			var items = this._getItemsAsjQuery(o && o.connected),
				ret = [];
	
			o = o || {};
	
			items.each(function() { ret.push($(o.item || this).attr(o.attribute || "id") || ""); });
			return ret;
	
		},
	
		/* Be careful with the following core functions */
		_intersectsWith: function(item) {
	
			var x1 = this.positionAbs.left,
				x2 = x1 + this.helperProportions.width,
				y1 = this.positionAbs.top,
				y2 = y1 + this.helperProportions.height,
				l = item.left,
				r = l + item.width,
				t = item.top,
				b = t + item.height,
				dyClick = this.offset.click.top,
				dxClick = this.offset.click.left,
				isOverElementHeight = ( this.options.axis === "x" ) || ( ( y1 + dyClick ) > t && ( y1 + dyClick ) < b ),
				isOverElementWidth = ( this.options.axis === "y" ) || ( ( x1 + dxClick ) > l && ( x1 + dxClick ) < r ),
				isOverElement = isOverElementHeight && isOverElementWidth;
	
			if ( this.options.tolerance === "pointer" ||
				this.options.forcePointerForContainers ||
				(this.options.tolerance !== "pointer" && this.helperProportions[this.floating ? "width" : "height"] > item[this.floating ? "width" : "height"])
			) {
				return isOverElement;
			} else {
	
				return (l < x1 + (this.helperProportions.width / 2) && // Right Half
					x2 - (this.helperProportions.width / 2) < r && // Left Half
					t < y1 + (this.helperProportions.height / 2) && // Bottom Half
					y2 - (this.helperProportions.height / 2) < b ); // Top Half
	
			}
		},
	
		_intersectsWithPointer: function(item) {
	
			var isOverElementHeight = (this.options.axis === "x") || isOverAxis(this.positionAbs.top + this.offset.click.top, item.top, item.height),
				isOverElementWidth = (this.options.axis === "y") || isOverAxis(this.positionAbs.left + this.offset.click.left, item.left, item.width),
				isOverElement = isOverElementHeight && isOverElementWidth,
				verticalDirection = this._getDragVerticalDirection(),
				horizontalDirection = this._getDragHorizontalDirection();
	
			if (!isOverElement) {
				return false;
			}
	
			return this.floating ?
				( ((horizontalDirection && horizontalDirection === "right") || verticalDirection === "down") ? 2 : 1 )
				: ( verticalDirection && (verticalDirection === "down" ? 2 : 1) );
	
		},
	
		_intersectsWithSides: function(item) {
	
			var isOverBottomHalf = isOverAxis(this.positionAbs.top + this.offset.click.top, item.top + (item.height/2), item.height),
				isOverRightHalf = isOverAxis(this.positionAbs.left + this.offset.click.left, item.left + (item.width/2), item.width),
				verticalDirection = this._getDragVerticalDirection(),
				horizontalDirection = this._getDragHorizontalDirection();
	
			if (this.floating && horizontalDirection) {
				return ((horizontalDirection === "right" && isOverRightHalf) || (horizontalDirection === "left" && !isOverRightHalf));
			} else {
				return verticalDirection && ((verticalDirection === "down" && isOverBottomHalf) || (verticalDirection === "up" && !isOverBottomHalf));
			}
	
		},
	
		_getDragVerticalDirection: function() {
			var delta = this.positionAbs.top - this.lastPositionAbs.top;
			return delta !== 0 && (delta > 0 ? "down" : "up");
		},
	
		_getDragHorizontalDirection: function() {
			var delta = this.positionAbs.left - this.lastPositionAbs.left;
			return delta !== 0 && (delta > 0 ? "right" : "left");
		},
	
		refresh: function(event) {
			this._refreshItems(event);
			this.refreshPositions();
			return this;
		},
	
		_connectWith: function() {
			var options = this.options;
			return options.connectWith.constructor === String ? [options.connectWith] : options.connectWith;
		},
	
		_getItemsAsjQuery: function(connected) {
	
			var i, j, cur, inst,
				items = [],
				queries = [],
				connectWith = this._connectWith();
	
			if(connectWith && connected) {
				for (i = connectWith.length - 1; i >= 0; i--){
					cur = $(connectWith[i]);
					for ( j = cur.length - 1; j >= 0; j--){
						inst = $.data(cur[j], this.widgetFullName);
						if(inst && inst !== this && !inst.options.disabled) {
							queries.push([$.isFunction(inst.options.items) ? inst.options.items.call(inst.element) : $(inst.options.items, inst.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), inst]);
						}
					}
				}
			}
	
			queries.push([$.isFunction(this.options.items) ? this.options.items.call(this.element, null, { options: this.options, item: this.currentItem }) : $(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]);
	
			for (i = queries.length - 1; i >= 0; i--){
				queries[i][0].each(function() {
					items.push(this);
				});
			}
	
			return $(items);
	
		},
	
		_removeCurrentsFromItems: function() {
	
			var list = this.currentItem.find(":data(" + this.widgetName + "-item)");
	
			this.items = $.grep(this.items, function (item) {
				for (var j=0; j < list.length; j++) {
					if(list[j] === item.item[0]) {
						return false;
					}
				}
				return true;
			});
	
		},
	
		_refreshItems: function(event) {
	
			this.items = [];
			this.containers = [this];
	
			var i, j, cur, inst, targetData, _queries, item, queriesLength,
				items = this.items,
				queries = [[$.isFunction(this.options.items) ? this.options.items.call(this.element[0], event, { item: this.currentItem }) : $(this.options.items, this.element), this]],
				connectWith = this._connectWith();
	
			if(connectWith && this.ready) { //Shouldn't be run the first time through due to massive slow-down
				for (i = connectWith.length - 1; i >= 0; i--){
					cur = $(connectWith[i]);
					for (j = cur.length - 1; j >= 0; j--){
						inst = $.data(cur[j], this.widgetFullName);
						if(inst && inst !== this && !inst.options.disabled) {
							queries.push([$.isFunction(inst.options.items) ? inst.options.items.call(inst.element[0], event, { item: this.currentItem }) : $(inst.options.items, inst.element), inst]);
							this.containers.push(inst);
						}
					}
				}
			}
	
			for (i = queries.length - 1; i >= 0; i--) {
				targetData = queries[i][1];
				_queries = queries[i][0];
	
				for (j=0, queriesLength = _queries.length; j < queriesLength; j++) {
					item = $(_queries[j]);
	
					item.data(this.widgetName + "-item", targetData); // Data for target checking (mouse manager)
	
					items.push({
						item: item,
						instance: targetData,
						width: 0, height: 0,
						left: 0, top: 0
					});
				}
			}
	
		},
	
		refreshPositions: function(fast) {
	
			//This has to be redone because due to the item being moved out/into the offsetParent, the offsetParent's position will change
			if(this.offsetParent && this.helper) {
				this.offset.parent = this._getParentOffset();
			}
	
			var i, item, t, p;
	
			for (i = this.items.length - 1; i >= 0; i--){
				item = this.items[i];
	
				//We ignore calculating positions of all connected containers when we're not over them
				if(item.instance !== this.currentContainer && this.currentContainer && item.item[0] !== this.currentItem[0]) {
					continue;
				}
	
				t = this.options.toleranceElement ? $(this.options.toleranceElement, item.item) : item.item;
	
				if (!fast) {
					item.width = t.outerWidth();
					item.height = t.outerHeight();
				}
	
				p = t.offset();
				item.left = p.left;
				item.top = p.top;
			}
	
			if(this.options.custom && this.options.custom.refreshContainers) {
				this.options.custom.refreshContainers.call(this);
			} else {
				for (i = this.containers.length - 1; i >= 0; i--){
					p = this.containers[i].element.offset();
					this.containers[i].containerCache.left = p.left;
					this.containers[i].containerCache.top = p.top;
					this.containers[i].containerCache.width	= this.containers[i].element.outerWidth();
					this.containers[i].containerCache.height = this.containers[i].element.outerHeight();
				}
			}
	
			return this;
		},
	
		_createPlaceholder: function(that) {
			that = that || this;
			var className,
				o = that.options;
	
			if(!o.placeholder || o.placeholder.constructor === String) {
				className = o.placeholder;
				o.placeholder = {
					element: function() {
	
						var nodeName = that.currentItem[0].nodeName.toLowerCase(),
							element = $( "<" + nodeName + ">", that.document[0] )
								.addClass(className || that.currentItem[0].className+" ui-sortable-placeholder")
								.removeClass("ui-sortable-helper");
	
						if ( nodeName === "tr" ) {
							that.currentItem.children().each(function() {
								$( "<td>&#160;</td>", that.document[0] )
									.attr( "colspan", $( this ).attr( "colspan" ) || 1 )
									.appendTo( element );
							});
						} else if ( nodeName === "img" ) {
							element.attr( "src", that.currentItem.attr( "src" ) );
						}
	
						if ( !className ) {
							element.css( "visibility", "hidden" );
						}
	
						return element;
					},
					update: function(container, p) {
	
						// 1. If a className is set as 'placeholder option, we don't force sizes - the class is responsible for that
						// 2. The option 'forcePlaceholderSize can be enabled to force it even if a class name is specified
						if(className && !o.forcePlaceholderSize) {
							return;
						}
	
						//If the element doesn't have a actual height by itself (without styles coming from a stylesheet), it receives the inline height from the dragged item
						if(!p.height()) { p.height(that.currentItem.innerHeight() - parseInt(that.currentItem.css("paddingTop")||0, 10) - parseInt(that.currentItem.css("paddingBottom")||0, 10)); }
						if(!p.width()) { p.width(that.currentItem.innerWidth() - parseInt(that.currentItem.css("paddingLeft")||0, 10) - parseInt(that.currentItem.css("paddingRight")||0, 10)); }
					}
				};
			}
	
			//Create the placeholder
			that.placeholder = $(o.placeholder.element.call(that.element, that.currentItem));
	
			//Append it after the actual current item
			that.currentItem.after(that.placeholder);
	
			//Update the size of the placeholder (TODO: Logic to fuzzy, see line 316/317)
			o.placeholder.update(that, that.placeholder);
	
		},
	
		_contactContainers: function(event) {
			var i, j, dist, itemWithLeastDistance, posProperty, sizeProperty, base, cur, nearBottom, floating,
				innermostContainer = null,
				innermostIndex = null;
	
			// get innermost container that intersects with item
			for (i = this.containers.length - 1; i >= 0; i--) {
	
				// never consider a container that's located within the item itself
				if($.contains(this.currentItem[0], this.containers[i].element[0])) {
					continue;
				}
	
				if(this._intersectsWith(this.containers[i].containerCache)) {
	
					// if we've already found a container and it's more "inner" than this, then continue
					if(innermostContainer && $.contains(this.containers[i].element[0], innermostContainer.element[0])) {
						continue;
					}
	
					innermostContainer = this.containers[i];
					innermostIndex = i;
	
				} else {
					// container doesn't intersect. trigger "out" event if necessary
					if(this.containers[i].containerCache.over) {
						this.containers[i]._trigger("out", event, this._uiHash(this));
						this.containers[i].containerCache.over = 0;
					}
				}
	
			}
	
			// if no intersecting containers found, return
			if(!innermostContainer) {
				return;
			}
	
			// move the item into the container if it's not there already
			if(this.containers.length === 1) {
				if (!this.containers[innermostIndex].containerCache.over) {
					this.containers[innermostIndex]._trigger("over", event, this._uiHash(this));
					this.containers[innermostIndex].containerCache.over = 1;
				}
			} else {
	
				//When entering a new container, we will find the item with the least distance and append our item near it
				dist = 10000;
				itemWithLeastDistance = null;
				floating = innermostContainer.floating || isFloating(this.currentItem);
				posProperty = floating ? "left" : "top";
				sizeProperty = floating ? "width" : "height";
				base = this.positionAbs[posProperty] + this.offset.click[posProperty];
				for (j = this.items.length - 1; j >= 0; j--) {
					if(!$.contains(this.containers[innermostIndex].element[0], this.items[j].item[0])) {
						continue;
					}
					if(this.items[j].item[0] === this.currentItem[0]) {
						continue;
					}
					if (floating && !isOverAxis(this.positionAbs.top + this.offset.click.top, this.items[j].top, this.items[j].height)) {
						continue;
					}
					cur = this.items[j].item.offset()[posProperty];
					nearBottom = false;
					if(Math.abs(cur - base) > Math.abs(cur + this.items[j][sizeProperty] - base)){
						nearBottom = true;
						cur += this.items[j][sizeProperty];
					}
	
					if(Math.abs(cur - base) < dist) {
						dist = Math.abs(cur - base); itemWithLeastDistance = this.items[j];
						this.direction = nearBottom ? "up": "down";
					}
				}
	
				//Check if dropOnEmpty is enabled
				if(!itemWithLeastDistance && !this.options.dropOnEmpty) {
					return;
				}
	
				if(this.currentContainer === this.containers[innermostIndex]) {
					return;
				}
	
				itemWithLeastDistance ? this._rearrange(event, itemWithLeastDistance, null, true) : this._rearrange(event, null, this.containers[innermostIndex].element, true);
				this._trigger("change", event, this._uiHash());
				this.containers[innermostIndex]._trigger("change", event, this._uiHash(this));
				this.currentContainer = this.containers[innermostIndex];
	
				//Update the placeholder
				this.options.placeholder.update(this.currentContainer, this.placeholder);
	
				this.containers[innermostIndex]._trigger("over", event, this._uiHash(this));
				this.containers[innermostIndex].containerCache.over = 1;
			}
	
	
		},
	
		_createHelper: function(event) {
	
			var o = this.options,
				helper = $.isFunction(o.helper) ? $(o.helper.apply(this.element[0], [event, this.currentItem])) : (o.helper === "clone" ? this.currentItem.clone() : this.currentItem);
	
			//Add the helper to the DOM if that didn't happen already
			if(!helper.parents("body").length) {
				$(o.appendTo !== "parent" ? o.appendTo : this.currentItem[0].parentNode)[0].appendChild(helper[0]);
			}
	
			if(helper[0] === this.currentItem[0]) {
				this._storedCSS = { width: this.currentItem[0].style.width, height: this.currentItem[0].style.height, position: this.currentItem.css("position"), top: this.currentItem.css("top"), left: this.currentItem.css("left") };
			}
	
			if(!helper[0].style.width || o.forceHelperSize) {
				helper.width(this.currentItem.width());
			}
			if(!helper[0].style.height || o.forceHelperSize) {
				helper.height(this.currentItem.height());
			}
	
			return helper;
	
		},
	
		_adjustOffsetFromHelper: function(obj) {
			if (typeof obj === "string") {
				obj = obj.split(" ");
			}
			if ($.isArray(obj)) {
				obj = {left: +obj[0], top: +obj[1] || 0};
			}
			if ("left" in obj) {
				this.offset.click.left = obj.left + this.margins.left;
			}
			if ("right" in obj) {
				this.offset.click.left = this.helperProportions.width - obj.right + this.margins.left;
			}
			if ("top" in obj) {
				this.offset.click.top = obj.top + this.margins.top;
			}
			if ("bottom" in obj) {
				this.offset.click.top = this.helperProportions.height - obj.bottom + this.margins.top;
			}
		},
	
		_getParentOffset: function() {
	
	
			//Get the offsetParent and cache its position
			this.offsetParent = this.helper.offsetParent();
			var po = this.offsetParent.offset();
	
			// This is a special case where we need to modify a offset calculated on start, since the following happened:
			// 1. The position of the helper is absolute, so it's position is calculated based on the next positioned parent
			// 2. The actual offset parent is a child of the scroll parent, and the scroll parent isn't the document, which means that
			//    the scroll is included in the initial calculation of the offset of the parent, and never recalculated upon drag
			if(this.cssPosition === "absolute" && this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) {
				po.left += this.scrollParent.scrollLeft();
				po.top += this.scrollParent.scrollTop();
			}
	
			// This needs to be actually done for all browsers, since pageX/pageY includes this information
			// with an ugly IE fix
			if( this.offsetParent[0] === document.body || (this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() === "html" && $.ui.ie)) {
				po = { top: 0, left: 0 };
			}
	
			return {
				top: po.top + (parseInt(this.offsetParent.css("borderTopWidth"),10) || 0),
				left: po.left + (parseInt(this.offsetParent.css("borderLeftWidth"),10) || 0)
			};
	
		},
	
		_getRelativeOffset: function() {
	
			if(this.cssPosition === "relative") {
				var p = this.currentItem.position();
				return {
					top: p.top - (parseInt(this.helper.css("top"),10) || 0) + this.scrollParent.scrollTop(),
					left: p.left - (parseInt(this.helper.css("left"),10) || 0) + this.scrollParent.scrollLeft()
				};
			} else {
				return { top: 0, left: 0 };
			}
	
		},
	
		_cacheMargins: function() {
			this.margins = {
				left: (parseInt(this.currentItem.css("marginLeft"),10) || 0),
				top: (parseInt(this.currentItem.css("marginTop"),10) || 0)
			};
		},
	
		_cacheHelperProportions: function() {
			this.helperProportions = {
				width: this.helper.outerWidth(),
				height: this.helper.outerHeight()
			};
		},
	
		_setContainment: function() {
	
			var ce, co, over,
				o = this.options;
			if(o.containment === "parent") {
				o.containment = this.helper[0].parentNode;
			}
			if(o.containment === "document" || o.containment === "window") {
				this.containment = [
					0 - this.offset.relative.left - this.offset.parent.left,
					0 - this.offset.relative.top - this.offset.parent.top,
					$(o.containment === "document" ? document : window).width() - this.helperProportions.width - this.margins.left,
					($(o.containment === "document" ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top
				];
			}
	
			if(!(/^(document|window|parent)$/).test(o.containment)) {
				ce = $(o.containment)[0];
				co = $(o.containment).offset();
				over = ($(ce).css("overflow") !== "hidden");
	
				this.containment = [
					co.left + (parseInt($(ce).css("borderLeftWidth"),10) || 0) + (parseInt($(ce).css("paddingLeft"),10) || 0) - this.margins.left,
					co.top + (parseInt($(ce).css("borderTopWidth"),10) || 0) + (parseInt($(ce).css("paddingTop"),10) || 0) - this.margins.top,
					co.left+(over ? Math.max(ce.scrollWidth,ce.offsetWidth) : ce.offsetWidth) - (parseInt($(ce).css("borderLeftWidth"),10) || 0) - (parseInt($(ce).css("paddingRight"),10) || 0) - this.helperProportions.width - this.margins.left,
					co.top+(over ? Math.max(ce.scrollHeight,ce.offsetHeight) : ce.offsetHeight) - (parseInt($(ce).css("borderTopWidth"),10) || 0) - (parseInt($(ce).css("paddingBottom"),10) || 0) - this.helperProportions.height - this.margins.top
				];
			}
	
		},
	
		_convertPositionTo: function(d, pos) {
	
			if(!pos) {
				pos = this.position;
			}
			var mod = d === "absolute" ? 1 : -1,
				scroll = this.cssPosition === "absolute" && !(this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent,
				scrollIsRootNode = (/(html|body)/i).test(scroll[0].tagName);
	
			return {
				top: (
					pos.top	+																// The absolute mouse position
					this.offset.relative.top * mod +										// Only for relative positioned nodes: Relative offset from element to offset parent
					this.offset.parent.top * mod -											// The offsetParent's offset without borders (offset + border)
					( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : ( scrollIsRootNode ? 0 : scroll.scrollTop() ) ) * mod)
				),
				left: (
					pos.left +																// The absolute mouse position
					this.offset.relative.left * mod +										// Only for relative positioned nodes: Relative offset from element to offset parent
					this.offset.parent.left * mod	-										// The offsetParent's offset without borders (offset + border)
					( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 : scroll.scrollLeft() ) * mod)
				)
			};
	
		},
	
		_generatePosition: function(event) {
	
			var top, left,
				o = this.options,
				pageX = event.pageX,
				pageY = event.pageY,
				scroll = this.cssPosition === "absolute" && !(this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent, scrollIsRootNode = (/(html|body)/i).test(scroll[0].tagName);
	
			// This is another very weird special case that only happens for relative elements:
			// 1. If the css position is relative
			// 2. and the scroll parent is the document or similar to the offset parent
			// we have to refresh the relative offset during the scroll so there are no jumps
			if(this.cssPosition === "relative" && !(this.scrollParent[0] !== document && this.scrollParent[0] !== this.offsetParent[0])) {
				this.offset.relative = this._getRelativeOffset();
			}
	
			/*
			 * - Position constraining -
			 * Constrain the position to a mix of grid, containment.
			 */
	
			if(this.originalPosition) { //If we are not dragging yet, we won't check for options
	
				if(this.containment) {
					if(event.pageX - this.offset.click.left < this.containment[0]) {
						pageX = this.containment[0] + this.offset.click.left;
					}
					if(event.pageY - this.offset.click.top < this.containment[1]) {
						pageY = this.containment[1] + this.offset.click.top;
					}
					if(event.pageX - this.offset.click.left > this.containment[2]) {
						pageX = this.containment[2] + this.offset.click.left;
					}
					if(event.pageY - this.offset.click.top > this.containment[3]) {
						pageY = this.containment[3] + this.offset.click.top;
					}
				}
	
				if(o.grid) {
					top = this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1];
					pageY = this.containment ? ( (top - this.offset.click.top >= this.containment[1] && top - this.offset.click.top <= this.containment[3]) ? top : ((top - this.offset.click.top >= this.containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;
	
					left = this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0];
					pageX = this.containment ? ( (left - this.offset.click.left >= this.containment[0] && left - this.offset.click.left <= this.containment[2]) ? left : ((left - this.offset.click.left >= this.containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
				}
	
			}
	
			return {
				top: (
					pageY -																// The absolute mouse position
					this.offset.click.top -													// Click offset (relative to the element)
					this.offset.relative.top	-											// Only for relative positioned nodes: Relative offset from element to offset parent
					this.offset.parent.top +												// The offsetParent's offset without borders (offset + border)
					( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : ( scrollIsRootNode ? 0 : scroll.scrollTop() ) ))
				),
				left: (
					pageX -																// The absolute mouse position
					this.offset.click.left -												// Click offset (relative to the element)
					this.offset.relative.left	-											// Only for relative positioned nodes: Relative offset from element to offset parent
					this.offset.parent.left +												// The offsetParent's offset without borders (offset + border)
					( ( this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 : scroll.scrollLeft() ))
				)
			};
	
		},
	
		_rearrange: function(event, i, a, hardRefresh) {
	
			a ? a[0].appendChild(this.placeholder[0]) : i.item[0].parentNode.insertBefore(this.placeholder[0], (this.direction === "down" ? i.item[0] : i.item[0].nextSibling));
	
			//Various things done here to improve the performance:
			// 1. we create a setTimeout, that calls refreshPositions
			// 2. on the instance, we have a counter variable, that get's higher after every append
			// 3. on the local scope, we copy the counter variable, and check in the timeout, if it's still the same
			// 4. this lets only the last addition to the timeout stack through
			this.counter = this.counter ? ++this.counter : 1;
			var counter = this.counter;
	
			this._delay(function() {
				if(counter === this.counter) {
					this.refreshPositions(!hardRefresh); //Precompute after each DOM insertion, NOT on mousemove
				}
			});
	
		},
	
		_clear: function(event, noPropagation) {
	
			this.reverting = false;
			// We delay all events that have to be triggered to after the point where the placeholder has been removed and
			// everything else normalized again
			var i,
				delayedTriggers = [];
	
			// We first have to update the dom position of the actual currentItem
			// Note: don't do it if the current item is already removed (by a user), or it gets reappended (see #4088)
			if(!this._noFinalSort && this.currentItem.parent().length) {
				this.placeholder.before(this.currentItem);
			}
			this._noFinalSort = null;
	
			if(this.helper[0] === this.currentItem[0]) {
				for(i in this._storedCSS) {
					if(this._storedCSS[i] === "auto" || this._storedCSS[i] === "static") {
						this._storedCSS[i] = "";
					}
				}
				this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper");
			} else {
				this.currentItem.show();
			}
	
			if(this.fromOutside && !noPropagation) {
				delayedTriggers.push(function(event) { this._trigger("receive", event, this._uiHash(this.fromOutside)); });
			}
			if((this.fromOutside || this.domPosition.prev !== this.currentItem.prev().not(".ui-sortable-helper")[0] || this.domPosition.parent !== this.currentItem.parent()[0]) && !noPropagation) {
				delayedTriggers.push(function(event) { this._trigger("update", event, this._uiHash()); }); //Trigger update callback if the DOM position has changed
			}
	
			// Check if the items Container has Changed and trigger appropriate
			// events.
			if (this !== this.currentContainer) {
				if(!noPropagation) {
					delayedTriggers.push(function(event) { this._trigger("remove", event, this._uiHash()); });
					delayedTriggers.push((function(c) { return function(event) { c._trigger("receive", event, this._uiHash(this)); };  }).call(this, this.currentContainer));
					delayedTriggers.push((function(c) { return function(event) { c._trigger("update", event, this._uiHash(this));  }; }).call(this, this.currentContainer));
				}
			}
	
	
			//Post events to containers
			for (i = this.containers.length - 1; i >= 0; i--){
				if(!noPropagation) {
					delayedTriggers.push((function(c) { return function(event) { c._trigger("deactivate", event, this._uiHash(this)); };  }).call(this, this.containers[i]));
				}
				if(this.containers[i].containerCache.over) {
					delayedTriggers.push((function(c) { return function(event) { c._trigger("out", event, this._uiHash(this)); };  }).call(this, this.containers[i]));
					this.containers[i].containerCache.over = 0;
				}
			}
	
			//Do what was originally in plugins
			if ( this.storedCursor ) {
				this.document.find( "body" ).css( "cursor", this.storedCursor );
				this.storedStylesheet.remove();
			}
			if(this._storedOpacity) {
				this.helper.css("opacity", this._storedOpacity);
			}
			if(this._storedZIndex) {
				this.helper.css("zIndex", this._storedZIndex === "auto" ? "" : this._storedZIndex);
			}
	
			this.dragging = false;
			if(this.cancelHelperRemoval) {
				if(!noPropagation) {
					this._trigger("beforeStop", event, this._uiHash());
					for (i=0; i < delayedTriggers.length; i++) {
						delayedTriggers[i].call(this, event);
					} //Trigger all delayed events
					this._trigger("stop", event, this._uiHash());
				}
	
				this.fromOutside = false;
				return false;
			}
	
			if(!noPropagation) {
				this._trigger("beforeStop", event, this._uiHash());
			}
	
			//$(this.placeholder[0]).remove(); would have been the jQuery way - unfortunately, it unbinds ALL events from the original node!
			this.placeholder[0].parentNode.removeChild(this.placeholder[0]);
	
			if(this.helper[0] !== this.currentItem[0]) {
				this.helper.remove();
			}
			this.helper = null;
	
			if(!noPropagation) {
				for (i=0; i < delayedTriggers.length; i++) {
					delayedTriggers[i].call(this, event);
				} //Trigger all delayed events
				this._trigger("stop", event, this._uiHash());
			}
	
			this.fromOutside = false;
			return true;
	
		},
	
		_trigger: function() {
			if ($.Widget.prototype._trigger.apply(this, arguments) === false) {
				this.cancel();
			}
		},
	
		_uiHash: function(_inst) {
			var inst = _inst || this;
			return {
				helper: inst.helper,
				placeholder: inst.placeholder || $([]),
				position: inst.position,
				originalPosition: inst.originalPosition,
				offset: inst.positionAbs,
				item: inst.currentItem,
				sender: _inst ? _inst.element : null
			};
		}
	
	});
	
	})(jQuery);


/***/ }
/******/ ]);
//# sourceMappingURL=bundled-builder.js.map