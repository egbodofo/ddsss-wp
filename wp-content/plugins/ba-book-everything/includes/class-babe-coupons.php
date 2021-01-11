<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Coupons Class.
 * 
 * @class 		BABE_Coupons
 * @version		1.1.1
 * @author 		Booking Algorithms
 */

class BABE_Coupons {
    
    static $coupon_statuses = array();
    
//////////////////////////////
    /**
	 * Hook in tabs.
	 */
    public static function init() {
        
        self::$coupon_statuses = array(
          'active' => __( 'Active', BABE_TEXTDOMAIN ),
          'pending' => __( 'Pending', BABE_TEXTDOMAIN ),
          'used' => __( 'Used', BABE_TEXTDOMAIN ),
          'expired' => __( 'Expired', BABE_TEXTDOMAIN ),
        );
        
        add_filter('wp_insert_post_data', array( __CLASS__, 'change_coupon_title' ), 99, 2);
        
        add_action( 'update_post_meta', array( __CLASS__, 'wp_update_order_meta' ), 30, 4);
        
        add_action( 'delete_post', array( __CLASS__, 'delete_order_post'));
          
	}    
    
////////////////////////
     /**
	 * Restore coupon status to active on delete uncompleted order
     * 
     * @param int $order_id
     * @return
	 */
     public static function delete_order_post($order_id){
        
        $post_type = get_post_type( $order_id );
        if( $post_type == BABE_Post_types::$order_post_type ) {
             $coupon = self::get_coupon_by_order_id($order_id);
             if ($coupon){
                self::set_coupon_status($coupon->ID, 'active');
                delete_post_meta( $coupon->ID, '_order_id' );
             }
        }
        return;
    }    
    
////////////////////////
     /**
	 * Update order amount with coupon
     * 
     * @param int $order_id
     * @param string $coupon_num
     * @return boolean
	 */
     public static function update_order_amount($order_id, $coupon_num){
        
        $amount = 0;
        $prepaid_amount = 0;
        $payment_model = 'full';
        
        $coupon_before = get_post_meta($order_id, '_coupon_num', 1);
        
        /// get coupon id
        $coupon = get_page_by_title($coupon_num, 'OBJECT', BABE_Post_types::$coupon_post_type);
        
        if ($coupon && !$coupon_before && self::coupon_is_active($coupon->ID)){
        
        /// get coupon amount
        $coupon_amount_start = self::get_coupon_amount($coupon->ID, true);
        $coupon_amount = $coupon_amount_start["value"];
        
        $item_prices = BABE_Order::get_order_prices($order_id);
        $all_items = BABE_Order::get_order_items($order_id);
        
        foreach($item_prices as $order_item_id => $item_price_arr){
            
            $price = BABE_Prices::get_obj_total_price($all_items[$order_item_id]['booking_obj_id'], $item_price_arr);
            $total_with_taxes = $price['total_with_taxes'];
            $total_deposit = $price['total_deposit'];
            
            if ($coupon_amount){

            	// TODO figure cupon ammount in case of percent discount
            	if ($coupon_amount_start["type"] == 'percent') {
		            $coupon_amount = $total_with_taxes *  ( $coupon_amount / 100 );
	            }
                
                if ($coupon_amount < $total_with_taxes){
                    $total_with_taxes = $total_with_taxes - $coupon_amount;
                    $total_deposit = $total_deposit <= $total_with_taxes ? $total_deposit : $total_with_taxes;
                    $total_deposit = $item_price_arr['deposit_fixed'] ? $total_deposit : round($total_with_taxes*$item_price_arr['deposit']/100, 2);
                    
                } else {
                    $coupon_amount = $total_with_taxes;
                    $total_deposit = 0;
                    $total_with_taxes = 0; 
                }
                
            }
            
            $amount += $total_with_taxes;
            $prepaid_amount += $total_deposit;
            
            $payment_model = $payment_model != 'deposit_full' && $price['payment_model'] != 'full' ? $price['payment_model'] : $payment_model;
        }
        
        update_post_meta($order_id, '_total_amount', $amount);
        update_post_meta($order_id, '_prepaid_amount', $prepaid_amount);
        update_post_meta($order_id, '_payment_model', $payment_model);
        
        /// add meta _coupon_num & _coupon_amount
        update_post_meta($order_id, '_coupon_num', $coupon_num);
        update_post_meta($order_id, '_coupon_amount_applied', $coupon_amount);
        self::set_coupon_status($coupon->ID, 'pending');
        update_post_meta($coupon->ID, '_order_id', $order_id);
        
        }
        
        return $amount ? true : false;
        
     }    

//////////////////////
     /**
     * Check coupon as used after booking 
	 * Fires immediately before updating metadata of a specific type.
     *
     * @param int    $meta_id    ID of the metadata entry to update.
     * @param int    $post_id  Object ID.
     * @param string $meta_key   Meta key.
     * @param mixed  $meta_value Meta value.
	 */
    public static function wp_update_order_meta($meta_id, $post_id, $meta_key, $meta_value) {
       
       if ( BABE_Post_types::$order_post_type == get_post_type($post_id) && $meta_key == '_status'){
        
          $old_status = BABE_Order::get_order_status($post_id);
          
          if (('payment_expected' == $old_status || 'payment_processing' == $old_status) && ('payment_deferred' == $meta_value || 'payment_received' == $meta_value)){
             ///// check coupon as used after booking
             $coupon = self::get_coupon_by_order_id($post_id);
             if ($coupon){
                self::set_coupon_status($coupon->ID, 'used');
             }
             
          }
       }
       
       return;

    }
    
//////////////////////////////////////                       
     /**
	 * Get coupon applied to order, by order ID
     * 
     * @param int $order_id
     * @return WP_Post|string
	 */
    public static function get_coupon_by_order_id( $order_id ) {
        
        $args = array(
               'post_type' => BABE_Post_types::$coupon_post_type,
               'meta_query' => array(
                  'relation' => 'AND',
                  array(
                    'key'     => '_coupon_status',
                    'value'   => 'active',
                    'compare' => '!=',
                  ),
                  array(
                    'key'     => '_order_id',
                    'value'   => $order_id,
                    'compare' => '=',
                  ),
               ),
             );
             
         $coupons = get_posts( $args );
         
         return $coupons ? $coupons[0] : '';
        
    }        

//////////////////////////////////////                       
     /**
	 * Check coupon status for active, update if necessary
     * 
     * @param int $coupon_id
     * @return boolean
	 */
    public static function coupon_is_active( $coupon_id ) {

       $output = false;
       
       $status = self::get_coupon_status($coupon_id);
       
       if ($status == 'active'){
          
          $expiration_date = self::get_coupon_expiration_date($coupon_id, 'Y-m-d');
          $expiration_date_obj = new DateTime($expiration_date);
          $date_now_obj = BABE_Functions::datetime_local();
          if ($expiration_date_obj <= $date_now_obj){
            // update status
            self::set_coupon_status($coupon_id, 'expired');
          } else {
            $output = true;
          }
          
       }
       
       return $output;

    }
    
//////////////////////////////////////                       
     /**
	 * Get coupon amount
     * 
     * @param int $coupon_id
     * @return float
	 */
    public static function get_coupon_amount( $coupon_id, $get_type='') {
	    $percent  = floatval(get_post_meta($coupon_id, '_coupon_percent', 1));
	    if ($percent){
	    	$return = array( 'value' => $percent, 'type'=> 'percent');
	    } else {
		    $amount =  floatval(get_post_meta($coupon_id, '_coupon_amount', 1));
		    $return = array( 'value' => $amount, 'type'=> 'amount');
	    }

	    return ($get_type) ? $return : $return['value'];
    }
    
//////////////////////////////////////
     /**
	 * Get coupon number
     * 
     * @param int $coupon_id
     * @return string
	 */
    public static function get_coupon_num( $coupon_id ) {

       return get_post_meta($coupon_id, '_coupon_number', 1);

    }        
    
//////////////////////////////////////                       
     /**
	 * Get coupon status
     * 
     * @param int $coupon_id
     * @return string
	 */
    public static function get_coupon_status( $coupon_id ) {

       return get_post_meta($coupon_id, '_coupon_status', 1);

    }

//////////////////////////////////////                       
     /**
	 * Set coupon status
     * 
     * @param int $coupon_id
     * @param string $status
     * @return
	 */
    public static function set_coupon_status( $coupon_id, $status ) {

       update_post_meta($coupon_id, '_coupon_status', $status);
       return;
    }        
    
//////////////////////
     /**
	 * Create coupon
     * 
     * @return int $post_id
	 */
    public static function create_coupon($amount = 1) {
        
       $coupon_number = self::generate_coupon_num();
       $amount = abs(floatval($amount));
       
       $user_info = wp_get_current_user();
       $user_id = $user_info->ID > 0 ? $user_info->ID : 1; 

       $post_id = wp_insert_post(array (
         'post_type' => BABE_Post_types::$coupon_post_type,
         'post_title' => $coupon_number,
         'post_content' => '',
         'post_status' => 'publish',
         'comment_status' => 'closed',
         'post_author'   => $user_id,
         'meta_input'   => array(
           '_coupon_number' => $coupon_number,
           '_coupon_amount' => $amount,
           '_coupon_status' => 'active',
         ),
       ));
       
       return $post_id;

    }   
    
///////////////////////////////////////
    /**
	 * Get expiration date of the coupon
     * 
     * @param int $post_id.
     * @param string $format - PHP date format
     * @return boolean
	 */
    public static function get_coupon_expiration_date($post_id, $format = ''){
        
        $post_date = get_post_field( 'post_date', $post_id );
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $post_date);
        $add_days = self::get_coupon_expire_days();
        $d->modify('+'.$add_days.' days');
        $format = $format ? $format : BABE_Settings::$settings['date_format'];
        
