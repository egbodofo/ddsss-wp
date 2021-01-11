<?php
/**
 * The template for displaying search room booking room details.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/search/booking-room-details.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<div class="hb-booking-room-details">
    <span class="hb_search_room_item_detail_price_close"><i class="material-icons">close</i></span>
	<?php $details = $room->get_booking_room_details(); ?>
    <table class="hb_search_room_pricing_price">
        <tbody>
		<?php foreach ( $details as $day => $info ): ?>
            <tr>
                <td class="hb_search_item_day"><?php printf( '%s', hb_date_to_name( $day ) ) ?></td>
                <td class="hb_search_item_total_description">
					<?php printf( 'x%d %s', $info['count'], esc_html__( 'Night', 'lava' ) ) ?>
                </td>
                <td class="hb_search_item_price">
					<?php echo hb_format_price( round( $info['price'], 2 ) ); ?>
                </td>
            </tr>
		<?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td class="hb_search_item_total_bold">
				<?php esc_html_e( 'Total', 'lava' ) ?>
            </td>
            <td class="hb_search_item_total_description">
				<?php
				if ( hb_price_including_tax() ) {
					esc_html_e( '* vat is included', 'lava' );
				} else {
					esc_html_e( '* vat is not included yet', 'lava' );
				}
				?>
            </td>
            <td class="hb_search_item_price">
				<?php echo hb_format_price( $room->amount_singular ); ?>
            </td>
        </tr>
        </tfoot>
    </table>
</div>
