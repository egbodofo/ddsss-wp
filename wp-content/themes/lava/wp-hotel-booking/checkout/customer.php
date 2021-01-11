<?php
/**
 * The template for displaying customer in checkout page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/checkout/customer.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

/**
 * @var $customer
 */
?>

<h3><?php esc_html_e( 'Customer Details', 'lava' ); ?></h3>
<div class="hb-customer cf">
	<?php hb_get_template( 'checkout/customer-existing.php', array( 'customer' => $customer ) ); ?>
	<?php hb_get_template( 'checkout/customer-new.php', array( 'customer' => $customer ) ); ?>
</div>
