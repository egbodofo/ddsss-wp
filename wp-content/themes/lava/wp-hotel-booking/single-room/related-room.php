<?php
/**
 * The template for displaying related room in single room page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/single-room/related-room.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$room    = WPHB_Room::instance( get_the_ID() );
$related = $room->get_related_rooms();
$slidesToShow = Lava()->get_layout() == 'full-width' ? 4 : 3;

if ( $related->posts ): ?>
    <div class="hb_related_rooms tp-hotel-booking">
        <h3 class="section-heading"><?php esc_html_e( 'Other Rooms', 'lava' ); ?></h3>
		<div class="hb_room_carousel">
			<div class="slick-slider" data-slick='{"slidesToShow":<?php echo esc_attr( $slidesToShow ); ?>}'>
			<?php while ( $related->have_posts() ) : $related->the_post(); ?>
				<div id="room-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="hb_room_inner">
						<?php do_action( 'hotel_booking_loop_room_thumbnail' ); ?>
						<div class="info">
						<?php lava_hb_room_title() ?>
						<?php do_action( 'hotel_booking_loop_room_price' ); ?>
						<?php do_action( 'hotel_booking_loop_room_rating' ); ?>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
			</div>
		</div>
    </div>
<?php endif; ?>
