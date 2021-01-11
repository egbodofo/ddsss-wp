<?php
/**
 * ThemeSpirit Template Hooks
 *
 * Action/filter hooks used for ThemeSpirit functions/templates.
 *
 * @author 		ThemeSpirit
 * @category 	Core
 * @package 	templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'body_class', 'lava_body_class' );

/**
 * Content wrapper.
 *
 * @see lava_output_content_wrapper_start()
 * @see lava_output_content_wrapper_end()
 */
add_action( 'lava_content_start', 'lava_output_content_wrapper_start' );
add_action( 'lava_content_end', 'lava_output_content_wrapper_end' );

/**
 * Container.
 *
 * @see lava_output_container_start()
 * @see lava_output_container_end()
 */
add_action( 'lava_container_start', 'lava_output_container_start' );
add_action( 'lava_container_end', 'lava_output_container_end' );

/**
 * Main content.
 *
 * @see lava_output_before_main_content()
 * @see lava_output_after_main_content()
 * @see lava_output_sidebar_content()
 * @see lava_output_hb_sidebar_content()
 * @see lava_output_ec_sidebar_content()
 * @see lava_output_after_main_content()
 * @see lava_output_single_room_details()
 */
add_action( 'lava_before_main_content', 'lava_output_before_main_content' );
add_action( 'lava_after_main_content', 'lava_output_after_main_content' );
add_action( 'lava_sidebar_content', 'lava_output_sidebar_content' );
add_action( 'lava_hb_sidebar_content', 'lava_output_hb_sidebar_content' );
add_action( 'lava_ec_sidebar_content', 'lava_output_ec_sidebar_content' );
add_action( 'lava_after_sidebar_content', 'lava_output_after_main_content' );
add_action( 'lava_hb_single_room_details', 'lava_output_single_room_details' );

/**
 * Page header.
 *
 * @see lava_output_page_header()
 */
add_action( 'lava_page_header', 'lava_output_page_header', 10, 1 );
add_action( 'lava_hb_page_header', 'lava_output_hb_page_header', 10, 1 );

/**
 * Before & after loop.
 *
 * @see lava_output_before_content_loop()
 * @see lava_output_after_content_loop()
 */
add_action( 'lava_before_content_loop', 'lava_output_before_content_loop', 10 );
add_action( 'lava_after_content_loop', 'lava_output_after_content_loop', 10 );



/**
 * Content loop.
 *
 * @see lava_output_content_loop_start()
 * @see lava_output_content_loop_end()
 * @see lava_output_content_loop_thumb()
 * @see lava_output_content_loop_media()
 */

add_action( 'lava_content_loop_start', 'lava_output_content_loop_start', 10 );
add_action( 'lava_content_loop_end', 'lava_output_content_loop_end', 10 );
add_action( 'lava_content_loop_thumb', 'lava_output_content_loop_thumb', 10 );
add_action( 'lava_content_loop_media', 'lava_output_content_loop_media', 10 );
