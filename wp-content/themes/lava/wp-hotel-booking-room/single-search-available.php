<?php
/**
 * Template for displaying single search available.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking-room/single-search-available.php.
 *
 * @author  ThimPress
 * @package  WP-Hotel-Booking/Booking-Room/Templates
 * @version  1.7.2
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post;
if ( !$post || !is_single( $post->ID ) || get_post_type( $post->ID ) !== 'hb_room' ) {
    return;
} ?>

<div id="hotel_booking_room_hidden"></div>
<!--Single search form-->
<script type="text/html" id="tmpl-hb-room-load-form">

    <form action="POST" name="hb-search-single-room" class="hb-search-room-results hotel-booking-search hotel-booking-single-room-action">

        <div class="hb-booking-room-form-head">
            <h2 class="hb-room-name"><?php printf( '%s', $post->post_title ); ?></h2>
            <p class="description"><?php esc_html_e( 'Please set arrival date and departure date before check available.', 'lava' ); ?></p>
        </div>

        <div class="hb-search-results-form-container cf">
            <div class="hb-booking-room-form-group">
                <div class="hb-booking-room-form-field hb-form-field-input">
                    <input type="text" name="check_in_date" value="{{ data.check_in_date }}" placeholder="<?php esc_attr_e( 'Arrival Date', 'lava' ); ?>" />
                </div>
            </div>
            <div class="hb-booking-room-form-group">
                <div class="hb-booking-room-form-field hb-form-field-input">
                    <input type="text" name="check_out_date" value="{{ data.check_out_date }}" placeholder="<?php esc_attr_e( 'Departure Date', 'lava' ); ?>" />
                </div>
            </div>
            <div class="hb-booking-room-form-group">
                <input type="hidden" name="room-name" value="<?php printf( '%s', $post->post_title ); ?>" />
                <input type="hidden" name="room-id" value="<?php printf( '%s', $post->ID ); ?>" />
                <input type="hidden" name="action" value="hotel_booking_single_check_room_available"/>
                <?php wp_nonce_field( 'hb_booking_single_room_check_nonce_action', 'hb-booking-single-room-check-nonce-action' ); ?>
                <button type="submit" class="hb_button btn-primary"><?php esc_html_e( 'Check', 'lava' ); ?></button>
            </div>
        </div>
    </form>

</script>

<!--Quanity select-->
<script type="text/html" id="tmpl-hb-room-load-qty">
    <div class="hb-booking-room-form-group">
        <label><?php esc_html_e( 'Quantity Available', 'lava' ); ?></label>
        <div class="hb-booking-room-form-field hb-form-field-input">
            <select name="hb-num-of-rooms" id="hotel_booking_room_qty" class="number_room_select">
                <option value=""><?php esc_html_e( '--- Rooms ---', 'lava' ); ?></option>
                <# for( var i = 1; i <= data.qty; i++ ) { #>
                <option value="{{ i }}">{{ i }}</option>
                <# } #>
            </select>
        </div>
    </div>
</script>
