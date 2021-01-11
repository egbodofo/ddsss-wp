<?php
	/*------------------------------ Global First Color -----------*/

	$pool_services_lite_first_color = get_theme_mod('pool_services_lite_first_color');

	$pool_services_lite_custom_css = '';

	if($pool_services_lite_first_color != false){
		$pool_services_lite_custom_css .='.top-bar, span.cart-value, #about-section h2, input[type="submit"], #footer .tagcloud a:hover, #sidebar .custom-social-icons i, #footer .custom-social-icons i, #footer-2, #sidebar h3, .pagination .current, .pagination a:hover, #sidebar .tagcloud a:hover, #comments input[type="submit"], nav.woocommerce-MyAccount-navigation ul li,.toggle, #comments a.comment-reply-link, #sidebar .widget_price_filter .ui-slider .ui-slider-range, #sidebar .widget_price_filter .ui-slider .ui-slider-handle, #sidebar .woocommerce-product-search button, #footer .widget_price_filter .ui-slider .ui-slider-range, #footer .widget_price_filter .ui-slider .ui-slider-handle, #footer .woocommerce-product-search button, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .nav-previous a, .nav-next a{';
			$pool_services_lite_custom_css .='background-color: '.esc_attr($pool_services_lite_first_color).';';
		$pool_services_lite_custom_css .='}';
	}
	if($pool_services_lite_first_color != false){
		$pool_services_lite_custom_css .='a, #footer li a:hover, #footer .custom-social-icons i:hover, #footer caption, .post-main-box:hover h2, #sidebar ul li a:hover, .post-navigation a:hover .post-title, .post-navigation a:focus .post-title, .scrollup i, .entry-content a, .post-main-box:hover h2 a, .main-navigation a:hover, .main-navigation ul.sub-menu a:hover, .entry-content a, #sidebar .textwidget p a, .textwidget p a, #comments p a, .slider .inner_carousel p a, .phone, .envelope{';
			$pool_services_lite_custom_css .='color: '.esc_attr($pool_services_lite_first_color).';';
		$pool_services_lite_custom_css .='}';
	}
	if($pool_services_lite_first_color != false){
		$pool_services_lite_custom_css .='.scrollup i{';
			$pool_services_lite_custom_css .='border-color: '.esc_attr($pool_services_lite_first_color).';';
		$pool_services_lite_custom_css .='}';
	}
	if($pool_services_lite_first_color != false){
		$pool_services_lite_custom_css .='.main-navigation ul ul{';
			$pool_services_lite_custom_css .='border-top-color: '.esc_attr($pool_services_lite_first_color).';';
		$pool_services_lite_custom_css .='}';
	}
	if($pool_services_lite_first_color != false){
		$pool_services_lite_custom_css .='#footer h3:after, .main-navigation ul ul{';
			$pool_services_lite_custom_css .='border-bottom-color: '.esc_attr($pool_services_lite_first_color).';';
		$pool_services_lite_custom_css .='}';
	}

	/*------------------------------ Global Second Color -----------*/

	$pool_services_lite_second_color = get_theme_mod('pool_services_lite_second_color');

	if($pool_services_lite_second_color != false){
		$pool_services_lite_custom_css .='.logo, #slider .carousel-control-prev-icon, #slider .carousel-control-next-icon, .more-btn a, .pagination span, .pagination a, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce span.onsale, #footer a.custom_read_more, #sidebar a.custom_read_more, #sidebar .custom-social-icons i:hover, .woocommerce nav.woocommerce-pagination ul li a, .nav-previous a:hover, .nav-next a:hover, .wp-block-button__link{';
			$pool_services_lite_custom_css .='background-color: '.esc_attr($pool_services_lite_second_color).';';
		$pool_services_lite_custom_css .='}';
	}
	if($pool_services_lite_second_color != false){
		$pool_services_lite_custom_css .='a, .woocommerce-message::before, .woocommerce-info::before{';
			$pool_services_lite_custom_css .='color: '.esc_attr($pool_services_lite_second_color).';';
		$pool_services_lite_custom_css .='}';
	}
	if($pool_services_lite_second_color != false){
		$pool_services_lite_custom_css .='.more-btn a:before, .more-button a:before, .wp-block-button__link:before{';
			$pool_services_lite_custom_css .='border-left-color: '.esc_attr($pool_services_lite_second_color).';';
		$pool_services_lite_custom_css .='}';
	}
	if($pool_services_lite_second_color != false){
		$pool_services_lite_custom_css .='.logo:before, .woocommerce-message, .woocommerce-info{';
			$pool_services_lite_custom_css .='border-top-color: '.esc_attr($pool_services_lite_second_color).';';
		$pool_services_lite_custom_css .='}';
	}
	if($pool_services_lite_second_color != false){
		$pool_services_lite_custom_css .='.header-fixed{';
			$pool_services_lite_custom_css .='border-bottom-color: '.esc_attr($pool_services_lite_second_color).';';
		$pool_services_lite_custom_css .='}';
	}

	/*---------------------------Width Layout -------------------*/

	$pool_services_lite_theme_lay = get_theme_mod( 'pool_services_lite_width_option','Full Width');
    if($pool_services_lite_theme_lay == 'Boxed'){
		$pool_services_lite_custom_css .='body{';
			$pool_services_lite_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$pool_services_lite_custom_css .='}';
	}else if($pool_services_lite_theme_lay == 'Wide Width'){
		$pool_services_lite_custom_css .='body{';
			$pool_services_lite_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$pool_services_lite_custom_css .='}';
	}else if($pool_services_lite_theme_lay == 'Full Width'){
		$pool_services_lite_custom_css .='body{';
			$pool_services_lite_custom_css .='max-width: 100%;';
		$pool_services_lite_custom_css .='}';
	}

	/*--------------------------- Slider Opacity -------------------*/

	$pool_services_lite_theme_lay = get_theme_mod( 'pool_services_lite_slider_opacity_color','0.4');
	if($pool_services_lite_theme_lay == '0'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.1'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.1';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.2'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.2';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.3'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.3';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.4'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.4';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.5'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.5';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.6'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.6';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.7'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.7';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.8'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.8';
		$pool_services_lite_custom_css .='}';
		}else if($pool_services_lite_theme_lay == '0.9'){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='opacity:0.9';
		$pool_services_lite_custom_css .='}';
		}

	/*---------------------------Slider Content Layout -------------------*/

	$pool_services_lite_theme_lay = get_theme_mod( 'pool_services_lite_slider_content_option','Center');
    if($pool_services_lite_theme_lay == 'Left'){
		$pool_services_lite_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, #slider .more-btn{';
			$pool_services_lite_custom_css .='text-align:left; left:15%; right:45%;';
		$pool_services_lite_custom_css .='}';
	}else if($pool_services_lite_theme_lay == 'Center'){
		$pool_services_lite_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, #slider .more-btn{';
			$pool_services_lite_custom_css .='text-align:center; left:20%; right:20%;';
		$pool_services_lite_custom_css .='}';
	}else if($pool_services_lite_theme_lay == 'Right'){
		$pool_services_lite_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, #slider .more-btn{';
			$pool_services_lite_custom_css .='text-align:right; left:45%; right:15%;';
		$pool_services_lite_custom_css .='}';
	}

	/*---------------------------Slider Height ------------*/

	$pool_services_lite_slider_height = get_theme_mod('pool_services_lite_slider_height');
	if($pool_services_lite_slider_height != false){
		$pool_services_lite_custom_css .='#slider img{';
			$pool_services_lite_custom_css .='height: '.esc_attr($pool_services_lite_slider_height).';';
		$pool_services_lite_custom_css .='}';
	}

	/*--------------------------- Slider -------------------*/

	$pool_services_lite_slider = get_theme_mod('pool_services_lite_slider_arrows');
	if($pool_services_lite_slider == false){
		$pool_services_lite_custom_css .='.logo{';
			$pool_services_lite_custom_css .='top: -50px;';
		$pool_services_lite_custom_css .='}';
	}

	/*---------------------------Blog Layout -------------------*/

	$pool_services_lite_theme_lay = get_theme_mod( 'pool_services_lite_blog_layout_option','Default');
    if($pool_services_lite_theme_lay == 'Default'){
		$pool_services_lite_custom_css .='.post-main-box{';
			$pool_services_lite_custom_css .='';
		$pool_services_lite_custom_css .='}';
	}else if($pool_services_lite_theme_lay == 'Center'){
		$pool_services_lite_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, .post-main-box .more-btn{';
			$pool_services_lite_custom_css .='text-align:center;';
		$pool_services_lite_custom_css .='}';
		$pool_services_lite_custom_css .='.post-info{';
			$pool_services_lite_custom_css .='margin-top:10px;';
		$pool_services_lite_custom_css .='}';
		$pool_services_lite_custom_css .='.post-info hr{';
			$pool_services_lite_custom_css .='margin:15px auto;';
		$pool_services_lite_custom_css .='}';
	}else if($pool_services_lite_theme_lay == 'Left'){
		$pool_services_lite_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, .post-main-box .more-btn, #our-services p{';
			$pool_services_lite_custom_css .='text-align:Left;';
		$pool_services_lite_custom_css .='}';
		$pool_services_lite_custom_css .='.post-info hr{';
			$pool_services_lite_custom_css .='margin-bottom:10px;';
		$pool_services_lite_custom_css .='}';
		$pool_services_lite_custom_css .='.post-main-box h2{';
			$pool_services_lite_custom_css .='margin-top:10px;';
		$pool_services_lite_custom_css .='}';
	}

	/*------------------------------Responsive Media -----------------------*/

	$pool_services_lite_resp_stickyheader = get_theme_mod( 'pool_services_lite_stickyheader_hide_show',false);
    if($pool_services_lite_resp_stickyheader == true){
    	$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='.header-fixed{';
			$pool_services_lite_custom_css .='display:block;';
		$pool_services_lite_custom_css .='} }';
	}else if($pool_services_lite_resp_stickyheader == false){
		$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='.header-fixed{';
			$pool_services_lite_custom_css .='display:none;';
		$pool_services_lite_custom_css .='} }';
	}

	$pool_services_lite_resp_slider = get_theme_mod( 'pool_services_lite_resp_slider_hide_show',false);
    if($pool_services_lite_resp_slider == true){
    	$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='#slider{';
			$pool_services_lite_custom_css .='display:block;';
		$pool_services_lite_custom_css .='} }';
	}else if($pool_services_lite_resp_slider == false){
		$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='#slider{';
			$pool_services_lite_custom_css .='display:none;';
		$pool_services_lite_custom_css .='} }';
	}

	$pool_services_lite_resp_metabox = get_theme_mod( 'pool_services_lite_metabox_hide_show',true);
    if($pool_services_lite_resp_metabox == true){
    	$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='.post-info{';
			$pool_services_lite_custom_css .='display:block;';
		$pool_services_lite_custom_css .='} }';
	}else if($pool_services_lite_resp_metabox == false){
		$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='.post-info{';
			$pool_services_lite_custom_css .='display:none;';
		$pool_services_lite_custom_css .='} }';
	}

	$pool_services_lite_resp_sidebar = get_theme_mod( 'pool_services_lite_sidebar_hide_show',true);
    if($pool_services_lite_resp_sidebar == true){
    	$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='#sidebar{';
			$pool_services_lite_custom_css .='display:block;';
		$pool_services_lite_custom_css .='} }';
	}else if($pool_services_lite_resp_sidebar == false){
		$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='#sidebar{';
			$pool_services_lite_custom_css .='display:none;';
		$pool_services_lite_custom_css .='} }';
	}

	$pool_services_lite_resp_scroll_top = get_theme_mod( 'pool_services_lite_resp_scroll_top_hide_show',true);
    if($pool_services_lite_resp_scroll_top == true){
    	$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='.scrollup i{';
			$pool_services_lite_custom_css .='display:block;';
		$pool_services_lite_custom_css .='} }';
	}else if($pool_services_lite_resp_scroll_top == false){
		$pool_services_lite_custom_css .='@media screen and (max-width:575px) {';
		$pool_services_lite_custom_css .='.scrollup i{';
			$pool_services_lite_custom_css .='display:none !important;';
		$pool_services_lite_custom_css .='} }';
	}

	/*-------------- Sticky Header Padding ----------------*/

	$pool_services_lite_sticky_header_padding = get_theme_mod('pool_services_lite_sticky_header_padding');
	if($pool_services_lite_sticky_header_padding != false){
		$pool_services_lite_custom_css .='.header-fixed{';
			$pool_services_lite_custom_css .='padding: '.esc_attr($pool_services_lite_sticky_header_padding).';';
		$pool_services_lite_custom_css .='}';
	}

	/*------------------ Search Settings -----------------*/

	$pool_services_lite_search_font_size = get_theme_mod('pool_services_lite_search_font_size');
	if($pool_services_lite_search_font_size != false){
		$pool_services_lite_custom_css .='.search-box i{';
			$pool_services_lite_custom_css .='font-size: '.esc_attr($pool_services_lite_search_font_size).';';
		$pool_services_lite_custom_css .='}';
	}

	/*------------- Single Blog Page------------------*/

	$pool_services_lite_single_blog_post_navigation_show_hide = get_theme_mod('pool_services_lite_single_blog_post_navigation_show_hide',true);
	if($pool_services_lite_single_blog_post_navigation_show_hide != true){
		$pool_services_lite_custom_css .='.post-navigation{';
			$pool_services_lite_custom_css .='display: none;';
		$pool_services_lite_custom_css .='}';
	}

	/*-------------- Copyright Alignment ----------------*/

	$pool_services_lite_copyright_alingment = get_theme_mod('pool_services_lite_copyright_alingment');
	if($pool_services_lite_copyright_alingment != false){
		$pool_services_lite_custom_css .='.copyright p{';
			$pool_services_lite_custom_css .='text-align: '.esc_attr($pool_services_lite_copyright_alingment).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_copyright_padding_top_bottom = get_theme_mod('pool_services_lite_copyright_padding_top_bottom');
	if($pool_services_lite_copyright_padding_top_bottom != false){
		$pool_services_lite_custom_css .='#footer-2{';
			$pool_services_lite_custom_css .='padding-top: '.esc_attr($pool_services_lite_copyright_padding_top_bottom).'; padding-bottom: '.esc_attr($pool_services_lite_copyright_padding_top_bottom).';';
		$pool_services_lite_custom_css .='}';
	}

	/*----------------Sroll to top Settings ------------------*/

	$pool_services_lite_scroll_to_top_font_size = get_theme_mod('pool_services_lite_scroll_to_top_font_size');
	if($pool_services_lite_scroll_to_top_font_size != false){
		$pool_services_lite_custom_css .='.scrollup i{';
			$pool_services_lite_custom_css .='font-size: '.esc_attr($pool_services_lite_scroll_to_top_font_size).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_scroll_to_top_padding = get_theme_mod('pool_services_lite_scroll_to_top_padding');
	$pool_services_lite_scroll_to_top_padding = get_theme_mod('pool_services_lite_scroll_to_top_padding');
	if($pool_services_lite_scroll_to_top_padding != false){
		$pool_services_lite_custom_css .='.scrollup i{';
			$pool_services_lite_custom_css .='padding-top: '.esc_attr($pool_services_lite_scroll_to_top_padding).';padding-bottom: '.esc_attr($pool_services_lite_scroll_to_top_padding).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_scroll_to_top_width = get_theme_mod('pool_services_lite_scroll_to_top_width');
	if($pool_services_lite_scroll_to_top_width != false){
		$pool_services_lite_custom_css .='.scrollup i{';
			$pool_services_lite_custom_css .='width: '.esc_attr($pool_services_lite_scroll_to_top_width).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_scroll_to_top_height = get_theme_mod('pool_services_lite_scroll_to_top_height');
	if($pool_services_lite_scroll_to_top_height != false){
		$pool_services_lite_custom_css .='.scrollup i{';
			$pool_services_lite_custom_css .='height: '.esc_attr($pool_services_lite_scroll_to_top_height).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_scroll_to_top_border_radius = get_theme_mod('pool_services_lite_scroll_to_top_border_radius');
	if($pool_services_lite_scroll_to_top_border_radius != false){
		$pool_services_lite_custom_css .='.scrollup i{';
			$pool_services_lite_custom_css .='border-radius: '.esc_attr($pool_services_lite_scroll_to_top_border_radius).'px;';
		$pool_services_lite_custom_css .='}';
	}

	/*----------------Social Icons Settings ------------------*/

	$pool_services_lite_social_icon_font_size = get_theme_mod('pool_services_lite_social_icon_font_size');
	if($pool_services_lite_social_icon_font_size != false){
		$pool_services_lite_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$pool_services_lite_custom_css .='font-size: '.esc_attr($pool_services_lite_social_icon_font_size).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_social_icon_padding = get_theme_mod('pool_services_lite_social_icon_padding');
	if($pool_services_lite_social_icon_padding != false){
		$pool_services_lite_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$pool_services_lite_custom_css .='padding: '.esc_attr($pool_services_lite_social_icon_padding).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_social_icon_width = get_theme_mod('pool_services_lite_social_icon_width');
	if($pool_services_lite_social_icon_width != false){
		$pool_services_lite_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$pool_services_lite_custom_css .='width: '.esc_attr($pool_services_lite_social_icon_width).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_social_icon_height = get_theme_mod('pool_services_lite_social_icon_height');
	if($pool_services_lite_social_icon_height != false){
		$pool_services_lite_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$pool_services_lite_custom_css .='height: '.esc_attr($pool_services_lite_social_icon_height).';';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_social_icon_border_radius = get_theme_mod('pool_services_lite_social_icon_border_radius');
	if($pool_services_lite_social_icon_border_radius != false){
		$pool_services_lite_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$pool_services_lite_custom_css .='border-radius: '.esc_attr($pool_services_lite_social_icon_border_radius).'px;';
		$pool_services_lite_custom_css .='}';
	}
	
	/*----------------Woocommerce Products Settings ------------------*/

	$pool_services_lite_products_padding_top_bottom = get_theme_mod('pool_services_lite_products_padding_top_bottom');
	if($pool_services_lite_products_padding_top_bottom != false){
		$pool_services_lite_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$pool_services_lite_custom_css .='padding-top: '.esc_attr($pool_services_lite_products_padding_top_bottom).'!important; padding-bottom: '.esc_attr($pool_services_lite_products_padding_top_bottom).'!important;';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_products_padding_left_right = get_theme_mod('pool_services_lite_products_padding_left_right');
	if($pool_services_lite_products_padding_left_right != false){
		$pool_services_lite_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$pool_services_lite_custom_css .='padding-left: '.esc_attr($pool_services_lite_products_padding_left_right).'!important; padding-right: '.esc_attr($pool_services_lite_products_padding_left_right).'!important;';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_products_box_shadow = get_theme_mod('pool_services_lite_products_box_shadow');
	if($pool_services_lite_products_box_shadow != false){
		$pool_services_lite_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
				$pool_services_lite_custom_css .='box-shadow: '.esc_attr($pool_services_lite_products_box_shadow).'px '.esc_attr($pool_services_lite_products_box_shadow).'px '.esc_attr($pool_services_lite_products_box_shadow).'px #ddd;';
		$pool_services_lite_custom_css .='}';
	}

	$pool_services_lite_products_border_radius = get_theme_mod('pool_services_lite_products_border_radius');
	if($pool_services_lite_products_border_radius != false){
		$pool_services_lite_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$pool_services_lite_custom_css .='border-radius: '.esc_attr($pool_services_lite_products_border_radius).'px;';
		$pool_services_lite_custom_css .='}';
	}