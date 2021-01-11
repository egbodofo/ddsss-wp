<?php
/**
 * The template for displaying select room extra after select room.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/search/select-extra.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.9.5
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

$cart_id = hb_get_request( 'cart_id' );
$room_id = hb_get_request( 'room_id' );

$extra_product = HB_Room_Extra::instance( $room_id );
$room_extra    = $extra_product->get_extra();

$cart      = WPHB_Cart::instance();
$cart_item = $cart->get_cart_item( $cart_id ); ?>

<form class="hb-select-extra-results hb_addition_packages" name="hb-select-extra-results">
	<?php if ( $room_extra ) { ?>
        <?php do_action( 'hotel_booking_before_select_extra', $room_id ); ?>
        <ul class="list-room-extra hb_addition_packages_ul">
			<?php foreach ( $room_extra as $key => $extra ) { ?>
                <li data-price="<?php echo esc_attr( $extra->amount_singular ); ?>">
                    <div class="hb_extra_optional_right">
                        <input type="<?php if ( $extra->required ) { echo 'hidden'; } else { echo 'checkbox'; } ?>"
                               name="hb_optional_quantity_selected[<?php echo esc_attr( $extra->ID ); ?>]"
                               class="hb_optional_quantity_selected lava-checkbox"
                               id="<?php echo esc_attr( 'hb-ex-room-' . $extra->ID . '-' . $key ) ?>"<?php if ( $extra->required ) { echo ' checked="checked" value="on"'; } ?>
                        />
                    </div>
                    <div class="hb_extra_optional_left">
                        <div class="hb_extra_title">
                            <div class="hb_package_title">
                                <label for="<?php echo esc_attr( 'hb-ex-room-' . $extra->ID . '-' . $key ) ?>"><?php printf( '%s', $extra->title ) ?></label>
                                <p><?php printf( '%s', $extra->description ) ?></p>
                            </div>
                        <div class="hb_extra_detail_price">
							<?php if ( $extra->respondent === 'number' ) { ?>
                            	<input type="number" step="1" min="1" name="hb_optional_quantity[<?php echo esc_attr( $extra->ID ); ?>]" value="1" class="hb_optional_quantity"/>
							<?php } else { ?>
                                <input type="hidden" step="1" min="1" name="hb_optional_quantity[<?php echo esc_attr( $extra->ID ); ?>]" value="1"/>
							<?php } ?>
                            <label>
                                <strong><?php echo esc_html( $extra->price ); ?></strong>
                                <small><?php printf( '/ %s', $extra->respondent_name ? $extra->respondent_name : esc_html__( 'Package', 'lava' ) ) ?></small>
                            </label>
                        </div>
                    </div>
                </li>
			<?php } ?>
        </ul>
        <input type="hidden" name="action" value="hotel_booking_add_extra_to_cart"/>
        <input type="hidden" name="cart_id" value="<?php echo esc_attr( $cart_id ); ?>"/>
		<?php wp_nonce_field( 'hb_select_extra_nonce_action', 'nonce' ); ?>
        <?php do_action( 'hotel_booking_before_select_extra', $room_id ); ?>
        <a href="javascript:history.go(-1)"
           class="hb_button btn-primary btn-small"><?php esc_html_e( 'Back to search', 'lava' ); ?></a>
        <button type="submit" class="hb_button btn-primary btn-small"><?php esc_html_e( 'Next step', 'lava' ); ?></button>
	<?php } else {
		esc_html_e( 'There is no extra option of this room', 'lava' );
	} ?>
</form>