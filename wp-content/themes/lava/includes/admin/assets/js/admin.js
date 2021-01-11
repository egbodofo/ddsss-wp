/* -----------------------------------------------------------------------------
 * THEME SPIRIT admin.js
 * ----------------------------------------------------------------------------- */
(function(window, document, $) {

	var win = $(window),
		doc = $(document);

	// page builder setting
	var pageLayout = $('.rwmb-field.lava_page_layout'),
		pageContainer = $('.rwmb-field.lava_page_container'),
		pageSidebar = $('.rwmb-field.lava_page_sidebar'),
		templateSelect = $('#page_template');

	function bindTemplate() {
		if (templateSelect.val() == 'page-builder.php') {
			pageLayout.hide();
			pageContainer.show();
			pageSidebar.hide();
		} else if (templateSelect == 'default') {
			pageLayout.show();
			pageContainer.hide();
			pageSidebar.show();
		} else {
			pageLayout.show();
			pageContainer.show();
			pageSidebar.show();
		}
	}

	bindTemplate();

	templateSelect.on('change', function() {
		bindTemplate();
	});

	/* -----------------------------------------------------------------------------
	 * Admin Pages
	 * ----------------------------------------------------------------------------- */

	var adminWrap = $('#lava-admin-wrap');

	adminWrap.imagesLoaded(function() {
		adminWrap.show();
	});

	// theme activation
	
	var taForm = adminWrap.find('#lava-theme-activation-form'),
		taMsg = adminWrap.find('p.lava-theme-message'),
		takey = taForm.find('#lava-api-key'),
		taSpinner = taForm.find('.spinner');

	taForm.on('submit', function(e) {
		e.preventDefault();

		taSpinner.css('visibility', 'visible');

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: 'lava_activate_theme',
				api_key: takey.val(),
			},
			error: function(xhr, status) {
				console.log(xhr);
				console.log(status);
			},
			success: function(data) {console.log(data);
				taSpinner.css('visibility', 'hidden');
				if (!data.key_exist) {
					if (data.activated) {
						taForm.parent().removeClass('lava-theme-error').addClass('lava-theme-activated');
					} else {
						taForm.parent().removeClass('lava-theme-activated').addClass('lava-theme-error');
					}
					taMsg.html(data.message);
				}
			}
		});

	});


	// demo installer
	
	var toggleLever = adminWrap.find('.lava-toggle-lever');

	toggleLever.on('click', function() {
		var $this = $(this),
			$checkbox = $this.prev('input');

		if ($checkbox.is(':checked')) {
			$this.parent().removeClass('checked');
			$checkbox.attr('checked', false);
		} else {
			$this.parent().addClass('checked');
			$checkbox.attr('checked', true);
		}
	});

	var contentCheckbox = adminWrap.find('#lava-content-checkbox'),
		pluginReady = true;

	doc.on('click', 'input.lava-button-install', function() {
		var $this = $(this),
			parent = $this.parents('.lava-admin-item'),
			siblings = parent.siblings(),
			progressbar = parent.find('.lava-progressbar'),
			id = $this.data('demo-id'),
			demoContent,
			confirmed;

		if (contentCheckbox.is(':checked')) {
			demoContent = 'include';
		} else {
			demoContent = '';
		}

		var checkPlugins = $.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: {
				action: 'lava_check_plugins',
			},
			beforeSend: function() {
				parent.addClass('lava-demo-installing');
				siblings.removeClass('lava-demo-installed').addClass('lava-demo-disabled');
			},
			success: function(data) {
				if (data) {
					if (demoContent == 'include' && data.plugin_ready == false) {
						confirm(lava_admin_ajax.install_required_plugins);
						parent.removeClass('lava-demo-installing');
						siblings.removeClass('lava-demo-disabled');
					}
				}
			},
			error: function(xhr, status) {
				console.log(xhr);
				console.log(status);
			},
		});

		checkPlugins.done(function(data) {
			if (!contentCheckbox.is(':checked')) {
				confirmed = confirm(lava_admin_ajax.install_demo_option);
			} else {
				if (data.plugin_ready == false) {
					return;
				}
				confirmed = confirm(lava_admin_ajax.install_demo_full);
			}

			if (confirmed === true) {
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'lava_demo_installer',
						demo_action: 'install',
						demo_id: id,
						demo_content: demoContent
					},
					beforeSend: function() {
						lavaProgressbar.init(progressbar, 1.6, 54);
					},
					success: function(data) {
						lavaProgressbar.complete();
						setTimeout(function() {
							parent.removeClass('lava-demo-installing').addClass('lava-demo-installed');
							siblings.removeClass('lava-demo-disabled');
							lavaProgressbar.reset();
						}, 200);
					},
					error: function(xhr, status) {
						console.log(xhr);
						console.log(status);
					}
				});
			} else {
				parent.removeClass('lava-demo-installing');
				siblings.removeClass('lava-demo-disabled');
			}
		});

	});

	doc.on('click', 'input.lava-button-uninstall', function() {
		var $this = $(this),
		 	parent = $this.parents('.lava-admin-item'),
		 	siblings = parent.siblings(),
		 	progressbar = parent.find('.lava-progressbar'),
		 	confirmed = confirm(lava_admin_ajax.uninstall_demo);

		if (confirmed === true) {
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'lava_demo_installer',
					demo_action: 'uninstall',
				},
	 			beforeSend: function() {
	 				parent.removeClass('lava-demo-installed').addClass('lava-demo-uninstalling');
	 				siblings.addClass('lava-demo-disabled');
	 				lavaProgressbar.init(progressbar, 0.2, 10);
	 			},
				success: function(data) {
					lavaProgressbar.complete();
					setTimeout(function() {
						parent.removeClass('lava-demo-uninstalling');
						siblings.removeClass('lava-demo-disabled');
						lavaProgressbar.reset();
					}, 200);
				}
			});
		}
	});

	var lavaProgressbar = {
		init: function(elem, step, maxTime) {
			self = this;
			self.bar = elem;
			self.increment = 100/(maxTime/step);
			self.percent = 0;
			self.timer = setInterval(function() {
				self.percent += self.increment;
				if (self.percent < 96) {
					self.bar.css('width', self.percent + '%');
				} else {
					clearInterval(self.timer);
				}
			}, step*1000);
		},
		complete: function() {
			this.bar.css('width', '100%');
			clearInterval(this.timer);
		},
		reset: function() {
			this.bar.css('width', '0');
		}
	};

	/**
	 * Add/Remove Widgets
	 */

	var widgetForm = adminWrap.find('#lava-add-wa-form'),
		widgetMsg = widgetForm.find('#lava-wa-message'),
		widgetList = adminWrap.find('#lava-wa-list');

	widgetForm.on('submit', function(e) {
		e.preventDefault();

		var name = widgetForm.find('#lava-wa-name'),
		    desc = widgetForm.find('#lava-wa-desc');

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: {
				action: 'lava_widget_areas',
				wa_action: 'add',
				wa_name: name.val(),
				wa_desc: desc.val()
			},
			success: function(response) {
				if (response.error === false) {
					widgetList.append(response.data);
					widgetToggle();
					name.val('');
					desc.val('');
				}
				widgetMsg.html(response.message);
				setTimeout(function() {
					widgetMsg.empty();
				}, 2000);
			}
		});
	});

	doc.on('click', 'a.lava-button-remove-wa', function(e) {
		e.preventDefault();

		var $this = $(this),
			li = $this.parents('li'),
			id = $this.data('id'),
			confirmed = confirm('This will remove any widgets you have assigned to ' + id + '.\n\n' + 'Are you sure to remove this widget area?');
		
		if (confirmed === true) {
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajaxurl,
				data: {
					action: 'lava_widget_areas',
					wa_action: 'remove',
					wa_id: id,
				},
				success: function(response) {
					if (response.error === false) {
						li.remove();
					}
					widgetMsg.html(response.message);
					setTimeout(function() {
						widgetMsg.empty();
					}, 2000);
				}
			});
		}

	});


	/**
	 * Widget Toggle
	 */
	
	widgetToggle();

	function widgetToggle() {
		var widgetName = widgetList.find('.lava-wa-name');
		widgetName.off('click');
		widgetName.on('click', function() {
			$(this).parent('li').toggleClass('active');
		});
	}


	/* -----------------------------------------------------------------------------
	 * Theme Fonts
	 * ----------------------------------------------------------------------------- */

	var fontPreviewLi = $('#lava-font-preview > li');
	var fontDetailsLi = $('#lava-font-details > li');
	var fonts = $('span.lava-font-family[data-source="Google"]');

	fonts.each(function() {
		var fontFamily = $(this).html();
		fontFamily = fontFamily.replace('/\s/', '+');
		appendGoogleFontUrl(fontFamily);
	});

	fontPreviewLi.eq(0).addClass('active');
	fontDetailsLi.eq(0).show();

	doc.on('click', '#lava-font-preview > li', function() {
		var $this = $(this);
		var index = $this.parent().children().index($this);
		$this.addClass('active').siblings().removeClass('active');
		$('#lava-font-details > li').eq(index).show().siblings().hide();
	});

	doc.on('click', '.lava-font-variant-subset label', function() {
		var $this = $(this);
		var checkbox = $this.find('input');

		if (checkbox.is(':checked')) {
			checkbox.attr('checked', '');
		} else {
			checkbox.attr('checked');
		}
	});


	// Add a font to font list

	var fontProcessing = false;

	doc.on('click', 'a.lava-add-font', function() {

		if ( fontProcessing ) {
			return false;
		}

		fontProcessing = true;

		var $this = $(this);
		var fontFamily = $this.parent().prev().html();
		var fontExist = false;

		$('h2.lava-font-family').each(function() {
			if (fontFamily == $(this).html()) {
				fontExist = true;
				fontProcessing = true;
			}
		});

		if (fontExist) {
			fontProcessing = false;
			return false;
		}

		if ($this.parents('#lava-custom-fonts').length) {
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: 'lava_add_font',
					font_family: fontFamily,
					source: 'custom'
				},
				success: function(data) {
					$('#lava-font-preview').append(data.preview);
					$('#lava-font-details').append(data.details);
					$('#lava-font-preview > li').last().addClass('active').siblings().removeClass('active');
					$('#lava-font-details > li').last().show().siblings().hide();
					fontProcessing = false;
				}
			});
		} else {
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'lava_add_font',
					font_family: fontFamily,
					source: 'google'
				},
				success: function(data) {
					$('#lava-font-preview').append('<li><span class="lava-font-specimen" style="font-family:' + fontFamily + '">Grumpy wizards make toxic brew for the evil Queen and Jack.</span><span class="lava-font-family">' + fontFamily + '</span><a href="javascript:void(0)" class="lava-remove-font">X</a></li>');
					$('#lava-font-details').append(data);
					fontFamily = fontFamily.replace('/\s/', '+');
					appendGoogleFontUrl(fontFamily);
					$('#lava-font-preview > li').last().addClass('active').siblings().removeClass('active');
					$('#lava-font-details > li').last().show().siblings().hide();
					fontProcessing = false;
				}
			});
		}
	});


	// Remove a font from font list

	doc.on('click', 'a.lava-remove-font', function() {
		var $this = $(this);
		var index = $this.parents('#lava-font-preview').children().index($this.parent());
		$this.parent().remove();
		$('#lava-font-details > li').eq(index).remove();
		$('#lava-font-details > li').eq(0).show();
		$('#lava-font-preview > li').eq(0).addClass('active').siblings().removeClass('active');
	});


	// Save font list

	$('#lava-save-fonts .lava-button-submit').on('click', function() {
		var fontData = {};
		var fontSaveSpinner = $(this).siblings('.spinner');
		var fontSaveMsg = $(this).siblings('.lava-form-message');

		fontSaveSpinner.css('visibility', 'visible');
		fontSaveMsg.hide();

		$('#lava-font-details > li').each(function(i) {
			var $this = $(this);
			var font = {};
			var fontFamily = $this.find('h2.lava-font-family').html();
			var fontVariants = $this.find('input.lava-check-variant');
			var variantsChecked = 0;

			font.family = fontFamily;
			font.source = '';
			font.variants = '';

			if ($this.find('div.lava-font-source:contains(Google)').length) {
				font.source = 'Google';
			} else {
				font.source = 'Custom';
			}

			if (font.source == 'Google') {
				fontVariants.each(function(i) {
					var $this = $(this);
					if ($this.is(':checked') || $this.is(':disabled')) {
						if (variantsChecked == 0) {
							font.variants = $this.data('variant');
						} else {
							font.variants = font.variants + ',' + $this.data('variant');
						}
						variantsChecked ++;
					}
				});
			}
			fontData[i] = font;
		});

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'lava_save_fonts',
				fontData: fontData
			},
			success: function(response) {
				fontSaveSpinner.css('visibility', 'hidden');
				fontSaveMsg.html(response).fadeIn();
			}
		});
	});

	// Append google fonts url

	function appendGoogleFontUrl(fontFamily) {
		link = document.createElement('link');
		link.rel = 'stylesheet';
		link.href = 'https://fonts.googleapis.com/css?family=' + fontFamily;
		link.type = 'text/css';
		$('head').append(link);
	}

	// Google fonts filter

	var googleFontList = $('#lava-google-fonts .lava-font-list');
	googleFontList.find('.lava-fi-A').show();

	$('#lava-font-filter a').eq(0).addClass('active');

	$('#lava-font-filter a').on('click', function() {
		var $this = $(this);
		var fontStartLetter = $this.html();
		$this.addClass('active').siblings().removeClass('active');
		googleFontList.children().hide();
		googleFontList.find('.lava-fi-' + fontStartLetter).show();
	});

	// Hide custom font section if there's no fonts

	function showCustomFontList() {
		var customFontList = $('#lava-custom-fonts').find('.lava-font-list').children();
		if (customFontList.length > 0) {
			$('#lava-custom-fonts').show();
		} else {
			$('#lava-custom-fonts').hide();
		}
	}

	showCustomFontList();

	var fontFiles = {};

	$('input.lava-upload-submit').on('click', function() {
		$(this).siblings(':file').click();
	});

	$('input.lava-upload-remove').on('click', function() {
		$(this).siblings(':file').val('').trigger('change');
		$(this).parent().prev('span').html('');
	});

	$('input.lava-ff').on('change', function(event) {
		var $this = $(this);
		var display = $this.parent().prev('span');
		var type = $this[0].type;
		var fileName = $this.val().replace(/\\/g, '/').replace(/.*\//, '');

		switch ($this.attr('id')) {
			case 'lava-ff-woff': fontFiles.woff = event.target.files; break;
			case 'lava-ff-ttf': fontFiles.ttf = event.target.files; break;
			case 'lava-ff-eot': fontFiles.eot = event.target.files; break;
			case 'lava-ff-svg': fontFiles.svg = event.target.files; break;
			case 'lava-ff-woff2': fontFiles.woff2 = event.target.files; break;
		}

		if (fileName !== '') {
			display.html(fileName);
		}
	});

	$('#lava-form-custom-font').on('submit', function(e) {
		e.preventDefault();

		var $this = $(this);
		var data = new FormData();
		var fontName = $this.find('#lava-custom-font-name').val();
		var fontFormNonce = $this.find('#lava-save-cf-nonce').val();
		var fontFormMsg = $this.prev('.lava-form-message');
		var fontFormSpinner = $this.find('div.spinner');
		
		data.append('action', 'lava_save_custom_font');
		data.append('font_name', fontName);
		data.append('security', fontFormNonce);

		$.each(fontFiles, function(key, value) {
			data.append(key, value[0]);
		});

		fontFormSpinner.css('visibility', 'visible');

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			success: function(response) {
				fontFormSpinner.css('visibility', 'hidden');
				if (typeof response.error !== 'undefined') {
					fontFormMsg.html(response.error);
				}
				if (typeof response.success !== 'undefined') {
					fontFormMsg.html(response.success);
					fontFiles = {};
					$('#lava-custom-fonts .lava-font-list').append('<li><span>' + fontName + '</span><div class="lava-font-actions"><a href="javascript:void(0)" class="lava-add-font">+</a><a href="javascript:void(0)" class="lava-remove-custom-font">&ndash;</a></div></li>');
					$('input.lava-upload-remove').trigger('click');
					$this.find('#lava-custom-font-name').val('');
				}
				showCustomFontList();
			}
		});
	});

	doc.on('click', 'a.lava-remove-custom-font', function() {
		var $this = $(this);
		var fontName = $this.parent().siblings('span').html();
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'lava_remove_custom_font',
				font_name: fontName
			},
			success: function(response) {
				$this.parents('li').remove();
				$('span.lava-font-family:contains(' + fontName + ')').parents('li').remove();
				$('h2.lava-font-family:contains(' + fontName + ')').parents('li').remove();
				$('#lava-font-preview > li').first().addClass('active').siblings().removeClass('active');
				$('#lava-font-details > li').first().show().siblings().hide();
				showCustomFontList();
			},
			error: function(xhr, status) {
				console.log(xhr);
				console.log(status);
			},
		});
	});

})(window, document, jQuery);