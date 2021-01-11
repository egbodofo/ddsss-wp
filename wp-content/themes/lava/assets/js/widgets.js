(function($) {
	
    if ($('.lava-toggles').length) {

        $(document).on('click', '.lava-toggle-title', function(e) {
            e.preventDefault();
            var toggle = $(this).parent();
            var toggleIcon = toggle.find('.material-icons');
            var togglePanel = toggle.find('.lava-toggle-panel');
            toggle.toggleClass('lava-toggle-active');
            togglePanel.slideToggle();

            if (toggle.hasClass('lava-toggle-active')) {
                toggleIcon.html('remove');
            } else {
                toggleIcon.html('add');
            }
        });

        $('.lava-toggle-active').each(function() {
            $(this).find('.material-icons').html('remove');
            $(this).find('.lava-toggle-panel').show();
        });
    }

    if ($('.lava-accordion').length) {

        $(document).on('click', '.lava-accordion-title', function(e) {
            e.preventDefault();
            var currentItem = $(this).parent();

            if (currentItem.hasClass('lava-accordion-active')) {
                currentItem.removeClass('lava-accordion-active');
                currentItem.find('.material-icons').html('add');
                currentItem.find('.lava-accordion-panel').slideUp();
            } else {
                var lastItem = currentItem.parent().find('.lava-accordion-active');
                if (lastItem.length) {
                    lastItem.removeClass('lava-accordion-active');
                    lastItem.find('.material-icons').html('add');
                    lastItem.find('.lava-accordion-panel').slideUp();
                }
                currentItem.addClass('lava-accordion-active');
                currentItem.find('.material-icons').html('remove');
                currentItem.find('.lava-accordion-panel').slideDown();
            }
        });

        $('.lava-accordion-active').each(function() {
            $(this).find('.material-icons').html('remove');
            $(this).find('.lava-accordion-panel').show();
        });

    }

    var Lava_Amenities = {

        init: function() {
            var amenitiesWrapper = $('.lava-amenities');
            var amenitiesIconsWrapper = $('.lava-amenities-icons');
            
            if (amenitiesWrapper.length) {
                amenitiesWrapper.each(function() {
                    var $this = $(this);
                    var titles = $this.find('.lava-amenity-title');
                    var descriptions = $this.find('.lava-amenity-description');
                    var width = 0;

                    // get max width
                    titles.each(function() {
                        width = Math.max($(this).width(), width);
                    });

                    descriptions.each(function() {
                        var desc = $(this);
                        desc.css('white-space', '');
                        width = Math.max(desc.width(), width);
                        if (desc.width() > desc.parent().width()) {
                            desc.css('white-space', 'normal');
                        }
                    });

                    var columns = Math.floor($this.width()/(width*2));
                    if ($this.width() < 850 && columns > 2) {
                        columns = 2;
                    }
                    $this.find('.lava-amenity').css('width', Lava_Amenities.getWidth(columns));
                    $this.css('visibility', 'visible');
                });
            }

            if (amenitiesIconsWrapper.length) {
                amenitiesIconsWrapper.each(function() {
                    var $this = $(this);
                    var amenity = $this.find('.lava-amenity');
                    var maxWidth = 0;

                    // get max width
                    amenity.each(function() {
                        $(this).css('width', '');
                        maxWidth = Math.max($(this).width(), maxWidth);
                    });

                    var columns = Math.floor($this.width()/(maxWidth + 30));

                    $this.find('.lava-amenity').css('width', Lava_Amenities.getWidth(columns));
                    $this.css('visibility', 'visible');
                });
            }
        },

        getWidth: function(columns) {
            var colWidth = '';
            switch(columns) {
                case 0:
                case 1: colWidth = '100%'; break;
                case 2: colWidth = '50%'; break;
                case 3: colWidth = '33.33333333%'; break;
                default: colWidth = '25%'; break;
            }
            return colWidth;
        },
    }

	var Lava_Tabs = {

	    hash: '',

	    init: function() {

	    	if ($('.lava-tabs').length === 0) {
	    		return;
	    	}

	        $(document).on('click', '.lava-tab', function(e) {
	            e.preventDefault();
	            Lava_Tabs.switchTab($(this));
	            Lava_Tabs.changeHash();
	        });

	        $('.lava-tab-nav').each(function() {
	            var hash = window.location.hash;
	            if (hash === '') {
	                Lava_Tabs.switchTab($(this).children().first());
	            } else {
	                hash = hash.replace('#tab-', '#');
	                hash = hash.substr(0, hash.lastIndexOf('-'));
	                var currentTab = $(this).find('a[href*="' + hash + '"]');
	                if (currentTab.length) {
	                    Lava_Tabs.switchTab(currentTab);
	                }
	            }
	        });
	    },

	    switchTab: function(element) {
	        this.hash = element.attr('href');
	        element.addClass('lava-active').siblings().removeClass('lava-active');
	        $(this.hash).addClass('lava-active').siblings().removeClass('lava-active');
	    },

	    changeHash: function() {
	        if (this.hash !== '') {
	            window.location.hash = this.hash.replace('#', '#tab-');
	            this.hash = '';
	        }
	    }
	};

    var Lava_Image_Grid = {
        
        init:function() {
            var $grid = $('.lava-image-grid-images');

            if ($grid.length === 0) {
            	return;
            }
            
            $(document).on('click', '.lava-image-filter-item', function() {
                var $this = $(this);
                if (!$this.hasClass('active')) {
                    $this.parent().find('.active').removeClass('active');
                    $this.addClass('active');
                }
            });

            var resizeGrid = function() {
                $grid.each(function() {
                    var $gridEl = $(this);
                    var layouts = $gridEl.data('layouts');
                    var tabletQuery = window.matchMedia('(max-width: ' + layouts.tablet.breakPoint + 'px)');
                    var mobileQuery = window.matchMedia('(max-width: ' + layouts.mobile.breakPoint + 'px)');
                    var layout = layouts.desktop;
                    if(mobileQuery.matches) {
                        layout = layouts.mobile;
                    } else if (tabletQuery.matches) {
                        layout = layouts.tablet;
                    }
                    var numColumns = layout.numColumns;
                    $gridEl.css('width', 'auto');
                    var horizontalGutterSpace = layout.gutter * ( numColumns - 1 );
                    var columnWidth = Math.floor( ( $gridEl.width() - ( horizontalGutterSpace ) ) / numColumns );
                    $gridEl.width( ( columnWidth * numColumns ) + horizontalGutterSpace );

                    $gridEl.imagesLoaded( function() {
                        $gridEl.find('>.lava-image-item').each(function() {
                            var $$ = $(this);
                            var colSpan = $$.data('colSpan');
                            colSpan = Math.max(Math.min(colSpan, layout.numColumns), 1);
                            $$.width( ( columnWidth * colSpan ) + (layout.gutter * (colSpan-1)));
                            var rowSpan = $$.data('rowSpan');
                            rowSpan = Math.max(Math.min(rowSpan, layout.numColumns), 1);
                            //Use rowHeight if non-zero else fall back to matching columnWidth.
                            var rowHeight = layout.rowHeight || columnWidth;
                            $$.css('height', (rowHeight * rowSpan) + (layout.gutter * (rowSpan-1)));

                            var $img = $$.find('>img,>a>img');
                            var imgAR = $img.attr('height') > 0 ? $img.attr('width')/$img.attr('height') : 1;
                            var itemAR = $$.height() > 0 ? $$.width()/$$.height() : 1;
                            imgAR = parseFloat(imgAR.toFixed(3));
                            itemAR = parseFloat(itemAR.toFixed(3));
                            if (imgAR > itemAR) {
                                $img.css('width', 'auto');
                                $img.css('height', '100%');
                                var marginTop = ($img.height() - $$.height()) * -0.5;
                                var marginLeft = ($img.width() - $$.width()) * -0.5;
                                $img.css('margin-top', marginTop+'px');
                                $img.css('margin-left', marginLeft+'px');
                            }
                            else {
                                $img.css('height', 'auto');
                                $img.css('width', '100%');
                                $img.css('margin-left', '');
                                var marginTop = ($img.height() - $$.height()) * -0.5;
                                $img.css('margin-top', marginTop+'px');
                            }
                        });
                        
                        $gridEl.find('.lava-image-item').each(function() {
                            $(this).hoverdir();
                        });

                        var $gridInstance = $gridEl.isotope({
                            layoutMode: 'packery',
                            itemSelector: '.lava-image-item',
                            packery: {
                                columnWidth: columnWidth,
                                gutter: layout.gutter
                            }
                        });

                        var $filter = $gridEl.siblings('.lava-image-grid-filters');

                        if ($filter.length) {
                            $filter.on('click', 'button', function() {
                                var filterValue = $(this).attr('data-filter');
                                $gridInstance.isotope({ filter: filterValue });
                            });
                        }
                    });
                });
            };

            $(window).on('resize panelsStretchRows', resizeGrid);

            // Ensure that the masonry has resized correctly on load.
            setTimeout( function() {
                resizeGrid();
            }, 100 );
        }
    };

    $(document).ready(function() {

        Lava_Amenities.init();
        Lava_Tabs.init();
        Lava_Image_Grid.init();
    });

    $(window).on('resize orientationchange', function() {
        Lava_Amenities.init();
    });

})(jQuery);
