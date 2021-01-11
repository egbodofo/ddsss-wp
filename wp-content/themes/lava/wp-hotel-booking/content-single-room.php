<?php
/**
 * The template for displaying content single room.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/content-single-room.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

/**
 * hotel_booking_before_single_product hook
 *
 */
do_action( 'hotel_booking_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
?>

<div id="room-<?php the_ID(); ?>" <?php post_class( 'hb_single_room tp-hotel-booking' ); ?>>
	<?php
	/**
	 * hotel_booking_before_loop_room_summary hook
	 *
	 * @hooked hotel_booking_show_room_sale_flash - 10
	 * @hooked hotel_booking_show_room_images - 20
	 */
	do_action( 'hotel_booking_before_single_room' );
	?>
    <div class="summary entry-summary">
		<?php
		/**
		 * hotel_booking_single_room_gallery hook
		 */
		do_action( 'hotel_booking_single_room_gallery' );

		echo '<div class="hb_room_title cf">';
		
		/**
		 * hotel_booking_single_room_title
		 */
		lava_hb_room_title( get_the_ID(), true );
		
		/**
		 * hotel_booking_loop_room_single_price
		 */
		do_action( 'hotel_booking_loop_room_price' );

		echo '</div>';
		
		/**
		 * hotel_booking_single_room_details hook
		 */
		do_action( 'lava_hb_single_room_details' );
		?>
    </div><!-- .summary -->
	<?php
	/**
	 * hotel_booking_after_loop_room hook
	 *
	 * @hooked hotel_booking_output_room_data_tabs - 10
	 * @hooked hotel_booking_upsell_display - 15
	 * @hooked hotel_booking_output_related_products - 20
	 */
	do_action( 'hotel_booking_after_single_room' );
	?>
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'hotel_booking_after_single_product' ); ?>
