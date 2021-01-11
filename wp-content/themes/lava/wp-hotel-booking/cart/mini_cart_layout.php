<?php
/**
 * The template for displaying mini cart js template.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/cart/mini_cart_layout.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit; ?>

<script type="text/html" id="tmpl-hb-minicart-item">
    <div class="hb_mini_cart_item active" data-cart-id="{{ data.cart_id }}">

        <div class="hb_mini_cart_top">
            <h4 class="hb_title"><a href="{{{ data.permalink }}}">{{ data.name }}</a></h4>
            <span class="hb_mini_cart_remove"><i class="material-icons">close</i></span>
        </div>

        <div class="hb_mini_cart_number">
            <label><?php esc_html_e( 'Quantity: ', 'lava' ); ?></label>
            <span>{{ data.quantity }}</span>
        </div>

        <div class="hb_mini_cart_price">
            <label><?php esc_html_e( 'Price: ', 'lava' ); ?></label>
            <span>{{{ data.total }}}</span>
        </div>
    </div>
</script>
<script type="text/html" id="tmpl-hb-minicart-footer">
    <div class="hb_mini_cart_footer">
        <a href="<?php echo hb_get_checkout_url() ?>" class="hb_button hb_checkout btn-primary btn-small"><?php esc_html_e( 'Check Out', 'lava' ); ?></a>
        <a href="<?php echo hb_get_cart_url(); ?>" class="hb_button hb_view_cart btn-primary btn-small"><?php esc_html_e( 'View Cart', 'lava' ); ?></a>
    </div>
</script>
<script type="text/html" id="tmpl-hb-minicart-empty">
    <p class="hb_mini_cart_empty"><?php esc_html_e( 'Your cart is empty!', 'lava' ); ?></p>
</script>