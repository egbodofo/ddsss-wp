<?php
/**
 * The template for displaying loop room price in archive room page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/loop/price.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $hb_settings;
/**
 * @var $hb_settings WPHB_Settings
 */
$price_display = apply_filters( 'hotel_booking_loop_room_price_display_style', $hb_settings->get( 'price_display' ) );
$prices        = hb_room_get_selected_plan( get_the_ID() );
$prices        = isset( $prices->prices ) ? $prices->prices : array();
?>

<?php if ( $prices ): ?>
	<?php
	$min = min( $prices ) + ( hb_price_including_tax() ? ( min( $prices ) * hb_get_tax_settings() ) : 0 );
	$max = max( $prices ) + ( hb_price_including_tax() ? ( max( $prices ) * hb_get_tax_settings() ) : 0 );
	?>
    <div class="price">
		<?php if ( $price_prefix = Lava_Util::get_option( 'hb_price_prefix', '' ) ) : ?>
        	
        	<span class="title-price"><?php echo esc_html( $price_prefix ); ?></span>
    	
    	<?php endif; ?>

		<?php if ( $price_display === 'max' ) : ?>

            <span class="price_value price_max"><?php echo hb_format_price( $max ) ?> </span>

		<?php elseif ( $price_display === 'min_to_max' && $min !== $max ) : ?>

            <span class="price_value price_min_to_max"><?php echo hb_format_price( $min ) ?> - <?php echo hb_format_price( $max ) ?> </span>

		<?php else : ?>

            <span class="price_value price_min"><?php echo hb_format_price( $min ) ?> </span>

		<?php endif; ?>
        <span class="unit">/ <?php esc_html_e( 'Night', 'lava' ); ?></span>
    </div>
<?php endif; ?>