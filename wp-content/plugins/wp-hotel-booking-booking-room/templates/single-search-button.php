<?php
/**
 * Template for displaying single search button.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking-room/single-search-button.php.
 *
 * @author  ThimPress
 * @package  WP-Hotel-Booking/Booking-Room/Templates
 * @version  1.7.2
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $hb_room;
?>

<a href="#" data-id="<?php echo esc_attr( $hb_room->ID ) ?>" data-name="<?php echo esc_attr( $hb_room->name ) ?>"
   class="hb_button hb_primary" id="hb_room_load_booking_form">
	<?php _e( 'Check Availability This Room', 'wp-hotel-booking-room' ); ?>
</a>