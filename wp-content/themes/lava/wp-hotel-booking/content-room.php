<?php
/**
 * The template for displaying content archive room.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/content-room.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

?>
<div id="room-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'hotel_booking_before_loop_room_item' ); ?>
    <div class="card equal-height">
		<?php do_action( 'hotel_booking_loop_room_thumbnail' ); ?>
		<div class="info">
			<?php lava_hb_room_title(); ?>
			<?php lava_hb_room_excerpt( get_the_ID(), Lava_Util::get_option( 'hb_archive_excerpt_length', 150 ) ); ?>
			<?php do_action( 'hotel_booking_loop_room_price' ); ?>
			<?php do_action( 'hotel_booking_loop_room_rating' ); ?>
			<div class="left-align">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="btn-secondary"><?php esc_html_e( 'Details', 'lava' ); ?></a>
			</div>
		</div>
    </div>
	<?php do_action( 'hotel_booking_after_loop_room_item' ); ?>
</div>
<?php do_action( 'hotel_booking_after_loop_room' ); ?>
