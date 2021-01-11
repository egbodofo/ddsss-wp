<?php
/*
Plugin Name: Lava Extension
Plugin URI: https://themespirit.com
Description: Extend Lava theme features.
Author: ThemeSpirit
Version: 1.0.8
Author URI: https://themespirit.com
License: GPL
License URI: -
*/

if ( !defined( 'LAVA_EXTENSION_VERSION' ) ) define( 'LAVA_EXTENSION_VERSION', '1.0.8' );
if ( !defined( 'LAVA_EXTENSION_DIR' ) ) define( 'LAVA_EXTENSION_DIR', plugin_dir_path( __FILE__ ) );
if ( !defined( 'LAVA_EXTENSION_URI' ) ) define( 'LAVA_EXTENSION_URI', plugin_dir_url( __FILE__ ) );

require_once( 'includes/functions.php' );
require_once( 'includes/shortcodes.php' );
require_once( 'includes/libs/kirki/kirki.php' );
require_once( 'includes/class-fonts.php' );
require_once( 'includes/class-hybrid-media-grabber.php' );

if ( is_admin() ) {
	require_once( 'includes/libs/meta-box/meta-box.php' );
	require_once( 'includes/libs/meta-box-conditional-logic/meta-box-conditional-logic.php' );
	require_once( 'includes/class-widget-areas.php' );
	require_once( 'includes/class-custom-fonts.php' );
}

add_action( 'plugins_loaded', 'lava_extension_plugin_textdomain' );
/**
 * Load plugin textdomain
 */
function lava_extension_plugin_textdomain() {
	load_plugin_textdomain( 'lava_extension', false, dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
}


add_action( 'wp_enqueue_scripts', 'lava_extension_frontend_scripts' );
/**
 * Enqueue frontend scripts
 */
function lava_extension_frontend_scripts() {
	wp_register_script(
		'bootstrap-modal',
		LAVA_EXTENSION_URI . 'assets/js/bootstrap.modal.min.js',
		array( 'jquery' ),
		LAVA_EXTENSION_VERSION,
		true
	);
	wp_register_script(
		'lava-booking-form',
		LAVA_EXTENSION_URI . 'assets/js/booking-form.min.js',
		array( 'jquery', 'bootstrap-modal' ),
		LAVA_EXTENSION_VERSION,
		true
	);

	wp_localize_script( 'lava-booking-form', 'lava_js_data',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'date_time_format' => lava_date_time_format_js(),
			'date_start' => get_option( 'start_of_week' ),
			'required_fields' => __( 'Please fill in all required fields.', 'lava_extension' ),
		)
	);
}


add_action( 'wp_ajax_lava_booking_form', 'lava_ajax_booking_form' );
add_action( 'wp_ajax_nopriv_lava_booking_form', 'lava_ajax_booking_form' );

if ( !function_exists( 'lava_ajax_booking_form' ) ) {
    function lava_ajax_booking_form() {
        $form_data = array();
        parse_str( $_POST['bf_data'], $form_data );

        if ( empty( $form_data['bf_nonce'] ) || !wp_verify_nonce( $form_data['bf_nonce'], 'lava_bf_nonce' ) ) {
            wp_send_json_error( array( 'message' => '<span class="error">' . __( 'Token is invalid or expired. Please refresh and try again.', 'lava_extension' ) . '</span>' ) );
        }

        $sent = lava_booking_form_admin_notice( $form_data );
        
        if ( $sent ) {
            wp_send_json_success( array( 'message' => '<span class="success">' . __( 'Your booking request has been sent successfully. We will get back to you shortly!', 'lava_extension' ) . '</span>' ) );
        } else {
            wp_send_json_error( array( 'message' => '<span class="error">' . __( 'System is unable to send you an email. Please refresh and try again later.', 'lava_extension' ) . '</span>' ) );
        }
        exit;
    }
}


if ( !function_exists( 'lava_booking_form_admin_notice' ) ) {
    /**
     * Send new booking email - notify site admin
     * 
     * @param  array $data    form data
     * @return boolean/
     */
    function lava_booking_form_admin_notice( $data = array() ) {
        
        $from_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
        $from_name = apply_filters( 'lava_booking_form_from_name', $from_name );
        
		// Get the site domain and get rid of www.
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}

		$from_email = 'admin@' . $sitename;
		$from_address = apply_filters( 'lava_booking_form_from_address', $from_email );

		$to = apply_filters( 'lava_booking_form_recipients', get_option( 'admin_email' ) );

		$subject = __( 'New Booking!', 'lava_extension' );
        $subject = apply_filters( 'lava_booking_form_subject', $subject );

        $content_type = 'text/plain';
        $headers  = "From: {$from_name} <{$from_address}>\r\n";
        $headers .= "Reply-To: {$from_address}\r\n";
        $headers .= "Content-Type: {$content_type}; charset=utf-8\r\n";

        $message = lava_get_template_html( 'emails/plain/new-booking.php', array(
            'name'  		 => isset( $data['bf_name'] ) ? $data['bf_name'] : '',
            'email'          => isset( $data['bf_email'] ) ? $data['bf_email'] : '',
            'phone'          => isset( $data['bf_phone'] ) ? $data['bf_phone'] : '',
            'check_in_date'  => isset( $data['bf_check_in_date'] ) ? $data['bf_check_in_date'] : '',
            'check_out_date' => isset( $data['bf_check_out_date'] ) ? $data['bf_check_out_date'] : '',
            'guests'         => isset( $data['bf_guests'] ) ? $data['bf_guests'] : '',
            'room_type'      => isset( $data['bf_room_type'] ) ? $data['bf_room_type'] : '',
            'message'        => isset( $data['bf_message'] ) ? $data['bf_message'] : '',
        ));
        
        return wp_mail( $to, $subject, $message, $headers );
    }
}

