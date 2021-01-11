<?php
/**
 * Template for displaying single book room.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking-room/single-book-room.php.
 *
 * @author   ThimPress
 * @package  WP-Hotel-Booking/Booking-Room/Templates
 * @version  1.7.8
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post;
if ( ! $post ) {
	return;
} ?>

<!--Single search form-->
<script type="text/html" id="tmpl-hb-room-load-form-cart">
	<form action="POST" name="hb-search-results" class="hb-search-room-results hotel-booking-search hotel-booking-single-room-action">
		<div class="hb-booking-room-form-head">
			<h2 class="hb-room-name"><?php printf( '%s', $post->post_title ) ?></h2>
			<p class="description"><?php esc_html_e( 'Please select number of room and packages (optional)', 'lava' ) ?></p>
		</div>
		<div class="hb-search-results-form-container cf">
			<?php do_action( 'hotel_booking_room_before_quantity', $post ); ?>
			<# if ( typeof data.qty !== 'undefined' ) { #>
				<div class="hb-booking-room-form-group">
					<div class="hb-booking-room-form-field hb-form-field-input">
						<?php if ( get_option( 'tp_hotel_booking_single_purchase' ) ) { ?>
							<select name="hb-num-of-rooms" class="number_room_select" style="display: none;">
								<option value="1">1</option>
							</select>
						<?php } else { ?>
							<select name="hb-num-of-rooms" class="number_room_select">
								<option value=""><?php esc_html_e( 'Rooms', 'lava' ); ?></option>
								<# for( var i = 1; i <= data.qty; i++ ) { #>
									<option value="{{ i }}">{{ i }}</option>
								<# } #>
							</select>
						<?php } ?>
					</div>
				</div>
			<# } #>
			<?php do_action( 'hotel_booking_room_after_quantity', $post ); ?>
			<?php do_action( 'hotel_booking_loop_after_item', $post->ID ); ?>
		</div>
		<div class="hb-booking-room-form-footer">
			<a href="#" data-template="hb-room-load-form" class="hb_previous_step btn-primary"><?php esc_html_e( 'Previous', 'lava' ); ?></a>
            <button type="submit" class="hb_add_to_cart btn-primary"><?php esc_html_e( 'Add To Cart', 'lava' ); ?></button>
			<input type="hidden" name="check_in_date_text" value="{{ data.check_in_date_text }}" />
			<input type="hidden" name="check_out_date_text" value="{{ data.check_out_date_text }}" />
			<input type="hidden" name="check_in_date" value="{{ data.check_in_date }}" />
			<input type="hidden" name="check_out_date" value="{{ data.check_out_date }}" />
			<input type="hidden" name="room-id" value="<?php printf( '%s', $post->ID ) ?>" />
			<input type="hidden" name="action" value="hotel_booking_ajax_add_to_cart"/>
			<input type="hidden" name="is_single" value="1" />
			<?php wp_nonce_field( 'hb_booking_nonce_action', 'nonce' ); ?>
		</div>
	</form>
</script>
