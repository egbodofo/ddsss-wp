<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Emails Class.
 * Get general settings
 * @class 		BABE_Emails
 * @version		1.0.0
 * @author 		Booking Algorithms
 */

class BABE_Emails {
    
//////////////////////////////
    /**
	 * Hook in tabs.
	 */
    public static function init() {
        
        add_action( 'babe_created_customer', array( __CLASS__, 'send_email_new_customer_created' ), 10, 3);
        add_action( 'wp_mail_failed', array( __CLASS__, 'send_email_errors' ) );
        
        add_action( 'babe_user_password_reseted', array( __CLASS__, 'send_email_password_reseted'), 10, 2);
        
        add_action( 'babe_order_canceled', array( __CLASS__, 'send_email_order_canceled'), 20, 1);
        
        add_action( 'babe_order_canceled', array( __CLASS__, 'send_admin_email_order_canceled'), 10, 1);
        
	}
    
////////////////////////
     /**
	 * Store errors from send email
     * @param object WP_Error
     * @return
	 */
     public static function send_email_errors($wp_error){
        
        error_log('Send mail error message: '.print_r($wp_error->get_error_messages('wp_mail_failed'), 1));
        error_log('Send mail error data: '.print_r($wp_error->get_error_data('wp_mail_failed'), 1));
        
        return;
        
     }    
    
////////////////////////
     /**
	 * Set html content type for email
     * @return string
	 */
     public static function set_html_mail_content_type(){
        
        return 'text/html';
        
     }
     
////////////////////////
     /**
	 * Get manager email
     * @param int $order_id
     * @return string
	 */
     public static function get_manager_email($order_id){
        
        $output = get_bloginfo( 'admin_email' );
        
        $output = apply_filters('babe_email_get_manager_email', $output, $order_id);
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Get customer details
     * @param int $order_id
     * @return array
	 */
     public static function get_customer_details($order_id){
        
        $output = BABE_Order::get_order_customer_details($order_id);
        
        if (!isset($output['email'])){
            $output['email'] = '';
        }
        
        $output = apply_filters('babe_email_get_customer_details', $output, $order_id);
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Parse email template
     * 
     * @param string $content
     * @param int $order_id
     * 
     * @return string
	 */
     public static function parse_email_template($content, $order_id){
        
        $output = $content;
        
        if (strpos($output, '{order_items}') !== false){
            
            $order_items_html = BABE_html::order_items($order_id);
            $replace_content = BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
            $replace_content .= BABE_html_emails::email_get_row_content($order_items_html);
            $output = str_replace( '{order_items}', $replace_content, $output );
            
        }
        
        if (strpos($output, '{order_customer}') !== false){
            
            $customer_html = BABE_html::order_customer_details($order_id);
            $replace_content = BABE_html_emails::email_get_row_title(__('Customer details', BABE_TEXTDOMAIN), 1);;
            $replace_content .= BABE_html_emails::email_get_row_content($customer_html);
            $output = str_replace( '{order_customer}', $replace_content, $output );
            
        }
        
        return $output;
        
     }     
     
////////////////////////
     /**
	 * Send admin email new order
     * @param int $order_id
     * @return
	 */
     public static function send_admin_email_new_order($order_id){

         $email_to = self::get_manager_email($order_id);

         if ( empty($email_to) ){
             return;
         }
        
        $order_items_html = BABE_html::order_items($order_id);
        
        $customer_html = BABE_html::order_customer_details($order_id);
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_admin_new_order_title'] );
        
        $body .= BABE_html_emails::email_get_row_content( BABE_Settings::$settings['email_admin_new_order_message'] );
        
        $body .= BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
        
        $body .= BABE_html_emails::email_get_row_content($order_items_html);
        
        $body .= BABE_html_emails::email_get_row_title(__('Customer details', BABE_TEXTDOMAIN), 1);
        
        $body .= BABE_html_emails::email_get_row_content($customer_html);
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_admin_new_order', $body, $order_id);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        self::send_email($email_to, esc_html(sprintf(BABE_Settings::$settings['email_admin_new_order_subject'], BABE_Order::get_order_number($order_id))), $body);
        
        return;
        
     }               
     
////////////////////////
     /**
	 * Send admin email new order confirmation
     * @param int $order_id
     * @return
	 */
     public static function send_admin_email_new_order_av_confirm($order_id){

         $email_to = self::get_manager_email($order_id);

         if ( empty($email_to) ){
             return;
         }
        
        $order_items_html = BABE_html::order_items($order_id);
        
        $customer_html = BABE_html::order_customer_details($order_id);
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_admin_new_order_av_confirm_title'] );
        
        $body .= BABE_html_emails::email_get_row_content( BABE_Settings::$settings['email_admin_new_order_av_confirm_message'] );
        
        $body .= BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
        
        $body .= BABE_html_emails::email_get_row_content($order_items_html);
        
        if (apply_filters('babe_email_admin_order_av_confirm_add_customer_details', true)){
        
        $body .= BABE_html_emails::email_get_row_title(__('Customer details', BABE_TEXTDOMAIN), 1);
        
        $body .= BABE_html_emails::email_get_row_content($customer_html);
        
        }
        
        $body .= BABE_html_emails::email_get_row_button(__('Confirm', BABE_TEXTDOMAIN), BABE_Order::get_admin_confirmation_page($order_id, 'confirm'), 1);
        
        $body .= BABE_html_emails::email_get_row_button(__('Reject', BABE_TEXTDOMAIN), BABE_Order::get_admin_confirmation_page($order_id, 'reject'), 2);
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_admin_new_order_av_confirm', $body, $order_id);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        self::send_email($email_to, esc_html(BABE_Settings::$settings['email_admin_new_order_av_confirm_subject']), $body);
        
        return;
        
     }
     
////////////////////////
     /**
	 * Send customer email new order created
     * @param int $order_id
     * @return
	 */
     public static function send_email_new_order_av_confirm($order_id){
        
        $order_items_html = BABE_html::order_items($order_id);
        
        $customer_html = BABE_html::order_customer_details($order_id);
                
        $customer_details = self::get_customer_details($order_id);
        
        if ($customer_details['email']){
        
        $email_to = $customer_details['email'];
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_new_order_av_confirm_title'] );
        
        $body .= BABE_html_emails::email_get_row_content(sprintf(BABE_Settings::$settings['email_new_order_av_confirm_message'], $customer_details['first_name'].' '.$customer_details['last_name']));
        
        $body .= BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
        
        $body .= BABE_html_emails::email_get_row_content($order_items_html);
        
        $body .= BABE_html_emails::email_get_row_title(__('Your contacts', BABE_TEXTDOMAIN), 1);
        
        $body .= BABE_html_emails::email_get_row_content($customer_html);
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_new_order_av_confirm', $body, $order_id);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        self::send_email($email_to, esc_html(sprintf(BABE_Settings::$settings['email_new_order_av_confirm_subject'], BABE_Order::get_order_number($order_id))), $body);
        
        }
        
        return;
        
     }
     
////////////////////////
     /**
	 * Send customer email new order created
     * @param int $order_id
     * @return
	 */
     public static function send_email_new_order($order_id){
        
        $order_items_html = BABE_html::order_items($order_id);
        
        $customer_html = BABE_html::order_customer_details($order_id);
                
        $customer_details = self::get_customer_details($order_id);
        
        if ($customer_details['email']){
        
        $email_to = $customer_details['email'];
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_new_order_title'] );
        
        $body .= BABE_html_emails::email_get_row_content(sprintf( BABE_Settings::$settings['email_new_order_message'] , $customer_details['first_name'].' '.$customer_details['last_name']));
        
        $body .= BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
        
        $body .= BABE_html_emails::email_get_row_content($order_items_html);
        
        $body .= BABE_html_emails::email_get_row_title(__('Your contacts', BABE_TEXTDOMAIN), 1);
        
        $body .= BABE_html_emails::email_get_row_content($customer_html);
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_new_order', $body, $order_id);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        $attachments = apply_filters('babe_email_new_order_attachments', array(), $order_id);
        
        self::send_email($email_to, esc_html(sprintf(BABE_Settings::$settings['email_new_order_subject'], BABE_Order::get_order_number($order_id))), $body, '', '', array(), $attachments);
        
        }
        
        return;
        
     }
     
////////////////////////
     /**
	 * Send customer email with payment instructions
     * @param int $order_id
     * @return
	 */
     public static function send_email_new_order_to_pay($order_id){
        
        $order_items_html = BABE_html::order_items($order_id);
        
        $customer_html = BABE_html::order_customer_details($order_id);
                
        $customer_details = self::get_customer_details($order_id);
        
        if ($customer_details['email']){
        
        $prepaid_amount = BABE_Currency::get_currency_price(BABE_Order::get_order_prepaid_amount($order_id));
        
        $email_to = $customer_details['email'];
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_new_order_to_pay_title'] );
        
        $body .= BABE_html_emails::email_get_row_content(sprintf( BABE_Settings::$settings['email_new_order_to_pay_message'], $customer_details['first_name'].' '.$customer_details['last_name'], $prepaid_amount));

        $body .= BABE_html_emails::email_get_row_button(__('Pay Now!', BABE_TEXTDOMAIN), BABE_Order::get_order_payment_page($order_id));
        
        $body .= BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
        
        $body .= BABE_html_emails::email_get_row_content($order_items_html);
        
        $body .= BABE_html_emails::email_get_row_title(__('Your contacts', BABE_TEXTDOMAIN), 1);
        
        $body .= BABE_html_emails::email_get_row_content($customer_html);
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_new_order_to_pay', $body, $order_id);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        self::send_email($email_to, esc_html(sprintf(BABE_Settings::$settings['email_new_order_to_pay_subject'], BABE_Order::get_order_number($order_id))), $body);
        
        }
        
        return;
        
     }
     
////////////////////////
     /**
	 * Send customer email with rejected order
     * @param int $order_id
     * @return
	 */
     public static function send_email_order_rejected($order_id){
        
        $order_items_html = BABE_html::order_items($order_id);
                
        $customer_details = self::get_customer_details($order_id);
        
        if ($customer_details['email']){
        
        $email_to = $customer_details['email'];
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_order_rejected_title'] );
        
        $body .= BABE_html_emails::email_get_row_content(sprintf( BABE_Settings::$settings['email_order_rejected_message'], $customer_details['first_name'].' '.$customer_details['last_name']));

        $body .= BABE_html_emails::email_get_row_button(__('Search Now', BABE_TEXTDOMAIN), home_url());
        
        $body .= BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
        
        $body .= BABE_html_emails::email_get_row_content($order_items_html);
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_order_rejected', $body, $order_id);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        self::send_email($email_to, esc_html( BABE_Settings::$settings['email_order_rejected_subject'] ), $body);
        
        }
        
        return;
        
     }     
                                 
///////////send_email_new_customer_created/////////////
     /**
	 * Send new customer email with login/password
     * @param int $customer_id
     * @param array $new_customer_data
     * @param boolean $password_generated
     * @return
	 */
     public static function send_email_new_customer_created($customer_id, $new_customer_data, $password_generated){
        
        $email_to = $new_customer_data['user_email'];
        
        $customer_details = array(
            __('Login:', BABE_TEXTDOMAIN) => $new_customer_data['user_login'],
            __('Password:', BABE_TEXTDOMAIN) => $new_customer_data['user_pass'],
        );
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_new_customer_created_title'] );
        
        $body .= BABE_html_emails::email_get_row_content(sprintf( BABE_Settings::$settings['email_new_customer_created_message'], $new_customer_data['first_name'].' '.$new_customer_data['last_name']));

        $body .= BABE_html_emails::email_get_row_content(BABE_html_emails::email_array_wrapper($customer_details));

        $body .= BABE_html_emails::email_get_row_button(__('My Account', BABE_TEXTDOMAIN), BABE_Settings::get_my_account_page_url());
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_new_customer_created', $body, $customer_id, $new_customer_data);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        self::send_email($email_to, esc_html(BABE_Settings::$settings['email_new_customer_created_subject']), $body);
        
        return;
        
     }
     
///////////send_email_password_reseted/////////////
     /**
	 * Send customer email with reseted login/password
     * @param obj $user - WP_User
     * @param string $password
     * @return
	 */
     public static function send_email_password_reseted($user, $password){
        
        $email_to = $user->user_email;
        
        $customer_details = array(
            __('Login:', BABE_TEXTDOMAIN) => $user->user_login,
            __('Password:', BABE_TEXTDOMAIN) => $password,
        );
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_password_reseted_title'] );
        
        $body .= BABE_html_emails::email_get_row_content(sprintf( BABE_Settings::$settings['email_password_reseted_message'], $user->first_name.' '.$user->last_name));

        $body .= BABE_html_emails::email_get_row_content(BABE_html_emails::email_array_wrapper($customer_details));

        $body .= BABE_html_emails::email_get_row_button(__('My Account', BABE_TEXTDOMAIN), BABE_Settings::get_my_account_page_url());
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_password_reseted', $body, $user, $password);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        self::send_email($email_to, esc_html(BABE_Settings::$settings['email_password_reseted_subject']), $body);
        
        return;
        
     }
     
////////////////////////
     /**
	 * Send customer email order canceled
     * @param int $order_id
     * @return
	 */
     public static function send_email_order_canceled($order_id){
        
        $order_items_html = BABE_html::order_items($order_id);
                
        $customer_details = self::get_customer_details($order_id);
        
        if ($customer_details['email']){
        
        $email_to = $customer_details['email'];
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_order_canceled_title'] );
        
        $body .= BABE_html_emails::email_get_row_content(sprintf( BABE_Settings::$settings['email_order_canceled_message'], $customer_details['first_name'].' '.$customer_details['last_name']));
        
        $body .= BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
        
        $body .= BABE_html_emails::email_get_row_content($order_items_html);
        
        /////////////////////////////
        
        $body = apply_filters('babe_email_body_order_canceled', $body, $order_id);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        $attachments = apply_filters('babe_email_order_canceled_attachments', array(), $order_id);
        
        self::send_email($email_to, esc_html(BABE_Settings::$settings['email_order_canceled_subject']), $body, '', '', array(), $attachments);
        
        }
        
        return;
        
     }
     
////////////////////////
     /**
	 * Send admin email order canceled
     * 
     * @param int $order_id
     * @return
	 */
     public static function send_admin_email_order_canceled($order_id){

         $email_to = self::get_manager_email($order_id);

         if ( empty($email_to) ){
             return;
         }
        
        $order_items_html = BABE_html::order_items($order_id);
        
        //////Make email body////////
        
        $body = BABE_html_emails::email_get_row_header_image();
        
        $body .= BABE_html_emails::email_get_row_title( BABE_Settings::$settings['email_admin_order_canceled_title'] );
        
        $body .= BABE_html_emails::email_get_row_content( BABE_Settings::$settings['email_admin_order_canceled_message'] );
        
        $body .= BABE_html_emails::email_get_row_title(__('Order #', BABE_TEXTDOMAIN).BABE_Order::get_order_number($order_id), 1);
        
        $body .= BABE_html_emails::email_get_row_content($order_items_html);
        
        /////////////////////////////
        
        $body = apply_filters('babe_admin_email_body_order_canceled', $body, $order_id);
        
        $body = BABE_html_emails::email_body_wrap($body);
        
        $attachments = apply_filters('babe_admin_email_order_canceled_attachments', array(), $order_id);
        
        self::send_email($email_to, esc_html(sprintf(BABE_Settings::$settings['email_admin_order_canceled_subject'], BABE_Order::get_order_number($order_id))), $body, '', '', array(), $attachments);
        
        return;
        
     }               
         
////////////////////////
     /**
	 * Send html email
     * @param string $email
     * @param string $subject
     * @param string $body - html
     * @param array $headers
     * @param array $attachments
     * @return
	 */
     public static function send_email($email, $subject, $body, $headers = array(), $attachments = array()){
        
        add_filter( 'wp_mail_content_type', array(__CLASS__, 'set_html_mail_content_type') );
        
        add_filter( 'wp_mail_from_name', array(__CLASS__, 'set_mail_from_name') );
        
        add_filter( 'wp_mail_from', array(__CLASS__, 'set_mail_from_email') );
        
        ////// do email
        
        $body = self::inline_css($body);

        wp_mail( $email, $subject, $body, $headers, $attachments);
        
        remove_filter( 'wp_mail_content_type', array(__CLASS__, 'set_html_mail_content_type') );
        
        remove_filter( 'wp_mail_from_name', array(__CLASS__, 'set_mail_from_name') );
        
        remove_filter( 'wp_mail_from', array(__CLASS__, 'set_mail_from_email') );
        
        return;
        
     }
     
/////////////////////
     /**
	 * Filters the email address to send from.
	 *
	 * @param string $from_email
	 * @return string
	 */
	public static function set_mail_from_email( $from_email ) {
		$email_from_address = isset(BABE_Settings::$settings['email_from_address']) && BABE_Settings::$settings['email_from_address'] ? sanitize_email(BABE_Settings::$settings['email_from_address']) : $from_email;
        
		return $email_from_address;
	}
   
/////////////////////
     /**
	 * Filters the name to associate with the "from" email address.
	 *
	 * @param string $from_name
	 * @return string
	 */
	public static function set_mail_from_name( $from_name ) {
		$email_from_name = $from_name == 'WordPress' ? (isset(BABE_Settings::$settings['email_from_name']) && BABE_Settings::$settings['email_from_name'] ? BABE_Settings::$settings['email_from_name'] : get_bloginfo( 'name' )) : $from_name;
        
        $email_from_name = wp_specialchars_decode( esc_html( $email_from_name ), ENT_QUOTES );
		return $email_from_name;
	}          
     
/////////////////////
     /**
	 * Inline CSS to html email content.
	 *
	 * @param string $content
	 * @return string
	 */
	public static function inline_css( $content = '' ) {
		if ( class_exists( 'DOMDocument' ) ) {
			ob_start();
			BABE_Functions::get_template( 'emails/email-styles.php' );
			$css = apply_filters( 'babe_email_styles', ob_get_clean() );

			$emogrifier = new Emogrifier( $content, $css );
			$content    = $emogrifier->emogrify();
		}
		return $content;
	}                                
        
////////////////////    
}

BABE_Emails::init(); 