add_shortcode( 'lava_booking_form', 'lava_shortcode_booking_form' );

if ( !function_exists( 'lava_shortcode_booking_form' ) ) {
	/**
	 * Print booking form
	 */
	function lava_shortcode_booking_form( $atts ) {
		wp_enqueue_script( 'bootstrap-modal' );
		wp_enqueue_script( 'lava-booking-form' );

		extract( shortcode_atts( array(
			'show_label' => 1,
			'min_booking_days' => 1,
			'max_guests' => 5,
			'room_types' => '',
			'popup' => 1
		), $atts ) );

		$room_types = !empty( $room_types ) ? explode( ',', $room_types ) : '';
		$sf_uniqid = uniqid();
		$bf_uniqid = uniqid();

		?>
		<div class="lava-booking-form" data-min-days="<?php echo esc_attr( absint( $min_booking_days ) ); ?>">
			<?php if ( $popup ) : ?>
			<div class="hotel-booking-search cf hide-children<?php if ( $show_label ) { echo ' show-label'; } ?>">
			    <form class="hb-search-form" action="">
			        <ul class="hb-form-table">
			            <li class="hb-form-field">
			            	<?php if ( $show_label ) : ?>
				                <label><?php esc_html_e( 'Check In', 'lava_extension' ); ?></label>
				            <?php endif; ?>
			                <div class="hb-form-field-input hb_input_field">
			                    <input type="text" name="bf_check_in_date" id="bf_check_in_date_<?php echo esc_attr( $sf_uniqid ); ?>" class="hb_input_date_check" placeholder="<?php esc_html_e( 'Arrival Date', 'lava_extension' ); ?>"/>
			                </div>
			            <li class="hb-form-field">
			            	<?php if ( $show_label ) : ?>
			                	<label><?php esc_html_e( 'Check Out', 'lava_extension' ); ?></label>
			                <?php endif; ?>
			                <div class="hb-form-field-input hb_input_field">
			                    <input type="text" name="bf_check_out_date" id="bf_check_out_date_<?php echo esc_attr( $sf_uniqid ); ?>" class="hb_input_date_check" placeholder="<?php esc_html_e( 'Departure Date', 'lava_extension' ); ?>"/>
			                </div>
			            </li>
			            <li class="hb-form-field">
			            	<?php if ( $show_label ) : ?>
			                	<label><?php esc_html_e( 'Guests', 'lava_extension' ); ?></label>
			                <?php endif; ?>	
			                <div class="hb-form-field-input">
			                    <select name="bf_guests" class="hb_input_guests">
									<option value=""><?php esc_html_e( 'Guests', 'lava_extension' ); ?></option>
									<?php for ( $number = 1; $number <= $max_guests; $number ++ ) : ?>
										<option value="<?php echo esc_attr( $number ); ?>"><?php echo esc_html( $number ); ?></option>
									<?php endfor; ?>
			                    </select>
			                </div>
			            </li>
			        </ul>
			        <p class="hb-submit">
			            <button type="button" class="btn-primary" data-toggle="modal" data-target="#lava-booking-form-<?php echo esc_attr( $bf_uniqid ); ?>" data-backdrop="false"><?php esc_html_e( 'Check', 'lava_extension' ); ?></button>
			        </p>
			    </form>
			</div>
			<?php endif; ?>
			<?php if ( $popup ) : ?>
			    <div class="modal lava-booking-form-modal" id="lava-booking-form-<?php echo esc_attr( $bf_uniqid ); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php esc_attr_e( 'Booking Form', 'lava_extension' ); ?>">
			        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			            <div class="modal-content">
			                <div class="modal-header">
			                    <h2><?php esc_attr_e( 'Booking Form', 'lava_extension' ); ?></h2>
			                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="material-icons">close</i></span>
			                </div>
			                <div class="modal-body">
		    <?php endif; ?>
		                	<div class="booking-form-message"></div>
		                    <form class="booking-form hotel-booking-search" method="post" action="">
		                        <input type="text" name="bf_name" class="booking-form-input input-field-small validate" placeholder="<?php esc_html_e( 'Full Name', 'lava_extension' ); ?>" />
		                        <input type="email" name="bf_email" class="booking-form-input input-field-small validate" placeholder="<?php esc_html_e( 'Email', 'lava_extension' ); ?>" />
		                        <input type="text" name="bf_phone" class="booking-form-input input-field-small" placeholder="<?php esc_html_e( 'Phone Number', 'lava_extension' ); ?>" />
		                        <div class="row">
		                            <div class="col x12 s6">
		                                <div class="hb_input_field booking-form-input">
		                                    <input type="text" name="bf_check_in_date" id="bf_check_in_date_<?php echo esc_attr( $bf_uniqid ); ?>" class="input-field-small validate" placeholder="<?php esc_html_e( 'Arrival Date', 'lava_extension' ); ?>" />
		                                </div>
		                            </div>
		                            <div class="col x12 s6">
		                                <div class="hb_input_field booking-form-input">
		                                    <input type="text" name="bf_check_out_date" id="bf_check_out_date_<?php echo esc_attr( $bf_uniqid ); ?>" class="input-field-small validate" placeholder="<?php esc_html_e( 'Departure Date', 'lava_extension' ); ?>" />
		                                </div>
		                            </div>
		                        </div>
		                        <select name="bf_guests" class="booking-form-input input-field-small booking-form-guests">
									<option value=""><?php esc_html_e( 'Guests', 'lava_extension' ); ?></option>
									<?php for ( $number = 1; $number <= $max_guests; $number ++ ) : ?>
										<option value="<?php echo esc_attr( $number ); ?>"><?php echo esc_html( $number ); ?></option>
									<?php endfor; ?>
		                        </select>
		                        <?php if ( !empty( $room_types ) ) : ?>
			                        <select name="bf_room_type" class="booking-form-input input-field-small booking-form-room-type">
										<option value=""><?php esc_html_e( 'Room Type', 'lava_extension' ); ?></option>
										<?php foreach ( $room_types as $type ) : ?>
											<?php $type = trim( $type ); ?>
											<option value="<?php echo esc_attr( $type ); ?>"><?php echo esc_html( $type ); ?></option>
										<?php endforeach; ?>
			                        </select>
			                    <?php endif; ?>
		                        <textarea name="bf_message" class="booking-form-input" rows="4" placeholder="<?php esc_html_e( 'Message', 'lava_extension' ); ?>"></textarea>
		                        <div>
		                        	<button type="submit" class="btn-primary booking-form-submit"><?php esc_html_e( 'Make Reservation', 'lava_extension' ); ?></button>
		                        </div>
		                        <input type="hidden" class="booking-form-nonce" name="bf_nonce" value="<?php echo wp_create_nonce( 'lava_bf_nonce' ); ?>" />
		                    </form>
		    <?php if ( $popup ) : ?>
		                </div>
		            </div>
		        </div>
		    </div>
			<?php endif; ?>
		</div>
		<?php
	}
}

