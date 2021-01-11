!function($, window, document) {
    'use strict';

    var $document = $(document);
    var $window = $(window);
    var winWidth = $window.width();
    var winHeight = $window.height();
    var Modernizr = window.Modernizr;
    var isPhone = matchMaxWidth(767);
    var isTablet = matchMaxWidth(1019);
    var isDesktop = matchMinWidth(1020);
    var isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
    var body;
    var site;
    var overlay;
    var main;
    var header;
    var content;
    var footer;
    var sidebar;

    var loader = {

        elem: null,
        loading: true,
        width: 0,
        maxWidth: 400,

        init: function() {
            loader.elem = $('#loader');

            if (loader.elem.length === 0) {
                return;
            }

            if (winWidth < 480) {
                loader.maxWidth = 100;
            } else {
                loader.maxWidth = 400;
            }

            switch(loader.elem.attr('class')) {
                case 'spinner':
                case 'square-spin': loader.spinner(); break;
                default: loader.line(); break;
            }
        },

        line: function() {
            
            loader.elem.css({ top: winHeight / 2 - 1, left: winWidth / 2 - loader.maxWidth / 2 });
            loader.progress();

            $window.on('load', function() {
                setTimeout(function() {
                    loader.loading = false;
                    loader.elem.stop(true);
                    loader.elem.animate({ left: 0, width: '100%' })
                    loader.elem.fadeOut(100);
                    loader.elem.promise().done(function() {
                        $('body').removeClass('page-loading');
                    });
                }, 200);
            });
        },

        spinner: function() {
            $window.on('load', function() {
                setTimeout(function() {
                    loader.elem.fadeOut(100);
                    loader.elem.promise().done(function() {
                        $('body').removeClass('page-loading');
                    });
                }, 200);
            });
        },

        progress: function() {
            if (loader.loading && loader.width < loader.maxWidth) {
                loader.width += 3;
                loader.elem.animate({ width: loader.width }, 10);
                loader.progress();
            }
        }
    }

    loader.init();

    $document.ready(function() {

        body = $('body');
        site = body.children('.site');
        overlay = site.find('.site-overlay');
        main = site.find('.site-main');
        header = main.find('#header');
        content = main.find('#content');
        footer = main.find('#footer');
        sidebar = content.find('.sidebar');

        // replace retina image src
        if (window.devicePixelRatio >= 2) {
            $('img.logo-retina').each(function() {
                var $this = $(this);
                $this.attr('src', $this.data('retina'));
            });
        }

        wpadminbar.init();
        navigation.init();
        stickyHeader.init();
        fullscreenHeader();

        // Customize select style
        $('select:not(.woocommerce-billing-fields select,#rating,.number_room_select.single_select,.tribe-bar-views-select,.booking-form-guests)').dropkick({
            mobile: true,
            change: function() {
                var selectedIndex = this.selectedIndex;
                $(this.data.select).find('option').each(function(index, elem) {
                    if (index === selectedIndex) {
                        $(elem).attr('selected', 'selected');
                    } else {
                        $(elem).removeAttr('selected');
                    }
                });
            }
        });

        $('.loop-post .post-thumb, .lava-rooms-slider .post-thumb').hoverdir();

        // Hamburger
        var burger = $('.hamburger');

        if (burger.length) {
            var navCloseButton = $('#nav-close');
            var navOverlay = main.find('.nav-overlay');

            burger.on('click touchend', function(e) {
                e.preventDefault();
                body.toggleClass('nav-active');
  
                if (wpadminbar.fixed) {
                    navOverlay.css('top', wpadminbar.height + 'px');
                } else {
                    if ($window.scrollTop() === 0) {
                        navOverlay.css('top', wpadminbar.height + 'px');
                    } else {
                        navOverlay.css('top', '');
                    }
                }
            });

            navCloseButton.on('click touchend', function(e) {
                e.preventDefault();
                body.removeClass('nav-active');
            });
        }

        // Search

        $document.on('click', '#nav-search', function(e) {
            e.preventDefault();
            var searchInput = $('.menu-item-search .sf-input');
            
            if (!body.hasClass('nav-search-active')) {
                body.addClass('nav-search-active');
                setTimeout(function() {
                    searchInput.focus();
                }, 200);
            } else {
                body.removeClass('nav-search-active');
            }
        });

        // Fullscreen menu
        $document.on('click', '.fullscreen-menu .menu-item-has-children>a', function(e) {
            e.preventDefault();
            $(this).siblings('.menu-back').css('display', 'block');
            var parent = $(this).parent();
            parent.addClass('sub-menu-active');
            parent.siblings().hide();
            parent.children('.sub-menu').fadeIn();
            if (parent.parent().parent().hasClass('sub-menu-active')) {
                parent.parent().parent().children('.menu-back').hide();
            }
        });

        $document.on('click', '.menu-back', function(e) {
            e.preventDefault();
            $(this).hide();
            var parent = $(this).parent();
            parent.removeClass('sub-menu-active');
            parent.siblings().show();
            parent.children('.sub-menu').hide();
            parent.parent().parent().children('.menu-back').css('display', 'block');
        });

        var fullscreenMenu = main.find('.fullscreen-menu');
        var currentMenuItemB = fullscreenMenu.find('.current-menu-item');

        $document.on('mouseover', '.fullscreen-menu a', function() {
            var $this = $(this);
            if (currentMenuItemB.length) {
                if ($this.parent().is(currentMenuItemB)) {
                    currentMenuItemB.removeClass('inactive');
                } else {
                    currentMenuItemB.addClass('inactive');
                }
            }
            $this.addClass('active');
        }).on('mouseout', '.fullscreen-menu a', function() {
            if (currentMenuItemB.length) {
                currentMenuItemB.removeClass('inactive');
            }
            $(this).removeClass('active');
        });

        // Scroll top
        var scrollButton = $('#scroll-top');
        var scrollButtonVisible = false;

        scrollButton.on('click touchend', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0}, 400);
        });

        $window.on('scroll', $.throttle(100, function() {
            if ($window.scrollTop() > 200) {
                if (!scrollButtonVisible) {
                    scrollButton.addClass('active');
                    scrollButtonVisible = true;
                }
            } else {
                if (scrollButtonVisible) {
                    scrollButton.removeClass('active');
                    scrollButtonVisible = false;
                }
            }
        }));

        // Social share buttons
        $document.on('click', '.post-share a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            window.open(url, "Share", 'height=500,width=600,top=' + (winHeight / 2 - 250) + ', left=' + ($window.width() / 2 - 300) + 'resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0');
        });

        // Fit video width
        $('.media-embed,.embed-youtube').fitVids();

        // Placeholder support for browsers do not support html5
        $('input,textarea').placeholder();

        $('input.lava-checkbox').each(function() {
            var $this = $(this);
            if ($this[0].id.length) {
                $this.after('<label for="'+ $this.attr('id') +'"></label>');
            }
        });

        // Woocommerce quantity +/- buttons
        var wooQuantityInput = $('.woocommerce .quantity .qty');
        var wooNavItemCount = $('#nav-cart .count');

        if (wooNavItemCount.length) {
            body.on('added_to_cart', function() {
                var count = parseInt(wooNavItemCount.html(), 10) + 1;
                wooNavItemCount.html(count).show();
                stickySidebar();
            });
        }

        $document.on('click', 'input.plus, input.minus', function() {
            var qty = $(this).siblings('.qty');
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr('max'));
            var min = parseFloat(qty.attr('min'));
            var step = qty.attr('step');

            if (val === '' || isNaN(val)) val = 1;
            if (max === '' || isNaN(max)) max = '';
            if (min === '' || isNaN(min)) min = 1;
            if (step === '' || step === 'any' || isNaN(parseFloat(step))) step = 1;

            if ($(this).is('.plus')) {
                if (max && val >= max) {
                    qty.val(max);
                } else {
                    qty.val(val + parseFloat(step));
                }
            } else {
                if (min && val <= min) {
                    qty.val(min);
                } else if (val > 1) {
                    qty.val(val - parseFloat(step));
                }
            }
            qty.trigger('change');
        });

        // Hotel booking
        $document.on('click', '.hasDatepicker', function() {
            if ($(this).hasClass('error')) {
                $(this).removeClass('error');
            }
        })
        .on('click', '.hotel_booking_invalid_quantity', function() {
            $(this).removeClass('hotel_booking_invalid_quantity');
        })
        .on('submit', '.hotel-booking-single-room-action', function() {
            $document.ajaxComplete(function() {
                $('#hotel_booking_room_hidden select').dropkick({
                    mobile: true,
                    change: function() {
                        var selectedIndex = this.selectedIndex;
                        $(this.data.select).find('option').each(function(index, elem) {
                            if (index === selectedIndex) {
                                $(elem).attr('selected', 'selected');
                            } else {
                                $(elem).removeAttr('selected');
                            }
                        });
                    }
                });

                $('.hb_addition_packages input[type=checkbox]').each(function() {
                    var $this = $(this);
                    if ($this[0].id.length) {
                        $this.after('<label for="'+ $this.attr('id') +'"></label>');
                    }
                });
            });
        })
        .on('click', '#hb-payment-form .error', function() {
            $(this).removeClass('error');
        });

        // Responsive room tabs
        var roomTabs = $('.hb_single_room_tabs');

        if (roomTabs.length) {
            var tabWidth = 0;

            roomTabs.children().each(function() {
                tabWidth += $(this).outerWidth();
            });

            hbRoomTabs(tabWidth);

            $window.on('resize', $.debounce(200, function() {
                hbRoomTabs(tabWidth);
            }));
        }

        function hbRoomTabs(tabWidth) {
            if (tabWidth < roomTabs.parent().width()) {
                roomTabs.removeClass('collapsed').addClass('expanded');
            } else {
                roomTabs.removeClass('expanded').addClass('collapsed');
            }
        }

        // review comment
        
        $('#review_form .comment-reply-title').on('click', function() {
            $(this).siblings('#commentform').slideToggle();
        });

        // Widgets

        $('.equal-height').matchHeight();

        // Sticky sidebar
        stickySidebar();
    });

    /* -----------------------------------------------------------------------------
     * Main Menu
     * ----------------------------------------------------------------------------- */
    var navigation = {
        headerStyle: '2',
        menu: null,
        submenu: null,
        megamenu: null,
        container: null,
        width: 0,
        space: 0,
        cache: null,

        init: function() {
            var style = header.hasClass('header-style-3') ? '3' : '2';
            navigation.headerStyle = header.hasClass('header-style-4') ? '4' : style;

            var menu = $('.nav-menu');

            if (menu.length === 0) {
                return;
            }

            navigation.menu = menu;
            if (navigation.headerStyle === '2' || navigation.headerStyle === '4') {
                navigation.cache = menu.html();
            }
            navigation.container = menu.parents('.nav');
            navigation.compress();

            navigation.submenu = menu.find('.sub-menu');
            navigation.megamenu = menu.find('.megamenu-custom-width .megamenu');

            if (navigation.submenu.length) {
                navigation.hovershift();
            }

            if (navigation.megamenu.length) {
                navigation.rePosition();
            }

            navigation.sfmenu();

            // hover effect
            var lastMenuItem = null;
            var currentMenuItemA = null;

            $document.on('mouseover', '.nav-menu>li', function() {
                currentMenuItemA = $(this);
                if (!currentMenuItemA.hasClass('current-menu-item')) {
                    lastMenuItem = currentMenuItemA.siblings('.current-menu-item,.current-menu-parent,.current-menu-ancestor');
                    lastMenuItem.addClass('inactive');
                } else {
                    currentMenuItemA.removeClass('inactive');
                    lastMenuItem = currentMenuItemA;
                }
            }).on('mouseout', '.nav-menu>li', function() {
                if (lastMenuItem != null) {
                    lastMenuItem.removeClass('inactive');
                }
            });

            $(window).on('resize orientationchange', $.debounce(200, function() {
                navigation.refresh();
            }));
        },

        disableMenus: function() {
            navigation.moreItemsUl.find('.megamenu').each(function() {
                $(this).removeClass('megamenu').addClass('sub-menu');
            })
            
            navigation.moreItemsUl.find('.megamenu-submenu').each(function() {
                $(this).removeClass('megamenu-submenu').addClass('sub-menu');
            });

            navigation.moreItemsUl.find('[class^="megamenu-"],[class*=" megamenu-"]').each(function() {
                var oldName = $(this)[0].className;
                var newName = oldName.replace(new RegExp('megamenu', 'g'), 'mm');
                $(this).attr('class', newName);
            });

            navigation.moreItemsUl.find('>.menu-item>a').attr('style', '');
        },

        sfmenu: function() {
            navigation.menu.superfish({
                animation: {opacity:'show'},
                cssArrows: false,
                delay: 0,
                disableHI: true,
                popUpSelector: '.sub-menu,.megamenu',
                speed: 'fast',
                speedOut: 0,
            });
        },

        compress: function() {
            if (!matchMinWidth(768)) {
                if (navigation.headerStyle === '3') {
                    navigation.container.addClass('nav-compress').removeClass('pre-compress');
                }
                return;
            }
            navigation.menu.addClass('pre-compress');
            var containerWidth = navigation.container.width();
            navigation.width = 0;

            if (navigation.headerStyle === '2' || navigation.headerStyle === '4') {
                navigation.moreItems = navigation.menu.find('.menu-items-container');
                navigation.moreItemsUl = navigation.moreItems.find('>ul');
                navigation.moreItems.show();
                navigation.moreItemsWidth = navigation.moreItems.outerWidth();
                navigation.moreItems.hide();
                navigation.menuItems = navigation.menu.children().not('.menu-items-container');

                navigation.container.children().each(function() {
                    if ($(this).is('.nav-menu-wrapper') || $(this).is('.nav-menu')) {
                        for (var i = navigation.menuItems.length - 1; i >= 0; i--) {
                            navigation.width += navigation.menuItems.eq(i).outerWidth();
                        }
                    } else {
                        navigation.width += $(this).outerWidth();
                    }
                });

                if (navigation.width + navigation.space > containerWidth) {
                    navigation.container.addClass('nav-compress');
                    
                    for (var i = navigation.menuItems.length - 1; i >= 0; i--) {
                        var currentMenuItem = navigation.menuItems.eq(i);
                        navigation.width = navigation.width - currentMenuItem.outerWidth();
                        currentMenuItem.prependTo(navigation.moreItemsUl);

                        if (navigation.width + navigation.space + navigation.moreItemsWidth <= containerWidth) {
                            break;
                        }
                    }
                    navigation.disableMenus();
                    navigation.moreItems.show();
                } else {
                    navigation.container.removeClass('nav-compress');
                }
            } else if (navigation.headerStyle === '3') {
                navigation.container.removeClass('nav-compress');
                var leftMenu = header.find('.left-menu');
                var rightMenu = header.find('.right-menu');
                var centerLogo = header.find('.logo-wrapper');
                var menuPadding = 30;
                if (centerLogo.length) {
                    menuPadding += centerLogo.width() / 2;
                }
                
                if (leftMenu.length) {
                    leftMenu.parent().css({
                        'display': 'table-cell',
                        'padding-right': menuPadding + 'px',
                        'visibility': 'visible',
                    });
                    navigation.width = leftMenu.outerWidth();
                }

                if (rightMenu.length) {
                    rightMenu.parent().css({
                        'display': 'table-cell',
                        'padding-left': menuPadding + 'px',
                        'visibility': 'visible',
                    });
                    if (navigation.width < rightMenu.outerWidth()) {
                        navigation.width = rightMenu.outerWidth();
                    }
                }
                
                navigation.width += menuPadding;
                centerLogo.css('visibility', 'visible');

                if (navigation.width + 30 > $(window).width()/2) {
                    navigation.container.addClass('nav-compress');
                } else {
                    navigation.container.removeClass('nav-compress');
                }
            }

            navigation.menu.removeClass('pre-compress');
        },

        hovershift: function() {
            // Submenu open in opposite direction if there's no enough space
            navigation.submenu.each(function() {
                var $this = $(this);
                var submenuLeft = $this.offset().left;
                var submenuRight = winWidth - submenuLeft - 200;
                if (submenuLeft < 0 || submenuRight < 0) {
                    $this.addClass('hover-shift');
                } else {
                    $this.removeClass('hover-shift');
                }
            });
        },

        rePosition: function() {
            var navWidth = navigation.container.outerWidth();
            var navOffset = navigation.menu.offset().left;

            navigation.megamenu.each(function() {
                var $menu = $(this);
                var $menuParent = $menu.parent();
                var menuOffset = $menuParent.offset().left;
                var menuWidth = $menu.attr('class').slice(-1) * 220 + 36; // get mega menu width setting from megamenu-custom-* class
                menuWidth = menuWidth > navWidth ? navWidth : menuWidth;
                $menu.css('width', menuWidth + 'px');
                
                // center mega menu
                var distance = menuWidth * 0.5 - $menuParent.outerWidth() * 0.5;
                var shiftRight = distance - menuOffset;
                var shiftLeft = menuWidth * 0.5 + $menuParent.outerWidth() * 0.5 + menuOffset - winWidth;
                // left edge
                if (shiftRight >= 0) {
                    $menu.css('margin-left', -1*(distance - shiftRight - 15) + 'px');
                // right edge
                } else if (shiftLeft >= 0) {
                    $menu.css('margin-left', (-1*distance - shiftLeft - 15) + 'px');
                // normal
                } else {
                    $menu.css('margin-left', -1*distance + 'px');
                }
            });
        },

        refresh: function() {
            if (!matchMinWidth(768) || navigation.menu.length === 0) {
                if (navigation.headerStyle === '3') {
                    navigation.container.addClass('nav-compress').removeClass('pre-compress');
                }
                return;
            }

            navigation.menu.superfish('destroy');
            if (navigation.cache && navigation.headerStyle != '3') {
                navigation.menu.html(navigation.cache);
            }

            navigation.compress();
            navigation.submenu = navigation.menu.find('.sub-menu');
            navigation.megamenu = navigation.menu.find('.megamenu-custom-width .megamenu');

            if (navigation.submenu.length) {
                navigation.hovershift();
            }

            if (navigation.megamenu.length) {
                navigation.rePosition();
            }

            navigation.sfmenu();
        }
    };

    /* -----------------------------------------------------------------------------
     * Sticky Navbar
     * ----------------------------------------------------------------------------- */

    var stickyHeader = (function(self) {

        var el;
        var option;
        var offset = 0;
        var lastScroll = 0;
        var isStuck = false;
        var isMaxY = false;
        var isMinY = true;
        var isTop = false;
        var ticking = false;
        var transformY = 0;
        var navbarHeight = 80;

        var always = function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    var currentScroll = $window.scrollTop();
                    if (currentScroll > offset) {
                        if (!isStuck) {
                            el.addClass('affix-on');

                            if (wpadminbar.fixed) {
                                el.css('top', wpadminbar.height + 'px');
                            }

                            if (isDesktop) {
                                el.find('.logo').hide();
                                el.find('.small-logo').fadeIn().css('display', 'table-cell');
                            }
                        }
                        isStuck = true;

                    } else {
                        if (isStuck) {
                            el.removeClass('affix-on').css('top', '');
                            if (isDesktop) {
                                el.find('.small-logo').hide();
                                el.find('.logo').fadeIn().css('display', 'table-cell');
                            }
                        }
                        isStuck = false;
                    }
                    ticking = false;
                });
                ticking = true;
            }
        };

        var smart = function() {
            var currentScroll = $window.scrollTop();
            var scrollDelta = currentScroll - lastScroll; // scroll distance

            if (wpadminbar.enabled && (wpadminbar.fixed || currentScroll === 0)) {
                el.css('top', wpadminbar.height + 'px');
            } else {
                el.css('top', '0');
            }

            if (currentScroll > offset) {
                if (!el.hasClass('affix-on')) {
                    el.addClass('affix-on');
                    if (isDesktop) {
                        el.find('.logo').hide();
                        el.find('.small-logo').fadeIn().css('display', 'table-cell');
                    }
                }

                // scroll up
                if (scrollDelta > 0 && !isMaxY) {
                    transformY -= scrollDelta;
                    if (transformY < -1*navbarHeight || transformY == -1*navbarHeight) {
                        transformY = -1*navbarHeight;
                        isMaxY = true;
                        if (!el.hasClass('affix-on')) {
                            el.addClass('affix-on');
                            if (isDesktop) {
                                el.find('.logo').hide();
                                el.find('.small-logo').fadeIn().css('display', 'table-cell');
                            }
                        }
                    }
                    requestAnimationFrame(function() {
                        cssTranslate3d(el[0], transformY);
                    });
                    isMinY = false;
                // scroll down
                } else if (scrollDelta < 0 && !isMinY) {
                    transformY += -1*scrollDelta;
                    if (transformY > 0 || transformY === 0) {
                        transformY = 0;
                        isMinY = true;
                    }
                    requestAnimationFrame(function() {
                        cssTranslate3d(el[0], transformY);
                    });
                    isMaxY = false;
                }

            } else {
                if (currentScroll === 0) {
                    el.removeClass('affix-on');
                    if (isDesktop) {
                        el.find('.small-logo').hide();
                        el.find('.logo').fadeIn().css('display', 'table-cell');
                    }
                    cssTranslate3d(el[0], 0);
                }
            }
            lastScroll = currentScroll;
        };

        function setup() {
            el.css('top', '');
            isStuck = false;
            ticking = false;
            navbarHeight = el.outerHeight();
        }

        function cssTranslate3d(elem, value) {
            var translate3d = 'translate3d(0,' + value + 'px, 0)';
            elem.style['-webkit-transform'] = translate3d;
            elem.style['-moz-transform'] = translate3d;
            elem.style['-ms-transform'] = translate3d;
            elem.style['-o-transform'] = translate3d;
            elem.style.transform = translate3d;
        }

        self.init = function() {
            el = $('.header-wrapper');

            if (el.length === 0) {
                return;
            }
            
            option = el.hasClass('affix-always') ? 'always' : '';
            option = el.hasClass('affix-smart') ? 'smart' : option;

            if (option === '' ) {
                return;
            }

            setup();
            
            switch(option) {
    
                case 'always':
                    window.addEventListener('scroll', always, false);
                    always();
                    break;
                
                case 'smart':
                    window.addEventListener('scroll', smart, false);
                    smart();
                    break;
            }
        };

        self.refresh = function() {
            if (el.length === 0 || option == '') {
                return;
            }

            el.removeClass('affix-on');
            if (isDesktop) {
                el.find('.small-logo').hide();
                el.find('.logo').fadeIn().css('display', 'table-cell');
            } else {
                el.find('.logo').hide();
                el.find('.small-logo').fadeIn().css('display', 'table-cell');
            }

            setup();

            switch(option) {

                case 'always':
                    window.addEventListener('scroll', always, false);
                    always();
                    break;
                
                case 'smart':
                    window.addEventListener('scroll', smart, false);
                    smart();
                    break;
            }
        };

        // determine the top distance for sticky elements like sticky sidebar
        self.getCushion = function() {
            var cushion = 0;

            if (el.length === 0) {
                return cushion;
            }
            
            if (option == 'always' || option == 'smart') {
                cushion += navbarHeight;
            }

            if (wpadminbar.fixed) {
                cushion += wpadminbar.height;
            }
            return cushion;
        }
        
        return self;

    })(stickyHeader || {});


    /* -----------------------------------------------------------------------------
     * Sticky Sidebar
     * ----------------------------------------------------------------------------- */

    function stickySidebar() {
        $('.sidebar.sticky').each(function() {
            $(this).theiaStickySidebar({
                containerSelector: $(this).parents('.row'),
                additionalMarginTop: (stickyHeader.getCushion() + 30),
                additionalMarginBottom: 30
            });
        });
    }

    var wpadminbar = {
        init: function() {
            var adminbar = $('#wpadminbar');
            if (adminbar.length) {
                this.enabled = true;
                this.height = adminbar.height();
                if (adminbar.css('position') === 'fixed') {
                    this.fixed = true;
                } else {
                    this.fixed = false;
                }
            } else {
                this.enabled = false;
                this.height = 0;
            }
        },
        fixed: false,
        height: 0,
        enabled: false,
    };

    function fullscreenHeader() {
        var screenImage = $('.fullscreen-image');
        var imageHeight = winHeight - wpadminbar.height;
        var scrollDistance = winHeight;

        if (wpadminbar.fixed) {
            scrollDistance -= stickyHeader.getCushion();
        }
        
        if (screenImage.length) {
            screenImage.css('height', imageHeight + 'px');
            $('#to-content,.to-content').on('click touchend', function() {
                $('html,body').stop().animate({ scrollTop: scrollDistance }, 600);
            });
        }

        $('.header-content').one('inview', function(event, visible) {
            $(this).addClass('inview');
        });
    }

    function updateEnvironment() {
        winHeight = $window.height();
        winWidth = $window.width();
        isPhone = matchMaxWidth(767);
        isTablet = matchMaxWidth(1019);
        isDesktop = matchMinWidth(1020);
    }

    function matchMaxWidth(width) {
        if (typeof Modernizr == 'object') {
            return Modernizr.mq('(max-width:' + width + 'px)');
        } else {
            return (winWidth > width);
        }
    }

    function matchMinWidth(width) {
        if (typeof Modernizr == 'object') {
            return Modernizr.mq('(min-width:' + width + 'px)');
        } else {
            return (winWidth < width);
        }
    }

    $window.on("resize orientationchange", $.debounce(200, function() {
        updateEnvironment();
        wpadminbar.init();
        navigation.refresh();
        stickyHeader.refresh();
        fullscreenHeader();
        stickySidebar();
    }));

}(jQuery, window, document);