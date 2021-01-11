<?php
/**
 * The template for displaying shortcode lastest reviews.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/shortcodes/lastest-reviews.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

?>
<div id="hotel_booking_lastest_reviews-<?php echo uniqid(); ?>" class="hotel_booking_lastest_reviews tp-hotel-booking">
	<?php if ( isset( $atts['title'] ) && $atts['title'] ): ?>
        <h3 class="section-heading"><?php echo esc_html( $atts['title'] ); ?></h3>
	<?php endif; ?>
	<?php hotel_booking_room_loop_start(); ?>

	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		
		<div id="room-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="hb_room_inner">
				<?php do_action( 'hotel_booking_loop_room_thumbnail' ); ?>
				<div class="info">
					<?php lava_hb_room_title(); ?>
					<?php do_action( 'hotel_booking_loop_room_price' ); ?>
					<?php do_action( 'hotel_booking_loop_room_rating' ); ?>
				</div>
			</div>
		</div>

	<?php endwhile; // end of the loop. ?>

	<?php hotel_booking_room_loop_end(); ?>
</div>