add_action( 'lava_post_share', 'lava_post_share_buttons' );

if ( !function_exists( 'lava_post_share_buttons' ) ) {
	/**
	 * Print share buttons on single post
	 */
	function lava_post_share_buttons() {
		$post_url = get_the_permalink();
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		$query_title = preg_replace( '/\s/', '%20', get_the_title() );
		?>
		<div class="post-share">
			<span><?php esc_html_e( 'Share', 'lava_extension' ); ?></span>
			<div class="social-list">
				<a href="<?php echo esc_url( 'http://www.facebook.com/sharer.php?u='. rawurlencode( $post_url ) ); ?>" title="<?php esc_attr_e( 'Share on Facebook', 'lava_extension' ); ?>"><i class="lava-icon-facebook"></i></a>
				<a href="<?php echo esc_url( 'http://twitter.com/intent/tweet?url=' . rawurlencode( $post_url ) . '&amp;text=' . $query_title . '&amp;via=' . get_bloginfo( 'name' ) ); ?>" title="<?php esc_attr_e( 'Tweet it', 'lava_extension' ); ?>"><i class="lava-icon-twitter"></i></a>
				<a href="<?php echo esc_url( 'https://plus.google.com/share?url='. rawurlencode( $post_url ) ); ?>" title="<?php esc_attr_e( 'Share on Google Plus', 'lava_extension' ); ?>"><i class="lava-icon-gplus"></i></a>
				<a href="<?php echo esc_url( 'http://pinterest.com/pin/create/button/?url='. rawurlencode( $post_url ) .'&amp;media=' . $image[0] . '&amp;description=' . $query_title ); ?>" title="<?php esc_attr_e( 'Pin it on Pinterest', 'lava_extension' ); ?>"><i class="lava-icon-pinterest"></i></a>
				<a href="<?php echo esc_url( 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . rawurlencode( $post_url ) . '&amp;title=' . $query_title ); ?>" title="<?php esc_attr_e( 'Share on LinkedIn', 'lava_extension' ); ?>"><i class="lava-icon-linkedin"></i></a>
				<a href="<?php echo esc_url( 'mailto:?subject=' . $query_title . '&amp;body=' . rawurlencode( $post_url ) ); ?>" title="<?php esc_attr_e( 'Share via email', 'lava_extension' ); ?>"><i class="lava-icon-mail"></i></a>
			</div>
		</div>
		<?php
	}
}

