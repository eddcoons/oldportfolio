/* ===================================================== */
/*	Theme Javascript
/* ===================================================== */

// Requires
require('./smooth');
require('./alerts');
require('./isMobile');
require('waitForImages');
require('portfolio');
module.exports = require("./jquery.portfolio.js");

// Includes without loading as a module, usefull for plugins that don't have module support
require("script!../../assets/jquery.mb.YTPlayer/jquery.mb.YTPlayer.js");
require("script!../../assets/flexibility/flexibility.js");


(function ($, window, document) {
    "use strict";

    // Include JS
    var Isotope = require('isotope');
    require('jquery-bridget');
    $.bridget('isotope', Isotope);

    window.pixo = {

        settings: {
            pageTransition: {
                enabled: true,
                excluded: '.disable-transition, .prettyPhoto, .lightbox-btn, .main_menu a'
            },
            transitionEvent: 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',
            animationEvent: 'webkitAnimationEnd oAnimationEnd  msAnimationEnd animationend',
            equalHeights: '.cols-equal .contents > .col, .cols-equal .container > .col'
        },

        SliderSettings: {
            auto: true,
            speed: 1000,
            pause: 8000,
            mode: 'fade',
            pager: true,
            controls: true
        },

        init: function () {
            this.menu();
            this.selector();
            this.video_bg();

            $('.alert').alerts();

            require('fitVids');
            $('.video-wrapper, .responsive-video').fitVids();

            //if( pixo.override.SliderSettings ) {
            //    pixo.SliderSettings = pixo.override.SliderSettings ;
            //}

            require('prettyphoto');
            $("a[data-pp^='prettyPhoto']").prettyPhoto({
                hook: 'data-pp',
                theme: 'light_square',
                social_tools: '',
                deeplinking: false
            });


            $(document).ready(function () {
                pixo.scroller();
                if (pixo.settings.pageTransition.enabled) {
                    pixo.page_transitions();
                }
                pixo.back_to_top(); // Must be after scroller
                pixo.equal_heights();
                pixo.slider();
                pixo.shapes();
                pixo.skills();
                pixo.maps();
                pixo.preloader();
                require('ytplayer');

                //mb_YTPlayer('.player');

                if (isMobile.any() === null) {
                    $(".player").mb_YTPlayer();
                }
            });

            $(window).on("load", function () {
                pixo.blog_masonry();

            });
        },

        equal_heights: function () {
            require('matchHeight');
            $(pixo.settings.equalHeights).matchHeight();
        },

        slider: function () {
            require('bxslider');
            $('.testimonial').bxSlider(pixo.SliderSettings);
            $('.post-slider').bxSlider({
                auto: true,
                speed: 1000,
                pause: 8000,
                mode: 'fade',
                pager: false,
                adaptiveHeight: true
            });
        },
        preloader: function () {
        $('body').waitForImages(function () {
            $('.preloader').fadeOut(1000);
        });
    },
        page_transitions: function () {

            $('body').waitForImages(function () {
                $(this).addClass('page-animate-in');
            });

            var siteURL = "http://" + top.location.host.toString();

            $("a[href^='" + siteURL + "']").not(pixo.settings.pageTransition.excluded).click(function (e) {
                e.preventDefault();
                var newLocation = jQuery(this).attr('href');
                $('body').addClass('page-animate-out');

                $('.page-animate-out').one(pixo.settings.animationEvent, function () {
                    window.location = newLocation;
                });
            });
        },

        scroller: function () {
            // Only run if there is more than
            // one defined section
            var pageScroller = $('.page-scroller');
            if (1 < pageScroller.length) {

                $('html').addClass('enable-page-scroller');

                var pageScrollerWrap = $('<div id="page-scroller-wrap" />');

                var footer = $('.footer');

                if (1 < pageScroller.length) {

                    // We want the retain HTML5 structure & we want to center contents
                    footer.wrapInner('<div class="centerer"></div>');

                    // Because scroll sections must be a scroll tag
                    footer.wrap('<section class="page-scroller"></section>');

                    $('.page-scroller').wrapAll(pageScrollerWrap);

                    require('onepage-scroll');
                    $('#page-scroller-wrap').onepage_scroll({
                        responsiveFallback: 1000,
                        direction: zorbix_settings.scroller_direction,
                        loop: false,
                        afterMove: function(index) {
                            pixo.back_to_top_scroller()
                        }
                    }); // Must be sections

                    $('.scroll-jump a').click(function(e){
                        e.preventDefault();
                        if( $('body').hasClass('disabled-onepage-scroll') ) {
                            $.smooth({elem: $(this).attr('href')});
                        }
                    });

                    $('.scroll-jump').click(function () {
                        if( !$('body').hasClass('disabled-onepage-scroll') ) {
                            var num = $(this).data('scrolljump');
                            $(".main").moveTo(num);
                        } else {
                            var url = $(this).find('a').attr('href');
                            $.smooth({ elem: url });
                        }
                    });

                    $('.menu-triangle a').click(function () {
                        var url = $(this).attr('href');
                        if (url.charAt(0) ==='#' && $.isNumeric(url.charAt(1))) {
                            var num = url.charAt(1);
                            $(".main").moveTo(num);
                            var menu_triangle = $('.triangle-menu-wrap');
                            menu_triangle.toggleClass('switch');
                            $('.menu-btn').find('i').toggleClass('fa-times fa-bars');
                        }

                    });
                }

            } else {
                $('.scroll-jump a').click( function(e){
                    var url = $(this).attr('href');
                    if (url.charAt(0) ==='#' && url != '#' && url != '#.html') {
                        e.preventDefault();
                        $.smooth({elem: url});
                    }
                });
            }
        },

        selector: function () {
            if (1 === $('.selector').length) {
                //$('.triangle-menu').fadeIn();
            }
        },


        menu: function () {

            var menu_triangle = $('.triangle-menu-wrap');

            // Open menu function
            $('.menu-btn').click(function () {
                menu_triangle.toggleClass('switch');
                $(this).find('i').toggleClass('fa-times fa-bars');
            });

            // Moves triangle to first selector
            var logo_triangle = $('.logo-triangle');
            if (!logo_triangle.hasClass('sticky-triangle')) {
                var element = logo_triangle.remove();
                $('.selector').append(element);
            }

            // Mobile Dropdowns
            $('.main_menu li a').on('click', function (event) {
                // If it's not mobile menu, stop
                var sub_menu = $(this).parent().find('.sub-menu');
                if (0 < sub_menu.length) {
                    // Remove all current classes
                    $('.main_menu .sub-menu').parent().removeClass('current')
                    // Slide up everything but the parents of the current item
                    $('.main_menu .sub-menu').not($(this).parents('.sub-menu')).slideUp()

                    $(this).parent().toggleClass('current');
                    sub_menu.first().slideToggle();
                    event.preventDefault();

                }
            });
        },


        video_bg: function () {

            // Only run video on desktop
            $('.video-background').each(function () {
                var videoBackground = $(this);

                require('./isMobile');
                if (isMobile.any() === null) {
                    videoBackground.parent().append('<div class="video_controls"><a href="#" class="video_pause"><i class="fa fa-play"></i></a> <a href="#" class="video_mute"><i class="fa fa-volume-off"></i></a></div>');

                    // Pause Video
                    var video_controls = videoBackground.parent().find('.video_controls');
                    video_controls.find('.video_pause').on('click', function (e) {
                        e.preventDefault();
                        if (videoBackground.get(0).paused === false) {
                            videoBackground.get(0).pause();
                            $(this).find('i').removeClass('fa-play').addClass('fa-pause');
                        } else {
                            videoBackground.get(0).play();
                            $(this).find('i').removeClass('fa-pause').addClass('fa-play');
                        }
                    });

                    // Unmute
                    video_controls.find('.video_mute').on('click', function (e) {
                        e.preventDefault();
                        videoBackground.get(0).muted = !videoBackground.get(0).muted;
                        $(this).find('i').toggleClass('fa-volume-off').toggleClass('fa-volume-up');
                    });

                }

            });
        },


        shapes: function () { // Append SVG CLip templates
            var body = $('body');

            if (0 === $('.hidden_mask').length) {
                // Feature shapes circle
                body.prepend('<svg class="hidden_mask"><clipPath id="cirlce_mask"><path d="M125,25 C180.228,25 225,69.772 225,125 C225,180.228 180.228,225 125,225 C69.772,225 25,180.228 25,125 C25,69.772 69.772,25 125,25 z"/></clipPath></svg>');
            }

// Create SVG Masks
            $('.create-svg').each(function () {
                var src = $(this).attr('src');
                var clip_mask = $(this).data('clip');
                if (clip_mask === '#circle_mask') {
                    var svg_circle = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="220" height="220" viewBox="0, 0, 250, 250"><g>' +
                        '<image xlink:href="' + src + '" opacity="1" x="25" y="25" width="200" height="200" preserveAspectRatio="xMidYMid" clip-path="url(#cirlce_mask)"/>' +
                        '<path d="M125,245.734 C58.32,245.734 4.266,191.68 4.266,125 C4.266,58.32 58.32,4.266 125,4.266 C191.68,4.266 245.734,58.32 245.734,125 C245.734,191.68 191.68,245.734 125,245.734 z" fill-opacity="0" stroke="#000" stroke-width="1"/>' +
                        '</g></svg>';
                    $(this).after(svg_circle);
                }
                $(this).remove();
            });
        },


        skills: function () {
            require('easypiechart');
            if ($.isFunction($.fn.easyPieChart)) {

                $('.skill-bar').each(function () {

                    var barColor = null !== $('.skill-bar').data('bar-color') ? $('.skill-bar').data('bar-color') : '';

                    $(this).easyPieChart({
                        // easing: 'easeOutBounce',
                        size: 170,
                        animate: 2000,
                        lineWidth: 10,
                        lineCap: 'butt',
                        scaleColor: false,
                        rotate: 270,
                        barColor: barColor
                    });

                });

            } else {
                console.log('easypiechart plugin required');
            }
        },

        milestones: function ($) {

            $('.milestone').each(function () {
                $(this).appear(function () {
                    var countElem = $(this).find('.count');
                    var numCountTo = countElem.data('count').toString();

                    numCountTo = numCountTo.replace(',', '');
                    numCountTo.replace('.', '');

                    countElem.countTo({
                        from: 0,
                        to: numCountTo,
                        speed: 2200,
                        refreshInterval: 60,
                        formatter: function (value, options) {
                            value = value.toFixed(options.decimals);
                            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            return value;
                        }
                    });
                });

            });
        },

        maps: function () {
            // http://www.smashinglabs.pl/gmap/documentation
            require('gmap/jquery.gmap.js');
            if ($.isFunction($.fn.gMap)) {

                var mapStyles = [{
                    "featureType": "landscape",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 65
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "poi",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 51
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road.highway",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road.arterial",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 30
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "road.local",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 40
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "transit",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "administrative.province",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "labels",
                    "stylers": [{
                        "visibility": "on"
                    }, {
                        "lightness": -25
                    }, {
                        "saturation": -100
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{
                        "hue": "#ffff00"
                    }, {
                        "lightness": -25
                    }, {
                        "saturation": -97
                    }]
                }];


                // var address = "Kensington Gardens Square, London, UK";

                $('.google-map').each(function () {

                    var address = $(this).data('address');
                    var markers = $(this).data('markers');
                    var zoom = $(this).data('zoom');
                    zoom = ( zoom ) ? zoom : 16;

                    // If no markers are set default to the address
                    // Format to json
                    if (!markers) {
                        markers = [{"address": address}];
                    } else {
                        if (markers.indexOf('{') !== -1) {
                            markers = markers.replace(/{/gi, '{"address":"');
                            markers = markers.replace(/}/gi, '"}');
                            markers = '[' + markers + ']';
                            markers = jQuery.parseJSON(markers);
                        } else {
                            markers = [{"address": markers}];
                        }
                    }

                    $(this).gMap({
                        address: address,
                        markers: markers,
                        zoom: zoom,
                        styles: mapStyles,
                        scrollwheel: false
                    });

                });

                $('.map-overlay').on('click', function (event) {
                    event.preventDefault();
                    $('.map-holder .close-btn').fadeIn();
                    $(this).fadeOut(function () {
                        $('.map-holder').css('height', '400');
                    });
                });

                $('.map-holder .close-btn').on('click', function (e) {
                    e.preventDefault();
                    var elem = this;
                    $('.map-overlay').fadeIn(function () {
                        $('.map-holder').css('height', '100');
                        $(elem).fadeOut();
                    });
                });
            } else {
                console.warn('gmap not found');
            }
        },


        blog_masonry: function () {


            jQuery('.blog-masonry').waitForImages(function () {
                require('isotope');
                jQuery('.blog-masonry').isotope({
                    itemSelector: '.blog-post',
                    layoutMode: 'masonry',
                });
            });

            jQuery('.latest-posts').waitForImages(function () {
                jQuery('.latest-posts').isotope({
                    itemSelector: '.col',
                    layoutMode: 'masonry',
                });
            });
        },

        back_to_top_scroller: function() {
            var $topBtn = $('.top-btn');
            $topBtn.find('i').removeClass('fa-chevron-up');
            $topBtn.find('i').addClass('fa-chevron-left');
            if( !$topBtn.hasClass('show') ) {
                if( !$('body').hasClass('viewing-page-1') ) {
                   $topBtn.addClass('show');
                    $topBtn.on('click', function (event) {
                            $(".page-scroller").moveTo(1);
                    })
                }
            } else {
                if( $('body').hasClass('viewing-page-1') ) {
                    $topBtn.removeClass('show');
                }
            }
        },

        back_to_top: function () {
            var $topBtn = $('.top-btn');
            if ($topBtn.length) {



                if( 1 !== jQuery('#page-scroller-wrap').length ) {
                    $topBtn.on('click', function (event) {
                        event.preventDefault();
                        $.smooth({elem: 'body', offset: -60});
                    });

                    showTopButton();
                    $(window).on('scroll', function () {
                        showTopButton();
                    });
                }

            }

            function showTopButton() {
                if (jQuery(window).scrollTop() > 100) {
                    $topBtn.addClass('show');
                } else {
                    $topBtn.removeClass('show');
                }
            }
        }


    }
    window.pixo.init();
})
(jQuery, window, document);


