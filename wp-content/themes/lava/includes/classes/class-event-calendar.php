<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Lava_Event_Calendar {

	function __construct() {
		add_action( 'wp_footer', array( $this, 'remove_customizer_css' ) );
		add_action( 'customize_register', array( $this, 'remove_customizer_panel'), 99 );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'add_custom_style' ), 99 );
		add_action( 'tribe_events_widget_render', array( $this, 'add_custom_widget_style' ), 200 );
		add_action( 'tribe_events_pro_widget_render', array( $this, 'add_custom_widget_style' ), 200 );
		
		add_filter( 'tribe_events_mobile_breakpoint', array( $this, 'customize_tribe_events_breakpoint' ) );
		add_filter( 'tribe_event_featured_image_size', array( $this, 'add_featured_image_size' ), 10, 2 );
	}

	function add_custom_style() {
		global $post;

		// Checks if we should enqueue frontend assets
		$should_enqueue = (
			tribe_is_event_query()
			|| tribe_is_event_organizer()
			|| tribe_is_event_venue()
			|| ( $post instanceof WP_Post && has_shortcode( $post->post_content, 'tribe_events' ) )
		);

		if ( !apply_filters( 'tribe_events_assets_should_enqueue_frontend', $should_enqueue ) ) {
			return;
		}

		// Remove default styles
		wp_deregister_style( 'tribe-events-calendar-style' );
		wp_dequeue_style( 'tribe-events-calendar-style' );
		wp_deregister_style( 'tribe-events-full-calendar-style' );
		wp_dequeue_style( 'tribe-events-full-calendar-style' );
		wp_deregister_style( 'tribe-events-calendar-pro-style' );
		wp_dequeue_style( 'tribe-events-calendar-pro-style' );
		
		// Enqueue custom event calendar style
		wp_enqueue_style( 'lava-events-calendar-style', LAVA_THEME_URI .'/assets/css/events'. LAVA_MIN_SUFFIX .'.css', array( 'tribe-events-custom-jquery-styles', 'tribe-events-bootstrap-datepicker-css' ) );
		wp_style_add_data( 'lava-events-calendar-style', 'rtl', 'replace' );

		// Enqueue custom event calendar pro style
		if ( defined( 'EVENTS_CALENDAR_PRO_FILE' ) ) {
			// remove default styles
			wp_dequeue_style( 'tribe-events-calendar-pro-style' );
			wp_dequeue_style( 'tribe-events-calendar-pro-mobile-style' );
			wp_dequeue_style( 'tribe-events-calendar-full-pro-mobile-style' );

			// enqueue style
			wp_enqueue_style( 'lava-events-calendar-pro-style', LAVA_THEME_URI .'/assets/css/events-pro'. LAVA_MIN_SUFFIX .'.css' );
			wp_style_add_data( 'lava-events-calendar-pro-style', 'rtl', 'replace' );

			// google map api error.
			if ( tribe_is_event() || is_singular( 'tribe_events' ) || is_singular( 'tribe_venue' ) ) {
				wp_dequeue_script( 'tribe-events-pro-geoloc' );
			}
		}
	}

	function add_custom_widget_style() {
		wp_dequeue_style( 'widget-calendar-style' );
		wp_dequeue_style( 'widget-calendar-pro-style' );
		wp_dequeue_style( 'tribe_events-widget-calendar-pro-style' );
		wp_dequeue_style( 'tribe_events-widget-this-week-pro-style' );
		wp_dequeue_style( 'tribe_events--widget-calendar-pro-override-style' );
		// Enqueue custom event calendar widget style
		wp_enqueue_style( 'lava-widget-calendar-pro-style', LAVA_THEME_URI .'/assets/css/events-pro-widget-calendar'. LAVA_MIN_SUFFIX .'.css' );
	}

	function customize_tribe_events_breakpoint() {
	    return 1020;
	}

	/**
	 * Change thumbnail size for featured events
	 */
	function add_featured_image_size( $size, $post_id = null ) {
		$is_featured = (bool) get_post_meta( $post_id, '_tribe_featured', true );
		if ( $is_featured ) {
			$size = 'full';
		}
		return $size;
	}

	/**
	 * Remove the Tribe Customier CSS <script>
	 */
	function remove_customizer_css() {
		if ( class_exists( 'Tribe__Customizer' ) ) {
			remove_action( 'wp_print_footer_scripts', array( Tribe__Customizer::instance(), 'print_css_template' ), 15 );
		}
	}

	/**
	 * Remove the Tribe Customier panel
	 */
	function remove_customizer_panel( $wp_customize ) {
		$wp_customize->remove_panel( 'tribe_customizer' );
	}
}

if ( defined( 'TRIBE_EVENTS_FILE' ) ) {
	new Lava_Event_Calendar();
}