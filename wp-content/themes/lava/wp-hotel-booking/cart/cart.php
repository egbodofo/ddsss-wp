<?php
/**
 * The template for displaying cart page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/cart/cart.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.9.7.5
 */

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

$cart = WP_Hotel_Booking::instance()->cart;
global $hb_settings;

?>
<?php if ( WP_Hotel_Booking::instance()->cart->cart_items_count != 0 ) : ?>
    <div id="hotel-booking-cart">
        <form id="hb-cart-form" method="post">
            <h3><?php esc_html_e( 'Your Cart', 'lava' ); ?></h3>
            <div class="hb-booking-details">
                <table class="hb_table">
                    <thead>
                    <th>&nbsp;</th>
                    <th class="hb_room_type"><?php esc_html_e( 'Room type', 'lava' ); ?></th>
                    <th class="hb_capacity"><?php esc_html_e( 'Capacity', 'lava' ); ?></th>
                    <th class="hb_quantity"><?php esc_html_e( 'Quantity', 'lava' ); ?></th>
                    <th class="hb_check_in"><?php esc_html_e( 'Check-in', 'lava' ); ?></th>
                    <th class="hb_check_out"><?php esc_html_e( 'Check-out', 'lava' ); ?></th>
                    <th class="hb_night"><?php esc_html_e( 'Night', 'lava' ); ?></th>
                    <th class="hb_gross_total"><?php esc_html_e( 'Gross Total', 'lava' ); ?></th>
                    </thead>
    				<?php if ( $rooms = $cart->get_rooms() ): ?>
    					<?php foreach ( $rooms as $cart_id => $room ) : ?>
    						<?php
    						if ( ( $num_of_rooms = (int) $room->get_data( 'quantity' ) ) == 0 ) {
                                continue;
                            }
    						$cart_extra = WP_Hotel_Booking::instance()->cart->get_extra_packages( $cart_id );
    						?>
                            <tr class="hb_checkout_item" data-cart-id="<?php echo esc_attr( $cart_id ); ?>">
                                <td<?php echo defined( 'WPHB_EXTRA_FILE' ) && $cart_extra ? ' rowspan="' . ( count( $cart_extra ) + 2 ) . '"' : '' ?>>
                                    <a href="javascript:void(0)" class="hb_remove_cart_item" data-cart-id="<?php echo esc_attr( $cart_id ); ?>">
                                        <i class="material-icons">close</i>
                                    </a>
                                </td>
                                <td class="hb_room_type">
                                    <a href="<?php echo get_permalink( $room->ID ); ?>"><?php echo esc_html( $room->name ); ?><?php printf( '%s', $room->capacity_title ? ' (' . $room->capacity_title . ')' : '' ); ?></a>
                                </td>
                                <td class="hb_capacity"><?php echo sprintf( _n( '%d guest', '%d guests', $room->capacity, 'lava' ), $room->capacity ); ?> </td>
                                <td class="hb_quantity">
                                    <input type="number" min="0" class="hb_room_number_edit input-field-small" name="hotel_booking_cart[<?php echo esc_attr( $cart_id ) ?>]" value="<?php echo esc_attr( $num_of_rooms ); ?>" />
                                </td>
                                <td class="hb_check_in"><?php echo date_i18n( hb_get_date_format(), strtotime( $room->get_data( 'check_in_date' ) ) ) ?></td>
                                <td class="hb_check_out"><?php echo date_i18n( hb_get_date_format(), strtotime( $room->get_data( 'check_out_date' ) ) ) ?></td>
                                <td class="hb_night"><?php echo hb_count_nights_two_dates( $room->get_data( 'check_out_date' ), $room->get_data( 'check_in_date' ) ) ?></td>
                                <td class="hb_gross_total">
    								<?php echo hb_format_price( $room->total ); ?>
                                </td>
                            </tr>
    						<?php do_action( 'hotel_booking_cart_after_item', $room, $cart_id ); ?>
    					<?php endforeach; ?>

    				<?php endif; ?>

    				<?php do_action( 'hotel_booking_before_cart_total' ); ?>

                    <tr class="hb_sub_total">
                        <td colspan="8"><?php esc_html_e( 'Sub Total', 'lava' ); ?>
                            <span class="hb-align-right hb_sub_total_value">
                                    <?php echo hb_format_price( $cart->sub_total ); ?>
                                </span>
                        </td>
                    </tr>
    				<?php if ( $tax = hb_get_tax_settings() ) : ?>
                        <tr class="hb_advance_tax">
                            <td colspan="8">
    							<?php esc_html_e( 'Tax', 'lava' ); ?>
    							<?php if ( $tax < 0 ) { ?>
                                    <span><?php esc_html_e( '(price including tax)', 'lava' ); ?></span>
    							<?php } ?>
                                <span class="hb-align-right"><?php echo apply_filters( 'hotel_booking_cart_tax_display', abs( $tax * 100 ) . '%' ); ?></span>
                            </td>
                        </tr>
    				<?php endif; ?>
                    <tr class="hb_advance_grand_total">
                        <td colspan="8">
    						<?php esc_html_e( 'Grand Total', 'lava' ); ?>
                            <span class="hb-align-right hb_grand_total_value"><?php echo hb_format_price( $cart->total ) ?></span>
                        </td>
                    </tr>
                    <?php $advance_payment = ''; ?>
    				<?php if ( $advance_payment = $cart->advance_payment ) : ?>
                        <tr class="hb_advance_payment">
                            <td colspan="8">
    							<?php printf( esc_html__( 'Advance Payment (%s%% of Grand Total)', 'lava' ), hb_get_advance_payment() ); ?>
                                <span class="hb-align-right hb_advance_payment_value"><?php echo hb_format_price( $advance_payment ); ?></span>
                            </td>
                        </tr>
    				<?php endif; ?>

                    <tr>
    					<?php wp_nonce_field( 'hb_cart_field', 'hb_cart_field' ); ?>
                    </tr>
                </table>
            </div>
            <p>
                <a href="<?php echo hb_get_checkout_url() ?>" class="hb_button hb_checkout btn-primary"><?php esc_html_e( 'Check Out', 'lava' ); ?></a>
                <button type="submit" class="hb_button update btn-primary"><?php esc_html_e( 'Update', 'lava' ); ?></button>
            </p>
        </form>
    </div>

<?php else: ?>
    <!--Empty cart-->
    <div class="hb-message message">
        <div class="hb-message-content">
			<?php esc_html_e( 'Your cart is empty!', 'lava' ) ?>
        </div>
    </div>
<?php endif; ?>