        return $d->format($format); 
    }    
    
//////////////////////////////
    /**
	 * Get days after which coupons expire
     * 
     * @return int
	 */
    public static function get_coupon_expire_days(){
        return isset(BABE_Settings::$settings['coupons_expire_days']) ? absint(BABE_Settings::$settings['coupons_expire_days']) : 180;
    }
    
//////////////////////////////
    /**
	 * Are coupons active in settings?
     * 
     * @return int
	 */
    public static function coupons_active(){
        
        return isset(BABE_Settings::$settings['coupons_active']) ? absint(BABE_Settings::$settings['coupons_active']) : 0;
    
    }         
    
///////////////////////
     /**
	 * Generate unique coupon number
     * 
     * @return string
	 */
    public static function generate_coupon_num(){
        
        $output = '';
        
        do {
          $output = substr(base_convert(sha1(mt_rand(100, 99999)), 16, 36), 0, 8);
          
          $output = strtoupper($output);
        
          $args = array(
            'post_type' => BABE_Post_types::$coupon_post_type, 
            'meta_key'     => '_coupon_number',
            'meta_value'   => $output,
          );
          $coupons = get_posts( $args );
        } while (!empty($coupons));
        
        $output = apply_filters('babe_generate_coupon_num', $output);
        
        return $output; 
    }    
    
//////////////////////////////
     /**
	 * Change coupon title
     * @param array $data
     * @param array $postarr
     * @return array
	 */
    public static function change_coupon_title($data, $postarr){
      if ($data['post_type'] == BABE_Post_types::$coupon_post_type) {
        
      // If it is our form has not been submitted, so we dont want to do anything
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $data;
        
        $data['post_title'] = isset($postarr['_coupon_number']) ? $postarr['_coupon_number'] : $data['post_title'];
        
        $data['post_name'] = sanitize_title($data['post_title']);
      }
        return $data; 
    }            
            
////////////////////////////
    
}

BABE_Coupons::init();
