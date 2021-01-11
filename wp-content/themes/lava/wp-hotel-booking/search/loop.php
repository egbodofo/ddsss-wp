<?php
/**
 * The template for displaying search room item loop.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/search/loop.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $hb_settings;
$gallery  = $room->gallery;
$featured = $gallery ? array_shift( $gallery ) : false;
$display_gallery = ( isset( $atts['gallery'] ) && $atts['gallery'] === 'true' ) || $hb_settings->get( 'enable_gallery_lightbox' );
$single_purchase = get_option( 'tp_hotel_booking_single_purchase' );

?>
<li class="hb-room clearfix">

    <form name="hb-search-results" class="hb-search-room-results<?php if ( $single_purchase ) { echo ' single-purchase'; } ?>">
		<?php do_action( 'hotel_booking_loop_before_item', $room->post->ID ); ?>
        <div class="hb-room-content">
            <div class="hb-room-thumbnail">
				<?php if ( $featured ): ?>
                    <a class="hb-room-gallery swipebox" rel="hb-room-gallery-<?php echo esc_attr( $room->post->ID ); ?>" href="<?php echo esc_attr( $featured['src'] ); ?>">
						<?php $room->getImage( 'catalog' ); ?>
                    </a>
                    <?php if ( $display_gallery ) : ?>
                        <i class="material-icons">copy</i>
                    <?php endif; ?>
				<?php endif; ?>
            </div>
            <div class="hb-room-info">
                <?php lava_hb_room_title($room->ID, Lava_Util::get_option( 'hb_search_oneline_title', true ), false, 'hb-room-name' ); ?>
                <ul class="hb-room-meta">
                    <li class="hb_search_capacity">
                        <label><?php esc_html_e( 'Guests:', 'lava' ); ?></label>
                        <span class="meta_value"><?php echo esc_html( $room->capacity ); ?></span>
                    </li>
                    <li class="hb_search_max_child">
                        <label><?php esc_html_e( 'Children:', 'lava' ); ?></label>
                        <span class="meta_value"><?php echo esc_html( $room->max_child ); ?></span>
                    </li>
                </ul>
                <div class="hb-room-excerpt"><?php lava_hb_room_excerpt( $room->ID, Lava_Util::get_option( 'hb_search_excerpt_length', 150 ) ); ?></div>
                <div class="hb_search_price">
                    <label><?php esc_html_e( 'Price:', 'lava' ); ?></label>
                    <span class="hb_search_item_price"><?php echo hb_format_price( $room->amount_singular ); ?></span>
                    <div class="hb_view_price">
                        <a href="" class="hb-view-booking-room-details"><?php esc_html_e( 'View price breakdown', 'lava' ); ?></a>
                        <?php hb_get_template( 'search/booking-room-details.php', array( 'room' => $room ) ); ?>
                    </div>
                </div>
                <div class="hb-search-select">
                <?php if ( !$single_purchase ) : ?>
                    <div class="hb_search_quantity">
                        <?php
                            hb_dropdown_numbers(
                                array(
                                    'name'             => 'hb-num-of-rooms',
                                    'min'              => 1,
                                    'show_option_none' => esc_html__( 'Quantity', 'lava' ),
                                    'max'              => $room->post->available_rooms,
                                    'class'            => 'number_room_select input-field-small'
                                )
                            );
                        ?>
                    </div>
                    <?php else : ?>
                        <select name="hb-num-of-rooms" class="number_room_select single_select" style="display:none;">
                            <option value="1">1</option>
                        </select>
                    <?php endif; ?>
                    <div class="hb_search_add_to_cart">
                        <button class="hb_add_to_cart btn-primary btn-small"><?php esc_html_e( 'Select this room', 'lava' ) ?></button>
                    </div>
                </div>
            </div>
        </div>

		<?php wp_nonce_field( 'hb_booking_nonce_action', 'nonce' ); ?>
        <input type="hidden" name="check_in_date" value="<?php echo date( 'm/d/Y', hb_get_request( 'hb_check_in_date' ) ); ?>" />
        <input type="hidden" name="check_out_date" value="<?php echo date( 'm/d/Y', hb_get_request( 'hb_check_out_date' ) ); ?>">
        <input type="hidden" name="room-id" value="<?php echo esc_attr( $room->post->ID ); ?>">
        <input type="hidden" name="hotel-booking" value="cart">
        <input type="hidden" name="action" value="hotel_booking_ajax_add_to_cart" />
		<?php do_action( 'hotel_booking_loop_after_item', $room->post->ID ); ?>
    </form>
	<?php if ( $display_gallery ): ?>
		<?php hb_get_template( 'loop/gallery-lightbox.php', array( 'room' => $room ) ); ?>
	<?php endif; ?>
</li>