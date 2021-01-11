<?php
/**
 * Lava Fonts
 *
 * @package     classes
 * @category    Core
 * @author      ThemeSpirit
 * @version     1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Lava_Fonts {

	static $google_fonts = array();

	static $preset_fonts = array(
		array(
			'family' => 'Lato',
			'variants' => '300,regular,italic,700,700italic',
			'source' => 'Google',
		),
		array(
			'family' => 'Raleway',
			'variants' => 'regular,500,600,700',
			'source' => 'Google',
		)
	);

	static function add_preset_fonts() {
		if ( get_option( 'lava_fonts' ) == false ) {
			add_option( 'lava_fonts', self::$preset_fonts );
		}
	}

	static function get_fonts() {
		$fonts = get_option( 'lava_fonts' );

		if ( ! empty( $fonts ) ) {
			return $fonts;
		}
		return array();
	}

	static function get_google_fonts() {
		if ( empty( self::$google_fonts ) ) {
			ob_start();
			include( LAVA_EXTENSION_DIR . '/includes/libs/kirki/modules/webfonts/webfonts.json' );
			$fonts_json = ob_get_clean();
			$fonts = json_decode( $fonts_json, true );
			self::$google_fonts = $fonts['items'];
		}
		return self::$google_fonts;
	}

	static function get_family( $index = '' ) {
	    if ( $index === '' ) {
	        return '';
	    }

	    $fonts = self::get_google_fonts();
	    
	    if ( isset( $fonts[$index]['family'] ) ) {
	        return $fonts[$index]['family'];
	    }
	    return '';
	}

	static function get_variants( $family = '' ) {
	    if ( $family === '' ) {
	        return array();
	    }

	    $fonts = self::get_google_fonts();
	    
	    if ( isset( $fonts[$family]['variants'] ) ) {
	        return $fonts[$family]['variants'];
	    }
	    return array();
	}

	static function to_variant( $variant = '' ) {
		if ( empty( $variant ) ) {
			return '';
		}
		$style = preg_replace( '/[0-9\s]/', '', $variant );
		
		if ( $style != 'Italic' ) {
			return preg_replace( '/\D/', '', $variant );
		} else {
			return preg_replace( '/\s/', '', $variant );
		}
	}

	static function get_custom_font_css( $font_family = null ) {
		$custom_fonts = get_option( 'lava_custom_fonts' );
		$output_css = '';

		foreach ( $custom_fonts as $font ) {
			if ( $font_family == $font['family'] ) {
				$output_css .= '@font-face{font-family:"' . $font['family'] . '";';
				if ( !empty( $font['eot'] ) ) {
					$output_css .= 'src:url("' . esc_url( $font['eot'] ) . '");';
					// IE6 - IE8 optional
					// $output_css .= 'src:url("' . esc_url( $font['eot'] ) . '?#iefix") format("embedded-opentype");';
				}
				if ( !empty( $font['woff2'] ) ) {
					$output_css .='src:url("' . esc_url( $font['woff2'] ) . '") format("woff2"),';
				}
				if ( !empty( $font['woff'] ) ) {
					$output_css .='src:url("' . esc_url( $font['woff'] ) . '") format("woff"),';
				}
				if ( !empty( $font['ttf'] ) ) {
					$output_css .='src:url("' . esc_url( $font['ttf'] ) . '") format("truetype"),';
				}
				if ( !empty( $font['svg'] ) ) {
					$output_css .='src:url("' . esc_url( $font['svg'] ) . '#' . $font_family . '") format("svg");';
				}
				$output_css .= '}';
				$output_css = str_replace( ',src:', ',', $output_css );
				$output_css = str_replace( ',}', ';}', $output_css );
				break;
			}
		}
		return $output_css;
	}

	static function get_frontend_style() {
		$theme_fonts = get_option( 'lava_fonts' );
		$output_css = '';

		if ( !empty( $theme_fonts ) ) {
			foreach ( $theme_fonts as $font ) {
				if ( isset( $font['source'] ) && 'Custom' == $font['source'] ) {
					$output_css .= self::get_custom_font_css( $font['family'] );
				}
			}
		}
		return $output_css;
	}
}