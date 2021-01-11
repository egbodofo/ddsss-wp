<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Lava_Util {

	public static $http_or_https = 'http';

	public static $date_format = array( 'F j, Y','F jS, Y','M j, Y','m/d/Y','d/m/Y','m.d.y','wps' );

	public static $time_format = array( 'g:i a','g:i A','H:i','none','wps' );

	public static $shortcode_instance = 0;

	public static $post_sidebar_pos = 'sidebar-right';

	public static $post_layout = '1';

	public static $options = '';

	public static $columns = array( "1/1","1/2 ( 2/4 ) ( 3/6 ) ( 4/8 )","1/3 ( 2/6 )","2/3 ( 4/6 )","1/4 ( 2/8 )","3/4 ( 6/8 )","1/5","2/5","3/5","4/5","1/6","5/6","1/7","2/7","3/7","4/7","5/7","6/7","1/8","3/8","5/8","7/8" );

	static function get_column_class( $index = 4 ) {
		$index = $index === '' ? $index = 4 : $index;
	    $columns = array( 'megamenu-column-1-1','megamenu-column-1-2','megamenu-column-1-3','megamenu-column-2-3','megamenu-column-1-4','megamenu-column-3-4','megamenu-column-1-5','megamenu-column-2-5','megamenu-column-3-5','megamenu-column-4-5','megamenu-column-1-6','megamenu-column-5-6','megamenu-column-1-7','megamenu-column-2-7','megamenu-column-3-7','megamenu-column-4-7','megamenu-column-5-7','megamenu-column-6-7','megamenu-column-1-8','megamenu-column-3-8','megamenu-column-5-8','megamenu-column-7-8' );
	    return $columns[$index];
	}

	static function get_option( $name, $default = '' ) {
		if ( is_customize_preview() ) {
			return get_theme_mod( $name, $default );
		}
		if ( empty( self::$options ) ) {
			self::$options = get_theme_mods();
		}
		if ( isset( self::$options[$name] ) ) {
			if ( '' === self::$options[$name] && !empty( $default ) ) {
				return $default;
			}
			return self::$options[$name];
		}
		return $default;
	}

	static function get_page_loader() {
		$loader = self::get_option( 'loader', 'no' );
		$output = '';
		
		switch ( $loader ) {
			case 'line':
				$output .= '<div id="loader" class="line"></div>'; break;
			case 'spinner':
				$output .= '<div id="loader" class="spinner"></div>'; break;
			case 'square-spin':
				$output .= '<div id="loader" class="square-spin"><div></div></div>'; break;
		}
		return $output;
	}

	static function get_preloader( $name = null ) {
		$output = '';
		$name = $name === null ? 'google-circular' : $name;
		switch ( $name ) {
			case 'three-bounce':
				$output .= '<div class="preloader three-bounce"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>'; break;
			case 'circle-rotation':
				$output .= '<div class="preloader circle-rotation"><span class="inner-circle"></span></div>'; break;
			case 'crossing-shapes':
				$output .= '<div class="preloader crossing-shapes"></div>'; break;
			case 'gradient-ring':
				$output .= '<div class="preloader gradient-ring"><div></div></div>'; break;
			case 'google-circular':
				$output .= '<div class="preloader">
								<svg class="google-circular" viewBox="25 25 50 50">
									<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"/>
								</svg>
							</div>';
				break;
		}
		return $output;
	}
}

if ( is_ssl() ) {
    Lava_Util::$http_or_https = 'https';
}