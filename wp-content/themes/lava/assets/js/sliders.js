jQuery(function($) {

	var isRTL = $('body').hasClass('rtl');

	// Gallery

    $('.lava-gallery:not(.style-thumbnail) .slick-slider').slick({
        adaptiveHeight: true,
        infinite: false,
        prevArrow: '<div class="slick-prev"><i class="material-icons">arrow_back</i></div>',
        nextArrow: '<div class="slick-next"><i class="material-icons">arrow_forward</i></div>',
        rtl: isRTL,
        fade: true,
        cssEase: 'ease-out',
        useTransform: true,
    })
    .on('lazyLoaded', function() {
        $(window).trigger('resize');
    });

    $('.lava-gallery.style-thumbnail').each(function() {
        var mainSlider = $(this).find('.main-slider');
        var thumbSlider = $(this).find('.thumb-slider');
        var thumbSize = $(this).hasClass('hb_room_gallery') ? 130 : 110;

        mainSlider.slick({
            asNavFor: thumbSlider,
            adaptiveHeight: true,
            useTransform: true,
            rtl: isRTL,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            cssEase: 'ease-out',
            prevArrow: '<div class="slick-prev"><i class="material-icons">arrow_back</i></div>',
            nextArrow: '<div class="slick-next"><i class="material-icons">arrow_forward</i></div>',
        })
        .on('lazyLoaded', function() {
            $(window).trigger('resize');
        });

        thumbSlider.slick({
            asNavFor: mainSlider,
            useTransform: true,
            rtl: isRTL,
            slidesToShow: getColumnCount($(this), thumbSize),
            slidesToScroll: 1,
            prevArrow: '<div class="slick-prev"><i class="material-icons">arrow_back</i></div>',
            nextArrow: '<div class="slick-next"><i class="material-icons">arrow_forward</i></div>',
            adaptiveHeight: true,
            arrows: true,
            variableWidth: true,
            focusOnSelect: true
        });
    });

    // Room Slider

    $('.lava-rooms-slider .slick-slider').each(function() {
        var columns = $(this).data('columns');
        var column2 = 2;
        var column3 = 3;
        
        if (typeof columns === 'undefined' ) {
            columns = 3;
        } else {
            columns = parseInt(columns);
        }

        if (columns == 2) {
            column3 = 2;
        }

        if (columns == 1) {
            column2 = 1;
            column3 = 1;
        }

        $(this).slick({
            adaptiveHeight: true,
            useTransform: true,
            rtl: isRTL,
            infinite: false,
            prevArrow: '<div class="slick-prev"><i class="material-icons">arrow_back</i></div>',
            nextArrow: '<div class="slick-next"><i class="material-icons">arrow_forward</i></div>',
            slidesToShow: columns,
            slidesToScroll: 1,
            responsive: [
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: column3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1020,
                settings: {
                    slidesToShow: column2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            ]
        });
    });

    // Room Gallery Slider

    $('.room-gallery-slider').each(function() {
        var columns = $(this).data('columns');
        if (typeof columns === 'undefined') {
            columns = 3;
        } else {
            columns = parseInt(columns);
        }
        $(this).slick({
            adaptiveHeight: true,
            useTransform: true,
            prevArrow: '<div class="slick-prev"><i class="material-icons">arrow_back</i></div>',
            nextArrow: '<div class="slick-next"><i class="material-icons">arrow_forward</i></div>',
            infinite: false,
            rtl: isRTL,
            slidesToShow: columns,
            slidesToScroll: 1,
            responsive: [
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 1020,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            ]
        });
    });

    // Rooms Carousel

    $('.hb_room_carousel .slick-slider').slick({
        infinite: false,
        rtl: isRTL,
        useTransform: true,
        slidesToScroll: 1,
        prevArrow: '<div class="slick-prev"><i class="material-icons">arrow_back</i></div>',
        nextArrow: '<div class="slick-next"><i class="material-icons">arrow_forward</i></div>',
        fade: false,
        responsive: [
        {
            breakpoint: 1260,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 860,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
            }
        }
        ]
    });

    // Events Carousel

    $('.lava-event-carousel .slick-slider').slick({
        adaptiveHeight: true,
        useTransform: true,
        infinite: false,
        prevArrow: '<div class="slick-prev"><i class="material-icons">arrow_back</i></div>',
        nextArrow: '<div class="slick-next"><i class="material-icons">arrow_forward</i></div>',
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
        {
            breakpoint: 1560,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 1020,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 690,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: false,
            }
        },
        ]
    });

    // Post Carousel

    $('.lava-post-carousel .slick-slider').slick({
        adaptiveHeight: true,
        useTransform: true,
        infinite: false,
        prevArrow: '<div class="slick-prev"><i class="material-icons">arrow_back</i></div>',
        nextArrow: '<div class="slick-next"><i class="material-icons">arrow_forward</i></div>',
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
        {
            breakpoint: 1560,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 1020,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 690,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: false,
            }
        },
        ]
    });

    // Testimonials
	
    $('.lava-testimonials .slick-slider').each(function() {
        var slidesToShow = $(this).data('slick');
        var slidesOn1400 = slidesToShow.slidesToShow >= 3 ? 3 : slidesToShow.slidesToShow;
        var slidesOn1020 = slidesOn1400 >= 2 ? 2 : 1;

        $(this).slick({
            adaptiveHeight: true,
            infinite: false,
            rtl: isRTL,
            speed: 600,
            useTransform: true,
            slidesToScroll: 1,
            responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: slidesOn1400,
                }
            },
            {
                breakpoint: 1020,
                settings: {
                    slidesToShow: slidesOn1020,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            }
            ]
        });
    });

    function getColumnCount(wrapper, columnWidth) {
        return Math.floor(wrapper.width()/columnWidth);
    }

});
