<?php

/**
 * The template for displaying confirm actions.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/confirm.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit(); ?>

<div id="hotel-booking-confirm">
   	<?php _e( 'Confirm', 'lava' ); ?>
    <form name="hb-search-form">
        <input type="hidden" name="hotel-booking" value="complete">
        <p>
            <button class="btn-primary" type="submit"><?php esc_html_e( 'Finish', 'lava' ); ?></button>
        </p>
    </form>
</div>