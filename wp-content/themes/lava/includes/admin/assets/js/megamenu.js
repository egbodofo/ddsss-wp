/* -----------------------------------------------------------------------------
 * MegaMenu Edit Script
 * ----------------------------------------------------------------------------- */
(function($) {
	
	$(document).ready(function() {
		megamenu.init();
	});

	var megamenu = {

		init: function() {
			this.update();
			this.mouseup();
			this.checkbox();
			this.media();
		},

		mouseup: function() {
			$(document).on('mouseup', '.menu-item-bar', function(event, ui) {
				if (!$(event.target).is('a')) {
					setTimeout(megamenu.update, 400);
				}
			});
		},

		checkbox: function() {
			$(document).on('click', '.menu-item-lava-megamenu-enable', function() {
				var parentLi = $(this).parents('.menu-item:eq(0)');

				if ($(this).is(':checked')) {
					parentLi.addClass('lava-megamenu-active');
				} else {
					parentLi.removeClass('lava-megamenu-active');
				}
				megamenu.update();
			});
		},

		media: function() {
			var mediaFrame;
			
			$(document).on('click', '.lava-megamenu-set-image', function(e) {
				e.preventDefault();
				var $this = $(this);

		        // check for media manager instance
		        if (mediaFrame) {
		            mediaFrame.open();
		            return;
		        }
		        // configuration of the media manager new instance
		        mediaFrame = wp.media({
		            multiple: false,
		            library: {
		                type: 'image'
		            }
		        });

		        mediaFrame.open();
		        mediaFrame.on('select', set_image);
		        mediaFrame.on('close', set_image);

		       	function set_image() {
		       		var media_attachment = mediaFrame.state().get('selection').first().toJSON();

		       		if (!media_attachment) {
		       			return;
		       		}

		       		$this.siblings('input').val(media_attachment.url);
		       		$this.siblings('img').attr('src', media_attachment.url).show();
		       		$this.parents('.field-image').addClass('has-image');
		       	}
			});

			$(document).on('click', '.lava-megamenu-remove-image', function(e) {
				e.preventDefault();
				var $this = $(this);
				$this.siblings('input').val('');
				$this.siblings('img').attr('src', '');
				$this.parents('.field-icon').removeClass('has-image');
			});
		},

		update: function() {
			var menuItems = $('.menu-item');

			menuItems.each(function(i) 	{
				var checkBox = $('.menu-item-lava-megamenu-enable', this);

				if (!$(this).is('.menu-item-depth-0')) {
					var check_against = menuItems.filter(':eq(' + (i-1) + ')');

					if (check_against.is('.lava-megamenu-active')) {
						checkBox.attr('checked', 'checked');
						$(this).addClass('lava-megamenu-active');
					} else {
						$(this).removeClass('lava-megamenu-active');
					}

				} else {

					if (checkBox.attr('checked')) {
						$(this).addClass('lava-megamenu-active');
					} else {
						$(this).removeClass('lava-megamenu-active');
					}
				}
			});
		}
	};

})(jQuery);
