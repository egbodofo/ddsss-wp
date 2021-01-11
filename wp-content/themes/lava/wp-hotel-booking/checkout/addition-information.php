<?php
/**
 * The template for displaying additional information in checkout page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/checkout/addition-information.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

?>
<div class="hb-addition-information">
    <h4><?php esc_html_e( 'Addition Information', 'lava' ); ?></h4>
    <textarea name="addition_information" rows="3"></textarea>
</div>