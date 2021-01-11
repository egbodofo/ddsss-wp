<?php
/**
 * The template for displaying payment methods in checkout page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/checkout/payment-method.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

$payment_gateways = hb_get_payment_gateways( array( 'enable' => true ) );
?>
<div class="hb-payment-form">
    <h4><?php esc_html_e( 'Payment Method', 'lava' ); ?></h4>
    <ul class="hb-payment-methods">
        <?php $i = 0; ?>
        <?php foreach ( $payment_gateways as $gateway ) : ?>
            <li>
                <input type="radio" name="hb-payment-method" id="hb-payment-method-<?php echo esc_attr( $i ); ?>" value="<?php echo esc_attr( $gateway->slug ); ?>"<?php if ( $i === 0 ) { echo ' checked'; } ?>/>
                <label for="hb-payment-method-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $gateway->title ); ?></label>
                <?php if ( has_action( 'hb_payment_gateway_form_' . $gateway->slug ) ) { ?>
                    <div class="hb-payment-method-form <?php echo esc_attr( $gateway->slug ); ?>">
                        <?php do_action( 'hb_payment_gateway_form_' . $gateway->slug ); ?>
                    </div>
                <?php } ?>
            </li>
        <?php $i ++; endforeach; ?>
    </ul>
</div>
