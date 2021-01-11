<?php
/**
 * @package Pool Services Lite
 * Setup the WordPress core custom header feature.
 *
 * @uses pool_services_lite_header_style()
*/
function pool_services_lite_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'pool_services_lite_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 185,
		'flex-width'             => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'pool_services_lite_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'pool_services_lite_custom_header_setup' );

if ( ! function_exists( 'pool_services_lite_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see pool_services_lite_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'pool_services_lite_header_style' );

function pool_services_lite_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        .home-page-header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
			background-size: 100% 100%;
		}";
	   	wp_add_inline_style( 'pool-services-lite-basic-style', $custom_css );
	endif;
}
endif;