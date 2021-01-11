<?php
/**
 * The template for displaying search room form.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/search/search-form.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.9.7
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

$atts = array();
if ( $args && isset( $args['atts'] ) ) {
	$atts = $args['atts'];
} elseif ( isset( $args ) ) {
	$atts = $args;
}

$check_in_date  = hb_get_request( 'check_in_date' );
$check_out_date = hb_get_request( 'check_out_date' );
$adults         = hb_get_request( 'adults', 0 );
$max_child      = hb_get_request( 'max_child', 0 );
$uniqid         = uniqid();

$show_label = ( isset( $atts['show_label'] ) && strtolower( $atts['show_label'] ) === 'false' ) ? false : true;
$show_children = false;
$hb_classes = ' cf';

if ( isset( $atts['show_children'] ) && $atts['show_children'] ) {
	$show_children = true;
}

if ( $show_label ) {
	$hb_classes .= ' show-label';
}

if ( !$show_children ) {
	$hb_classes .= ' hide-children';
}

if ( isset( $atts['default_dates'] ) && $atts['default_dates'] ) {
	if ( empty( $check_in_date ) && empty( $check_out_date ) ) {
		$minimum_booking_nights = get_option( 'tp_hotel_booking_minimum_booking_day' );
		$booking_nights = isset( $minimum_booking_nights ) ? absint( $minimum_booking_nights ) : 0;
		$booking_nights = $booking_nights == 0 ? 86400 : 86400*$booking_nights;
		$check_in_date = date_i18n( get_option( 'date_format' ) );
		$check_out_date = date_i18n( get_option( 'date_format' ), ( time() + $booking_nights ) );
	}
}

?>
<div id="hotel-booking-search-<?php echo uniqid(); ?>" class="hotel-booking-search<?php echo esc_attr( $hb_classes ) ?>">
	<?php if ( isset( $atts['show_title'] ) && strtolower( $atts['show_title'] ) === 'true' ) : ?>
        <h3 class="section-heading"><?php esc_html_e( 'Search your room', 'lava' ); ?></h3>
	<?php endif; ?>
    <form name="hb-search-form" action="<?php echo hb_get_url(); ?>"
          class="hb-search-form-<?php echo esc_attr( $uniqid ) ?>">
        <ul class="hb-form-table">
            <li class="hb-form-field">
				<?php hb_render_label_shortcode( $atts, 'show_label', esc_html__( 'Check In', 'lava' ), 'true' ); ?>
                <div class="hb-form-field-input hb_input_field">
                    <input type="text" name="check_in_date" id="check_in_date_<?php echo esc_attr( $uniqid ); ?>"
                           class="hb_input_date_check" value="<?php echo esc_attr( $check_in_date ); ?>"
                           placeholder="<?php esc_attr_e( 'Arrival Date', 'lava' ); ?>"/>
                </div>
            </li>

            <li class="hb-form-field">
				<?php hb_render_label_shortcode( $atts, 'show_label', esc_html__( 'Check Out', 'lava' ), 'true' ); ?>
                <div class="hb-form-field-input hb_input_field">
                    <input type="text" name="check_out_date" id="check_out_date_<?php echo esc_attr( $uniqid ) ?>"
                           class="hb_input_date_check" value="<?php echo esc_attr( $check_out_date ); ?>"
                           placeholder="<?php esc_attr_e( 'Departure Date', 'lava' ); ?>"/>
                </div>
            </li>

            <li class="hb-form-field hb-adult-field">
				<?php hb_render_label_shortcode( $atts, 'show_label', esc_html__( 'Guests', 'lava' ), 'true' ); ?>
                <div class="hb-form-field-input">
					<?php
					hb_dropdown_numbers(
						array(
							'name'              => 'adults_capacity',
							'min'               => 1,
							'max'               => hb_get_max_capacity_of_rooms(),
							'show_option_none'  => esc_html__( 'Guests', 'lava' ),
							'selected'          => $adults,
							'option_none_value' => 0,
							'options'           => hb_get_capacity_of_rooms()
						)
					);
					?>
                </div>
            </li>
			<?php if ( $show_children ) : ?>	
	            <li class="hb-form-field hb-child-field">
					<?php hb_render_label_shortcode( $atts, 'show_label', esc_html__( 'Children', 'lava' ), 'true' ); ?>
	                <div class="hb-form-field-input">
						<?php
						hb_dropdown_numbers(
							array(
								'name'              => 'max_child',
								'min'               => 1,
								'max'               => hb_get_max_child_of_rooms(),
								'show_option_none'  => esc_html__( 'Children', 'lava' ),
								'option_none_value' => 0,
								'selected'          => $max_child,
							)
						);
						?>
	                </div>
	            </li>
            <?php endif; ?>
        </ul>
		<?php wp_nonce_field( 'hb_search_nonce_action', 'nonce' ); ?>
        <input type="hidden" name="hotel-booking" value="results"/>
        <input type="hidden" name="widget-search"
               value="<?php echo isset( $atts['widget_search'] ) ? esc_attr( $atts['widget_search'] ) : false; ?>"/>
        <input type="hidden" name="action" value="hotel_booking_parse_search_params"/>
        <p class="hb-submit">
            <button type="submit" class="btn-primary"><?php esc_html_e( 'Check', 'lava' ); ?></button>
        </p>
    </form>
</div>