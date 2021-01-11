<?php
/**
 * The template for displaying shortcode rooms carousel.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/shortcodes/carousel.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

$show_nav = $show_pagination = $show_excerpt = 'false';
$room_class = '';

if ( isset( $atts['nav'] ) && ( $atts['nav'] || $atts['nav'] == 'true' ) ) {
	$show_nav = 'true';
}

if ( isset( $atts['pagination'] ) && ( $atts['pagination'] || $atts['pagination'] == 'true' ) ) {
	$show_pagination = 'true';
}

if ( isset( $atts['excerpt'] ) && ( $atts['excerpt'] || $atts['excerpt'] == 'true' ) ) {
	$show_excerpt = 'true';
}

if ( isset( $atts['card_style'] ) && $atts['card_style'] == 'true' ) {
	$room_class = ' card';
}

$items    = isset( $atts['number'] ) ? (int) $atts['number'] : 4;
$data_slick = ' data-slick=\'{"slidesToShow":'. $items .',"arrows":'. $show_nav .',"dots":'. $show_pagination .'}\'';

?>
<div class="hb_room_carousel_container tp-hotel-booking">
	<?php if ( !empty( $atts['title'] ) ): ?>
        <h3 class="section-heading"><?php echo esc_html( $atts['title'] ); ?></h3>
	<?php endif; ?>
	<?php if ( !empty( $atts['text_link'] ) ): ?>
        <div class="text_link">
            <a href="<?php echo get_post_type_archive_link( 'hb_room' ); ?>"><?php echo esc_html( $atts['text_link'] ); ?></a>
        </div>
	<?php endif; ?>
    <div class="hb_room_carousel">
		<div class="slick-slider"<?php echo htmlspecialchars( $data_slick ); ?>>
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<div id="room-<?php the_ID(); ?>" <?php post_class( 'equal-height' ); ?>>
				<div class="hb_room_inner<?php echo esc_attr( $room_class ); ?>">
					<?php do_action( 'hotel_booking_loop_room_thumbnail' ); ?>
					<div class="info">
					<?php lava_hb_room_title(); ?>
					<?php if ( $show_excerpt ): lava_hb_room_excerpt(); endif; ?>
					<?php do_action( 'hotel_booking_loop_room_price' ); ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		</div>
    </div>
</div>