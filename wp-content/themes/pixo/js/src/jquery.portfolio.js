/*
 *  Zorbix ajax portfolio loader
 *
 */
(function ($, window, document, undefined) {

    window.zorbixPortfolio = {

        settings: {
            propertyName: "value",
            portItem: '.port-item',
            noItems: 4,
            projectBtn: '.port-item .port-overlay',
            scrollOffset: -$('.main_menu').outerHeight() + 10,
            load_more_in_category: true,
            filter: '.port-item',
            slider_name: '.portfolio-slider-ajax',
            scrollOff: true
        },

        init: function () {
            this.portfolio = '.portfolio';
            this.portfolioElement = $('.portfolio');

            this.noItems = ($(this.portfolio).data('show')) ? $(this.portfolio).data('show') : this.settings.noItems;
            //this.init_project_btn(); // For in page load
            this.init_filter_menu();
            this.init_load_more_btn();
            this.hide_show_more_btn();

            this.portItems = this.portfolioElement.find('.port-item');
            this.portfolioElement.find('.port-item:lt(' + this.noItems + ')').addClass('showme');

            this.set_heights();
            this.init_isotope();

            this.onLoadFilter();
            console.log('loaded');
        },

        set_heights: function() {

            if( this.portfolioElement.hasClass('pixo_port_thumb_rectangle') ) {
            this.portfolioElement.waitForImages(function () {

                    var height = Math.floor($('.port-item img').outerHeight() - 1);
                    $('.port-item').css('height', height);
                    $('.port-item.tall').css('height', ( height * 2));

                    $('.port-item.tall').css('height', ( height * 2));
                    $(window).resize(function () {
                        var height = Math.floor($('.port-item img').outerHeight());
                        $('.port-item').css('height', height);
                        $('.port-item.tall').css('height', ( height * 2));
                    });

            });
            }
        },

        init_isotope: function () {
            var fnc = this;
            jQuery(window).load({fnc: this}, function (e) {
                // main.js
                var portfolioElement = e.data.fnc.portfolioElement;

                        portfolioElement.isotope();


                //var isotope = require('isotope');
                //isotope = new isotope(e.data.fnc.portfolioElement);
                //isotope(e.data.fnc.portfolioElement);
            });
        },

        init_project_btn: function () {
            var projectBtn = this.settings.projectBtn;
            $(this.portfolio).find(projectBtn).on('touchstart', function (e) {
            });
            $(this.portfolio).find(projectBtn).on("click", {fnc: this}, function (event) {
                event.preventDefault();
                $('.loader').stop();
                if (!$('.port-overlay .project-btn').hasClass('disabled')) {
                    $('.port-overlay .project-btn').addClass('disabled');
                    event.data.fnc.projectInit($(this));
                }
            });
        },

        init_load_more_btn: function () {
            // > LOAD MORE ITEMS
            $('#load-more').click({fnc: this}, function (e) {
                e.preventDefault();
                var fnc = e.data.fnc;

                $(this).prepend('<i class="loader spin fa fa-spinner"></i>');

                $('#load-more i.spin').css('display', 'none').fadeIn('fast');

                // How many to load
                var numToLoad = ($(this).data('num')) ? $(this).data('num') : 4;
                console.log('numtoload', numToLoad);
                var noItems = 0;
                if (noItems < $('.port-item').length) {
                    noItems += parseInt(numToLoad);
                }

                // Create Filter
                var selector = $('.filter-menu .selected').data('cat');
                var filter = '.port-item[data-cat*=' + selector + ']';
                if (selector === '*' || !load_more_in_category) {
                    filter = '.port-item';
                }

                // Reapply showme class
                fnc.noItems = noItems + fnc.portfolioElement.find('.showme').length;
                $('.port-item').removeClass('showme');
                // Add filter
                fnc.portfolioElement.find(filter + ':lt(' + fnc.noItems + ')').addClass('showme');


                // Load all unloaded images
                fnc.portfolioElement.find('div[data-port-thumb]:nth-child(-n+' + numToLoad + ')').each(function () {
                    var path = $(this).data('port-thumb');
                    var portItem = $(this).parent();
                    var alt = $(this).attr('alt');

                    $(this).after('<img src="' + path + '" alt="' + alt + '">');
                    $(this).find('img').css('display', 'none');
                    $(this).remove();
                    $(this).addClass('new');
                });


                // Init isotope
                fnc.portfolioElement.waitForImages(function () {
                    $('#load-more i.spin').stop().delay(1000).fadeOut('fast', function () {
                        $(this).remove();
                    });
                    $(this).find('.showme').fadeIn();
                    $(this).isotope({filter: '.showme'});
                });

                $(this).find('i').fadeOut();
                fnc.hide_show_more_btn();
            });

        },

        onLoadFilter: function () {

            var query = location.search.substring(1).split('=');

            if ('filter' === query[0]) {
                zorbixPortfolio.filter_port(query[1]);
            }

        },

        filter_port: function (selector) {

            var filter = '.port-item[data-cat*=' + selector + ']';
            if (selector === '*') {
                filter = '.port-item';
            }

            //$('.showme').removeClass('showme');

            filter = filter + ':lt(' + zorbixPortfolio.noItems + ')';

            zorbixPortfolio.portfolioElement.isotope({
                filter: filter
            });

        },

        init_filter_menu: function () {

            var filter = $('.filter-menu li');
            filter.css({
                'cursor': 'pointer'
            });

            filter.click({fnc: this}, function (event) {

                var fnc = event.data.fnc;

                if (!$(this).hasClass('selected')) {
                    var bgColor = $(this).css('background');
                }
                $(this).fadeTo('background', 'white');

                $(this).siblings().removeClass('selected');
                $(this).addClass('selected');
                var selector = $(this).attr('data-cat');

                fnc.filter_port(selector);

            });
        },


        // HIDE SHOW BTN
        // If there are no more items to show
        // If the number to show is greater then the number of items available
        hide_show_more_btn: function () {
            if (0 === this.portfolioElement.find('div[data-port-thumb]').length) {
                $('.load-more').attr('disabled', true);
            } else if (this.settings.load_more_in_category) {
                // Whats selected
                var selector = $('.filter-menu li.selected').data('cat');
                // If we are not loading from all
                if (selector !== '*') {
                    var filter = '.port-item[data-cat*=' + selector + ']';
                } else {
                    var filter = '.port-item';
                }

                var num_items_in_cat = $(filter).length;
                if (num_items_in_cat <= this.noItems) {
                    $('.load-more').attr('disabled', true);
                } else {
                    $('.load-more').attr('disabled', false);
                }
            }
        }, // END: hide_show_more_btn

        // PROJECT SLIDER INIT
        setSlidler: function () {
            if ($.isFunction($.fn.vc_js)) {
                vc_js(); // Run VC scripts for VC shortcodes
            }
            $('.video-wrapper').fitVids();
        }, // End setSlider

        // SHOW THE PROJECT
        showProject: function (elem, projectWrapper, fnc) {
            var projectWrapperHeight;

            // Append project to wrapper
            var projectHTML = $('<div class="project">' + elem + '</div>').appendTo(projectWrapper);

            projectWrapper = this.projectWrapper = $($(this.portfolioWrapper).find('.project-wrapper'));

            var project = this.projectWrapper.find('.project');

            fnc.closeButton();

            projectHTML.waitForImages(function () {
                fnc.setSlidler();
                // init_internal_video();
                projectWrapper.find('.video-wrapper').fitVids();

                //projectWrapperHeight = project.outerHeight() + 110; // Get height of project
                //
                ////project.css('height', '100%'); // To fix ie visibility bug
                //
                //// Animate wrapper height, fade in project and remove loader
                //projectWrapper.animate({
                //    height: projectWrapperHeight
                //}, 600, function () {
                //    //projectWrapper.css('height', 'auto'); // Remove fixed height
                //    project.fadeIn('slow');
                //    fnc.hideSpinner();
                //});

                projectWrapper.addClass('open');
                $('.port-overlay .project-btn').removeClass('disabled');
            });

        }, // End ShowProject

        // FETCH THE PROJECT
        getProject: function (elem, scrollDfd, projectDfd) {
            $.get(elem.attr('href'), {ajax: "true"}, function (projectHTML) {
                projectDfd.resolve(projectHTML);
            }, 'html');
        }, // End getProject

        // ADD CLOSE BUTTON
        closeButton: function () {
            // Needs to know not to add to the project-
            // Prepend close button if it doesn't exist
            if (this.projectWrapper.find('.project .close-btn').length === 0) {
                this.projectWrapper.find('.project').prepend('<a href="#" class="close-btn"><i class="fa fa-times-circle-o"></i></a>');
            } else {
            }
            var projectWrapper = this.projectWrapper;
            this.projectWrapper.find('.close-btn').click(function () {
                // hideLoader();
                //projectWrapper.animate({
                //    height: 0
                //});


                projectWrapper.find('.project').fadeOut('slow', function () {
                    projectWrapper.removeClass('open');
                    projectWrapper.find('.project').remove();
                });
                return false;
            });
        }, // End closeButton

        // SWITCH TO ANOTHER PROJECT
        changeProject: function (projectHTML, projectWrapper, fnc) {
            projectWrapper.css('height', projectWrapper.outerHeight());
            projectWrapper.find('.project').fadeOut('slow', function () {
                projectWrapper.find('.project').remove();
                fnc.showProject(projectHTML, projectWrapper, fnc);
            });
        },


        showLoader: function (projectWrapper) {
            if (typeof(this.loader) !== "undefined" && this.loader.hasClass('temp-hide')) {
                this.showSpinner();
            }

            if (typeof(this.loader) === "undefined") {
                this.addLoader();
            }
        },

        addLoader: function () {
            var preloadedHTML = '<div class="loader"><i class="fa fa-spinner spin"></i></div>';
            this.projectWrapper.prepend(preloadedHTML);
            this.loader = this.projectWrapper.find('.loader');
        },

        hideSpinner: function () {
            //this.loader.addClass('temp-hide').find('i').fadeOut();
        },

        showSpinner: function () {
            this.projectWrapper.find('.loader i').fadeIn();
        },

        projectInit: function (elem) {

            var scrollFinished = '';
            // Vars
            this.portfolioWrapper = elem.closest('.portfolio-wrapper');
            var projectWrapper = this.projectWrapper = elem.closest('.portfolio-wrapper').find('.project-wrapper'),
                projectFinishedLoading = $.Deferred();

            var fnc = this;
            console.log('scroll off', this.settings.scrollOff);

            if (true === this.settings.scrollOff) {
                console.log('scroll off');
                scrollFinished = false;

                var projectHTML = this.getProject(elem, scrollFinished, projectFinishedLoading);

                $.when(projectFinishedLoading).done(function (projectHTML) {
                    if (projectWrapper.hasClass('open')) {
                        fnc.changeProject(projectHTML, projectWrapper, fnc);
                    } else {
                        fnc.showProject(projectHTML, projectWrapper, fnc);
                    }
                });

            } else {
                console.log('else');
                var scrollFinished = this.projectScroll();

                this.getProject(elem, scrollFinished, projectFinishedLoading);

                $.when(projectFinishedLoading, scrollFinished).done(function (projectHTML) {
                    if (projectWrapper.hasClass('open')) {
                        fnc.changeProject(projectHTML, projectWrapper, fnc);
                    } else {
                        fnc.showProject(projectHTML, projectWrapper, fnc);
                    }
                });
            }

            // When project is loaded and page finished loading
            // Load or change project


        }, // End projectInit

        projectScroll: function () {
            var scrollPosOffset;
            var header = $('.header');
            // If header is sticky add header height to scroll pos
            if (header.css("position") === "fixed") {
                scrollPosOffset = -( header.outerHeight() - 5);
            } else {
                scrollPosOffset = 0;
            }

            var scrollFinished = $.Deferred();

            this.showLoader(this.projectWrapper);

            // Scroll up to project loader
            $.smooth(this.projectWrapper, scrollPosOffset, function () {
                return scrollFinished.resolve();
            });
        }

    }
    window.zorbixPortfolio.init();

})(jQuery, window, document);