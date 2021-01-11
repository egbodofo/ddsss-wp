<?php

defined( 'ABSPATH' ) || exit;

/**
 * Get template part (for templates like the content-loop).
 *
 * @access public
 * @param mixed  $slug Template slug.
 * @param string $name Template name (default: '').
 */
function lava_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/lava/slug-name.php.
	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", 'lava/' . "{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php.
	if ( !$template && $name && file_exists( LAVA_EXTENSION_DIR . "templates/{$slug}-{$name}.php" ) ) {
		$template = LAVA_EXTENSION_DIR . "templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/lava/slug.php.
	if ( !$template ) {
		$template = locate_template( array( "{$slug}.php", 'lava/' . "{$slug}.php" ) );
	}

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 * Get other templates passing attributes and including the file.
 *
 * @access public
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 */
function lava_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( !empty( $args ) && is_array( $args ) ) {
		extract( $args ); // @codingStandardsIgnoreLine
	}

	$located = lava_locate_template( $template_name, $template_path, $default_path );

	if ( !file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'lava_extension' ), '<code>' . $located . '</code>' ), '1.0' );
		return;
	}

	include $located;
}

/**
 * Like lava_get_template, but returns the HTML instead of outputting.
 *
 * @see lava_get_template
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 *
 * @return string
 */
function lava_get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	ob_start();
	lava_get_template( $template_name, $args, $template_path, $default_path );
	return ob_get_clean();
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @access public
 * @param string $template_name Template name.
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 * @return string
 */
function lava_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( !$template_path ) {
		$template_path = 'lava/';
	}

	if ( !$default_path ) {
		$default_path = LAVA_EXTENSION_DIR . 'templates/';
	}

	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name,
		)
	);

	// Get default template/.
	if ( !$template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found.
	return $template;
}

if ( ! function_exists( 'lava_date_time_format_js' ) ) {
	/**
	 * Get date time format for datepicker
	 * @return string date time format
	 */
	function lava_date_time_format_js() {
		$date_format = get_option( 'date_format' );
		$custom_date_format = get_option( 'date_format_custom' );
		
		if ( !$date_format && $custom_date_format ) {
			$date_format = $custom_date_format;
		}

		switch ( $date_format ) {
			case 'Y-m-d': $format = 'yy-mm-dd'; break;
			case 'Y/m/d': $format = 'yy/mm/dd'; break;
			case 'd/m/Y': $format = 'dd/mm/yy'; break;
			case 'd-m-Y': $format = 'dd-mm-yy'; break;
			case 'm/d/Y': $format = 'mm/dd/yy'; break;
			case 'm-d-Y': $format = 'mm-dd-yy'; break;
			case 'F j, Y': $format = 'MM dd, yy'; break;
			case 'd.m.Y': $format = 'dd.mm.yy'; break;
			default: $format = 'mm/dd/yy'; break;
		}
		return $format;
	}
}