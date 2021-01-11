<?php
/**
 * WP Hotel Booking Report Functions
 *
 * Define common functions for both front-end and back-end
 *
 * @author   ThimPress
 * @package  WP-Hotel-Booking/Report/Functions
 * @version  1.7.2
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

add_filter( 'hotel_booking_menu_items', 'hotel_report_menu' );
if ( ! function_exists( 'hotel_report_menu' ) ) {
	/**
	 * Report menu
	 *
	 * @param $menus
	 *
	 * @return mixed
	 */
	function hotel_report_menu( $menus ) {
		$menus['reports'] = array(
			'tp_hotel_booking',
			__( 'Reports', 'wp-hotel-booking-report' ),
			__( 'Reports', 'wp-hotel-booking-report' ),
			'manage_hb_booking',
			'tp_hotel_booking_report',
			'hotel_create_report_page'
		);

		return $menus;
	}
}

if ( ! function_exists( 'hotel_create_report_page' ) ) {
	/**
	 * Create report page.
	 */
	function hotel_create_report_page() {
		require_once TP_HB_REPORT_DIR . 'inc/views/report.php';
	}
}


add_action( 'hotel_booking_chart_sidebar', 'tp_hotel_core_report_sidebar', 10, 2 );

if ( ! function_exists( 'tp_hotel_core_report_sidebar' ) ) {
	/**
	 * @param string $tab
	 * @param string $range
	 */
	function tp_hotel_core_report_sidebar( $tab = '', $range = '' ) {
		if ( ! $tab || ! $range ) {
			return;
		}

		$file = apply_filters( "tp_hotel_booking_chart_sidebar_{$tab}_{$range}", '', $tab, $range );

		if ( ! $file || ! file_exists( $file ) ) {
			$file = apply_filters( "hotel_booking_chart_sidebar_layout", '', $tab, $range );
		}

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
}

add_action( 'hotel_booking_chart_canvas', 'hotel_report_canvas', 10, 2 );

if ( ! function_exists( 'hotel_report_canvas' ) ) {
	/**
	 * @param string $tab
	 * @param string $range
	 */
	function hotel_report_canvas( $tab = '', $range = '' ) {
		if ( ! $tab || ! $range ) {
			return;
		}

		$file = apply_filters( "tp_hotel_booking_chart_{$tab}_{$range}_canvas", '', $tab, $range );

		if ( ! $file || ! file_exists( $file ) ) {
			$file = apply_filters( "hotel_booking_chart_layout_canvas", '', $tab, $range );
		}

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
}

add_filter( 'hotel_booking_chart_sidebar_layout', 'hb_report_sidebar_layout', 10, 3 );

if ( ! function_exists( 'hb_report_sidebar_layout' ) ) {
	/**
	 * @param $file
	 * @param $tab
	 * @param $range
	 *
	 * @return string
	 */
	function hb_report_sidebar_layout( $file, $tab, $range ) {
		$tab_range = TP_HB_REPORT_DIR . 'inc/views/sidebar-' . $tab . '-' . $range . '.php';
		$tab       = TP_HB_REPORT_DIR . 'inc/views/sidebar-' . $tab . '.php';
		if ( file_exists( $tab_range ) ) {
			return $tab_range;
		} else if ( file_exists( $tab ) ) {
			return $tab;
		}

		return TP_HB_REPORT_DIR . 'inc/views/sidebar.php';
	}
}

add_filter( 'hotel_booking_chart_layout_canvas', 'hb_report_layout_canvas', 10, 3 );

if ( ! function_exists( 'hb_report_layout_canvas' ) ) {
	/**
	 * @param $file
	 * @param $tab
	 * @param $range
	 *
	 * @return string
	 */
	function hb_report_layout_canvas( $file, $tab, $range ) {
		if ( file_exists( TP_HB_REPORT_DIR . 'inc/views/canvas-' . strtolower( $tab ) . '.php' ) ) {
			return TP_HB_REPORT_DIR . 'inc/views/canvas-' . strtolower( $tab ) . '.php';
		}

		return $file;
	}

}