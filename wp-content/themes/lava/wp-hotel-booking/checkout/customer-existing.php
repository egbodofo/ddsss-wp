<?php
/**
 * The template for displaying existing customer form in checkout page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/checkout/customer-existing.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

?>

<?php if ( !is_user_logged_in() ) : ?>

<div class="hb-order-existing-customer" data-label="<?php esc_attr_e( '-Or-', 'lava' ); ?>">
    <h4><?php esc_html_e( 'Existing customer?', 'lava' ); ?></h4>
    <div class="hb-form-table">
        <div class="hb-form-field">
            <div class="hb-form-field-input">
                <input type="email" name="existing-customer-email" value="<?php echo esc_attr( WP_Hotel_Booking::instance()->cart->customer_email ); ?>" placeholder="<?php esc_attr_e( 'Your email here', 'lava' ); ?>" />

                <button class="btn-primary" type="button" id="fetch-customer-info"><?php esc_html_e( 'Apply', 'lava' ); ?></button>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>