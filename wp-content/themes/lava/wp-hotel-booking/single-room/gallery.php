<?php
/**
 * The template for displaying single room gallery.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/single-room/gallery.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $hb_room;
/**
 * @var $hb_room WPHB_Room
 */
$galleries = $hb_room->get_galleries( false );

if ( $galleries ): ?>

	<div class="hb_room_gallery lava-gallery style-thumbnail">
		<div class="main-slider slick-slider">
			<?php foreach ( $galleries as $key => $gallery ): ?>
				<div><img src="<?php echo esc_url( $gallery['src'] ); ?>" alt="<?php echo esc_attr( $gallery['alt'] ); ?>"></div>
			<?php endforeach; ?>
		</div>
		<div class="thumb-slider slick-slider">
			<?php foreach ( $galleries as $key => $gallery ): ?>
				<div><img src="<?php echo esc_url( $gallery['thumb'] ); ?>" alt="<?php echo esc_attr( $gallery['alt'] ); ?>"></div>
			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>