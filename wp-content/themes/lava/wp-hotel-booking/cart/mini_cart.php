<?php
/**
 * The template for displaying mini cart.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/cart/mini_cart.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

/**
 * @var $cart WPHB_Cart
 */
$cart  = WP_Hotel_Booking::instance()->cart;
$rooms = $cart->get_rooms();
?>

<?php if ( $rooms ) {
	foreach ( $rooms as $key => $room ) {
		if ( $cart_item = $cart->get_cart_item( $key ) ) {
			hb_get_template( 'loop/mini-cart-loop.php', array( 'cart_id' => $key, 'room' => $room ) );
		}
	} ?>

    <div class="hb_mini_cart_footer">

        <a href="<?php echo esc_url( hb_get_checkout_url() ); ?>" class="hb_button hb_checkout btn-primary btn-small"><?php esc_html_e( 'Check Out', 'lava' ); ?></a>
        <a href="<?php echo esc_url( hb_get_cart_url() ); ?>" class="hb_button hb_view_cart btn-primary btn-small"><?php esc_html_e( 'View Cart', 'lava' ); ?></a>

    </div>

<?php } else {  ?>

    <p class="hb_mini_cart_empty"><?php esc_html_e( 'Your cart is empty!', 'lava' ); ?></p>

<?php } ?>
