<?php
/**
 * The template for displaying room gallery lightbox.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/loop/gallery-lightbox.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$gallery = $room->gallery; ?>

<?php if ( $gallery ): ?>
    <div class="hb-room-type-gallery">
	<?php foreach ( $gallery as $image ) : ?>
		<?php if ( $image != $gallery[0] ) : ?>
            <a class="hb-room-gallery swipebox" rel="hb-room-gallery-<?php echo esc_attr( $room->post->ID ); ?>" href="<?php echo esc_url( $image['src'] ); ?>">
                <img src="<?php echo esc_url( $image['thumb'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" data-id="<?php echo esc_attr( $image['id'] ); ?>" />
            </a>
    	<?php endif; ?>
	<?php endforeach; ?>
    </div>
<?php endif; ?>