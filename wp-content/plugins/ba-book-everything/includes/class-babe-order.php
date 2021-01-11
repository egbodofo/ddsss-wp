<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Order Class.
 * Get general settings
 * @class 		BABE_Order
 * @version		1.3.0
 * @author 		Booking Algorithms
 */

class BABE_Order {
    
    static $order_statuses = [];
    
    static $get_posts_count = 0;
    static $get_posts_pages = 0;
    
    // DB tables
    static $table_order_items;
    
    static $table_order_itemmeta;
    
    ///// cache
    
    private static $order_dates = [];
    
    private static $order_item_dates = [];
    
    private static $order_item_meta = [];
    
    private static $order_items = [];
    
    private static $order_meta = [];
    
    private static $order_prices = [];
    
//////////////////////////////
    /**
	 * Hook in tabs.
	 */
    public static function init() {
        
        global $wpdb;
        self::$table_order_itemmeta = $wpdb->prefix.'babe_order_itemmeta';
        self::$table_order_items = $wpdb->prefix.'babe_order_items';
        
        self::$order_statuses = array(
          'draft' => __( 'draft', BABE_TEXTDOMAIN ),
          'av_confirmation' => __( 'availability confirmation', BABE_TEXTDOMAIN ),
          'not_available' => __( 'not available', BABE_TEXTDOMAIN ),
          'payment_deferred' => __( 'payment deferred', BABE_TEXTDOMAIN ),
          'payment_expected' => __( 'payment expected', BABE_TEXTDOMAIN ),
          'payment_processing' => __( 'payment processing', BABE_TEXTDOMAIN ),
          'payment_received' => __( 'payment received', BABE_TEXTDOMAIN ),
          'canceled' => __( 'canceled', BABE_TEXTDOMAIN ),
          'completed' => __( 'completed', BABE_TEXTDOMAIN ),
        );
        
        add_filter('wp_insert_post_data', array( __CLASS__, 'change_order_title' ), 99, 2);
        add_action('wp_insert_post', array( __CLASS__, 'update_order_hash' ), 10, 3);
        
        add_action( 'update_post_meta', array( __CLASS__, 'wp_update_order_meta' ), 10, 4);
        add_filter( 'update_post_metadata', array( __CLASS__, 'wp_update_order_meta_check' ), 10, 5);
        
        add_action( 'template_redirect', array( __CLASS__, 'action_to_services'));
        add_action( 'template_redirect', array( __CLASS__, 'action_to_checkout'));
        add_action( 'template_redirect', array( __CLASS__, 'action_to_pay'));
        
        add_action( 'wp_trash_post', array( __CLASS__, 'trash_order_post'));
        //add_action( 'untrash_post', array( __CLASS__, 'untrash_order_post'));
        add_action( 'before_delete_post', array( __CLASS__, 'delete_order_post'));
        
        add_filter( 'babe_services_content', array( __CLASS__, 'services_page_prepare' ), 10);
        add_filter( 'babe_checkout_content', array( __CLASS__, 'checkout_page_prepare' ), 10);
        add_filter( 'babe_admin_confirmation_content', array( __CLASS__, 'action_to_admin_confirm' ), 10);
        add_filter( 'babe_confirmation_content', array( __CLASS__, 'confirm_page_prepare' ), 10);
        
        add_action( 'babe_order_to_av_confirm', array( __CLASS__, 'action_order_to_av_confirm' ), 10, 2);
        
        //add_action( 'babe_order_completed', array( __CLASS__, 'action_order_completed' ), 10);
        
	}
    
///////////////////////
     /**
	 * Change order title
     * @param array $data
     * @param array $postarr
     * @return array
	 */
    public static function change_order_title($data, $postarr){
      if ($data['post_type'] == BABE_Post_types::$order_post_type) {
        
      // If it is our form has not been submitted, so we dont want to do anything
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $data;
        
        $data['post_title'] = isset($postarr['_order_number']) ? $postarr['_order_number'] : $data['post_title'];
        
        $data['post_name'] = sanitize_title($data['post_title']);
      }
        return $data; 
    }    

///////////////////////
     /**
	 * Generate unique order number
     * @return string
	 */
    public static function generate_order_num(){
        
        $date_now_obj = BABE_Functions::datetime_local();
        
        $output = $date_now_obj->format('ymd-His').mt_rand(100, 999);
        $output = apply_filters('babe_generate_order_num', $output);
        
        return $output; 
    }
    
///////////////////////
     /**
	 * Generate unique order hash
     * @param string $id
     * @return string
	 */
    public static function generate_order_hash($id){
        $output = hash( 'sha256', uniqid($id, true));
        $output = apply_filters('babe_generate_order_hash', $output, $id);
        
        return $output; 
    }    
    
//////////////////////////////////////                       
     /**
	 * Update order hash
     * @param int $post_id
     * @param obj $post
     * @param boolean $update
	 */
    public static function update_order_hash( $post_id, $post, $update ) {

       // If this isn't a 'booking' post, don't update it.
       if ( BABE_Post_types::$order_post_type != $post->post_type ) {
          return;
       }
       
       if (!get_post_meta($post_id, '_order_hash', 1)){
         $hash = self::generate_order_hash($post_id);
         update_post_meta($post_id, '_order_hash', $hash);
         
         $admin_hash = self::generate_order_hash($post_id.'_admin');
         update_post_meta($post_id, '_order_admin_hash', $admin_hash);
       }
       
       unset(self::$order_meta[$post_id]);

    }
    
//////////////////////////////////////                       
     /**
	 * Get order hash
     * @param int $order_id
     * @return string
	 */
    public static function get_order_hash( $order_id ) {

       return get_post_meta($order_id, '_order_hash', 1);

    }
    
//////////////////////////////////////                       
     /**
	 * Get order admin hash
     * @param int $order_id
     * @return string
	 */
    public static function get_order_admin_hash( $order_id ) {

       return get_post_meta($order_id, '_order_admin_hash', 1);

    }    
    
//////////////////////////////////////                       
     /**
	 * Get order currency
     * @param int $order_id
     * @return string
	 */
    public static function get_order_currency( $order_id ) {

       return get_post_meta($order_id, '_order_currency', 1);

    }
    
//////////////////////////////////////                       
     /**
	 * Get order customer email
     * @param int $order_id
     * @return string
	 */
    public static function get_order_customer_email( $order_id ) {

       return get_post_meta($order_id, 'email', 1);

    }
    
//////////////////////////////////////                       
     /**
	 * Get order customer details
     * @param int $order_id
     * @return array
	 */
    public static function get_order_customer_details( $order_id ) {

       $output = self::get_order_meta($order_id);
       
       $output = self::clear_order_meta($output);
       
       return $output;

    }            
    
//////////////////////////////////////                       
     /**
	 * Get order customer
     * @param int $order_id
     * @return int
	 */
    public static function get_order_customer( $order_id ) {

       return absint(get_post_meta($order_id, '_customer_user', 1));

    }
    
//////////////////////////////////////                       
     /**
	 * Update order customer
     * @param int $order_id
     * @param int $customer_id
     * @return int
	 */
    public static function update_order_customer( $order_id, $customer_id ) {
        
       update_post_meta($order_id, '_customer_user', $customer_id);
       
       unset(self::$order_meta[$order_id]);

       return;

    }
    
//////////////////////////////////////                       
     /**
	 * Update order refunded amount
     * 
     * @param int $order_id
     * @param float $amount
     * 
     * @return int
	 */
    public static function update_order_refunded_amount( $order_id, $amount ) {
       
       $amount = (float)$amount + (float)get_post_meta($order_id, '_refunded_amount', 1);
        
       update_post_meta($order_id, '_refunded_amount', $amount);
       
       unset(self::$order_meta[$order_id]);

       return;

    }             
    
//////////////////////////////////////                       
     /**
	 * Get order status
     * @param int $order_id
     * @return string
	 */
    public static function get_order_status( $order_id ) {

       return get_post_meta($order_id, '_status', 1);

    }    
    
//////////////////////////////////////                       
     /**
	 * Get order number
     * @param int $order_id
     * @return string
	 */
    public static function get_order_number( $order_id ) {

       return get_post_meta($order_id, '_order_number', 1);

    }
    
////////////////////////
     /**
	 * Get order total amount
     * @param int $order_id
     * @return float
	 */
     public static function get_order_total_amount($order_id){

        return (float)get_post_meta($order_id, '_total_amount', 1);
        
     }
     
////////////////////////
     /**
	 * Get order prepaid amount
     * @param int $order_id
     * @return float
	 */
     public static function get_order_prepaid_amount($order_id){

        return (float)get_post_meta($order_id, '_prepaid_amount', 1);
        
     }

//////////////////////////////////////                       
     /**
	 * Update order prepaid amount
     * 
     * @param int $order_id
     * @param float $amount
     * 
     * @return int
	 */
    public static function update_order_prepaid_amount( $order_id, $amount ) {
       
       $amount = (float)$amount;
        
       update_post_meta($order_id, '_prepaid_amount', $amount);
       
       unset(self::$order_meta[$order_id]);

       return;

    }
         
////////////////////////
     /**
	 * Get order prepaid received
     * @param int $order_id
     * @return float
	 */
     public static function get_order_prepaid_received($order_id){

        return (float)get_post_meta($order_id, '_prepaid_received', 1);
        
     }
     
//////////     
     /**
	 * Get order prepaid received
     * @param int $order_id
     * @return float
	 */
     public static function get_order_refunded_amount($order_id){

        return (float)get_post_meta($order_id, '_refunded_amount', 1);
        
     }
     
//////////////////////////////////////                       
     /**
	 * Update order prepaid received
     * 
     * @param int $order_id
     * @param float $amount
     * 
     * @return int
	 */
    public static function update_order_prepaid_received( $order_id, $amount ) {
       
       $amount = (float)$amount + (float)get_post_meta($order_id, '_prepaid_received', 1);
        
       update_post_meta($order_id, '_prepaid_received', $amount);
       
       unset(self::$order_meta[$order_id]);

       return;

    }
    
////////////////////////
     /**
	 * Get order coupon num
     * @param int $order_id
     * @return float
	 */
     public static function get_order_coupon_num($order_id){

        return get_post_meta($order_id, '_coupon_num', 1);
        
     }
     
////////////////////////
     /**
	 * Get order coupon amount applied
     * @param int $order_id
     * @return float
	 */
     public static function get_order_coupon_amount_applied($order_id){

        return (float)get_post_meta($order_id, '_coupon_amount_applied', 1);
        
     }              
     
////////////////////////
     /**
	 * Get order payment method
     * @param int $order_id
     * @return float
	 */
     public static function get_order_payment_method($order_id){

        return get_post_meta($order_id, '_payment_method', 1);
        
     }
     
////////////////////////
     /**
	 * Get order payment token id
     * 
     * @param int $order_id
     * 
     * @return int
	 */
     public static function get_order_payment_token_id($order_id){

        return absint(get_post_meta($order_id, '_payment_token_id', 1));
        
     }               
     
////////////////////////
     /**
	 * Get order payment model
     * @param int $order_id
     * @return float
	 */
     public static function get_order_payment_model($order_id){

        return get_post_meta($order_id, '_payment_model', 1);
        
     }
     
////////////////////////
     /**
	 * Get all customer orders
     * @param int $customer_id
     * @return array
	 */
     public static function get_customer_orders($customer_id){
        global $wpdb;     
        ///// create query
        
        $query = "SELECT * 
        FROM ".$wpdb->posts." posts
         
        INNER JOIN #get _customer_user
        (
        SELECT CAST(meta_value AS UNSIGNED) AS customer_user, post_id AS pm_post_id 
        FROM ".$wpdb->postmeta."
        WHERE meta_key = '_customer_user'
        ) pm ON posts.ID = pm.pm_post_id
        
        WHERE (
          (posts.post_status = 'publish'
          AND
           posts.post_type = '".BABE_Post_types::$order_post_type."')
           AND pm.customer_user = ".$customer_id."
        )
        
        ORDER BY posts.post_date DESC
        ";
        
        // run main query
        $output = $wpdb->get_results($query, ARRAY_A);
             
        return $output;
     }
     
////////////////////////
     /**
	 * Get order id by meta
     * 
     * @param string $meta_key
     * @param string $meta_value
     * 
     * @return int
	 */
     public static function get_order_id_by_meta($meta_key, $meta_value){
        
        global $wpdb;     
        ///// create query
        
        $query = "SELECT * 
        FROM ".$wpdb->posts." posts
         
        INNER JOIN
        (
        SELECT post_id AS pm_post_id 
        FROM ".$wpdb->postmeta."
        WHERE meta_key = '".$meta_key."' AND meta_value = '".$meta_value."'
        ) pm ON posts.ID = pm.pm_post_id
        
        WHERE (
          (posts.post_status = 'publish'
          AND
           posts.post_type = '".BABE_Post_types::$order_post_type."')
        )
        
        ORDER BY posts.post_date DESC
        LIMIT 0,1
        ";
        
        // run main query
        $result_arr = $wpdb->get_results($query, ARRAY_A);
        
        $output = !empty($result_arr) && isset($result_arr[0]['ID']) ? (int)$result_arr[0]['ID'] : 0;
             
        return $output;
     }     
     
////////////////////////
     /**
	 * Get all orders by page
     * 
     * @return array
	 */
     public static function get_all_orders(){
        global $wpdb;     
        ///// create query
        
        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
        $posts_per_page = (int)BABE_Settings::$settings['results_per_page'];
        $posts_per_page = $posts_per_page < 1 ? -1 : $posts_per_page;
        $offset = max(0, $paged - 1)*$posts_per_page;
        
        $limit_clauses = $posts_per_page == -1 ? "" : "
        LIMIT ".$offset.", ".$posts_per_page."   
";
        
        $query = "SELECT * 
        FROM ".$wpdb->posts." posts
        
        WHERE (
          (posts.post_status = 'publish'
          AND
           posts.post_type = '".BABE_Post_types::$order_post_type."')
        )
        
        GROUP BY posts.ID
        ORDER BY posts.post_date DESC
        ";
        
        $query = apply_filters('babe_get_all_orders_query', $query);
        
        // run main query
        $output = $wpdb->get_results($query.$limit_clauses, ARRAY_A);
        
        // run count query
        self::$get_posts_count = $wpdb->get_var("SELECT COUNT(ID) AS total_count FROM (".$query.") AS a");
        
        self::$get_posts_pages = $posts_per_page == -1 ? 1 : ceil(self::$get_posts_count/$posts_per_page);
             
        return $output;
     }                                
    
//////////////////////
     /**
	 * Create order draft
     * @return int $post_id
	 */
    public static function create_order_draft() {
        
       $order_number = self::generate_order_num(); 

       $post_id = wp_insert_post(array (
         'post_type' => BABE_Post_types::$order_post_type,
         'post_title' => $order_number,
         'post_content' => '',
         'post_status' => 'draft',
         'comment_status' => 'closed',
         'post_author'   => 1,
         'meta_input'   => array(
           '_order_number' => $order_number,
           '_order_currency' => BABE_Currency::get_currency(),
           '_status' => 'draft',
           '_customer_user' => 0,
         ),
       ));
       
       return $post_id;

    }
    
//////////////////////
     /**
	 * Fires immediately before updating metadata of a specific type.
     *
     * @param int    $meta_id    ID of the metadata entry to update.
     * @param int    $post_id  Object ID.
     * @param string $meta_key   Meta key.
     * @param mixed  $meta_value Meta value.
	 */
    public static function wp_update_order_meta($meta_id, $post_id, $meta_key, $meta_value) {
       
       if ( BABE_Post_types::$order_post_type == get_post_type($post_id) && $meta_key == '_status'){
        
          $old_status = self::get_order_status($post_id);
          
          if ('av_confirmation' == $old_status && $meta_value == 'not_available'){    
                BABE_Emails::send_email_order_rejected($post_id); 
          }
          
          if ('draft' == $old_status && 'av_confirmation' == $meta_value){ 
             BABE_Emails::send_admin_email_new_order_av_confirm($post_id);
             BABE_Emails::send_email_new_order_av_confirm($post_id);  
          }
          
          if ( ('payment_deferred' != $old_status && 'payment_received' != $old_status && 'completed' != $old_status) && 'payment_deferred' == $meta_value){
            
            if ( !get_post_meta($post_id, '_email_new_order', 1) ){
               BABE_Emails::send_admin_email_new_order($post_id);
               BABE_Emails::send_email_new_order($post_id);
               update_post_meta($post_id, '_email_new_order', 1);
            }
          }
          
          if ( 'payment_deferred' != $old_status && 'payment_received' == $meta_value){
             BABE_Emails::send_admin_email_new_order($post_id);
             BABE_Emails::send_email_new_order($post_id);
             //ToDo diff email for received payment?
          }
          
          if ($meta_value != $old_status && 'canceled' == $meta_value){
              self::order_trash($post_id);
              do_action('babe_order_canceled', $post_id);
          }

           //ToDo email for completed order?
          
          if ( ('payment_expected' != $old_status && 'draft' != $old_status) && 'payment_expected' == $meta_value){
            BABE_Emails::send_email_new_order_to_pay($post_id);
          }
          
       }
       
       return;

    }
    
//////////////////////
     /**
     * Filters whether to update metadata of a specific type.
     *
     * The dynamic portion of the hook, `$meta_type`, refers to the meta
     * object type (comment, post, or user). Returning a non-null value
     * will effectively short-circuit the function.
     *
     * @since 3.1.0
     *
     * @param null|bool $check      Whether to allow updating metadata for the given type.
     * @param int       $post_id  Object ID.
     * @param string    $meta_key   Meta key.
     * @param mixed     $meta_value Meta value. Must be serializable if non-scalar.
     * @param mixed     $prev_value Optional. If specified, only update existing
     *                              metadata entries with the specified value.
     *                              Otherwise, update all entries.
     */
    public static function wp_update_order_meta_check($check, $post_id, $meta_key, $meta_value, $prev_value) {
       
       if ( BABE_Post_types::$order_post_type == get_post_type($post_id) && $meta_key == '_status'){
        
          $old_status = self::get_order_status($post_id);
          
          if ($old_status == 'canceled'){
              $check = false; 
          }
       }
       
       return $check;

    }        
    
//////////////////////
     /**
	 * Update order status
     * @param int $post_id
     * @param string $status
     * @return boolean
	 */
    public static function update_order_status($post_id, $status) {
       $output = false; 
       $post_id = absint($post_id);
        
       if (is_string($status) && isset(self::$order_statuses[$status])){
          $old_status = self::get_order_status($post_id);
          update_post_meta($post_id, '_status', $status);
          unset(self::$order_meta[$post_id]);
          
          do_action('babe_order_status_updated', $post_id, $status, $old_status);
          $output = true;
       }
       
       return $output;

    }
    
////////////////////////
     /**
	 * Update order item
     * @param int $order_id
     * @param array $item_arr
     * @return int
	 */
     public static function update_order_item($order_id, $item_arr){
        
        global $wpdb;
        
        $output = 0;
        
        $order_id = absint($order_id);
        
        $item_arr = wp_parse_args( $item_arr, array(
            'order_item_id' => 0,
            'order_item_name' => '',
            'booking_obj_id' => 0,
            'meta' => array(), 
        ));
        
        if ($order_id && $item_arr['booking_obj_id'] && !empty($item_arr['meta'])){
            
         $item_arr['order_item_name'] = $item_arr['order_item_name'] ? $item_arr['order_item_name'] : get_the_title($item_arr['booking_obj_id']); 
         
         $item_arr['order_item_id'] = absint($item_arr['order_item_id']);
         $item_arr['booking_obj_id'] = absint($item_arr['booking_obj_id']);
            
         $items = $wpdb->get_results("SELECT * FROM ".self::$table_order_items." WHERE order_item_id = '".$item_arr['order_item_id']."'", ARRAY_A);
         
         if (!empty($items)){
            //// update row by order_item_id
            $wpdb->query( "UPDATE ".self::$table_order_items." SET booking_obj_id = ".$item_arr['booking_obj_id'].", order_item_name = '".$item_arr['order_item_name']."', order_id = ".$order_id." WHERE order_item_id = ".$item_arr['order_item_id'] );

        } else {
            //// create row
            $wpdb->insert(
                   self::$table_order_items,
                     array(
                       'booking_obj_id' => $item_arr['booking_obj_id'],
                       'order_id' => $order_id,
                       'order_item_name' => $item_arr['order_item_name'],
                     )
            );
            $item_arr['order_item_id'] = (int)$wpdb->insert_id;
        }
        
        if ($item_arr['order_item_id']){
        
        ////update_av_guests
        $meta = wp_parse_args( $item_arr['meta'], array(
            'date_from' => '',
            'date_to' => '',
            'guests' => array(),
        ));
        $meta['date_to'] = $meta['date_to'] ? $meta['date_to'] : $meta['date_from'];
        
        if ($meta['date_from'] && !empty($meta['guests'])){   
            
            //// clear old guests if we are updating order_item 
            self::update_av_guests_on_delete($item_arr['order_item_id'], $item_arr['booking_obj_id']);
            
            $new_guests = array_sum($meta['guests']);
            BABE_Calendar_functions::update_av_guests($item_arr['booking_obj_id'], $meta['date_from'], $meta['date_to'], $new_guests);
        }
        ////////
        
        foreach ($item_arr['meta'] as $meta_key => $meta_value){
            self::update_order_item_meta($item_arr['order_item_id'], $meta_key, $meta_value);
        }
        
        self::$order_items = array();
        
        $output = 1;
        
        } /// end if $item_arr['order_item_id'])
        
        } //// end if $order_id
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Update av guests on order trash/delete
     * @param int $order_item_id
     * @param int $booking_obj_id
     * @param int $multiplier 1 to add, -1 to substract 
     * @return int
	 */
     public static function update_av_guests_on_delete($order_item_id, $booking_obj_id, $multiplier = -1){
        
        $meta = self::get_order_item_meta($order_item_id);
        $meta = wp_parse_args( $meta, array(
              'date_from' => '',
              'date_to' => '',
              'guests' => array()
            ));
            
        $meta['date_to'] = $meta['date_to'] ? $meta['date_to'] : $meta['date_from'];
        
        if ($meta['date_from'] && !empty($meta['guests'])){
            $old_guests = array_sum( (array)$meta['guests'] );
            $new_guests = $multiplier*$old_guests;
            BABE_Calendar_functions::update_av_guests($booking_obj_id, $meta['date_from'], $meta['date_to'], $new_guests);
        }
        
     }     
     
////////////////////////
     /**
	 * Delete order item
     * 
     * @param int $order_item_id
     * @param string $order_status
     * 
     * @return int
	 */
     public static function delete_order_item($order_item_id, $order_status = ''){
        
        global $wpdb;
        
        $output = 0;
        
        $order_item_id = absint($order_item_id);
            
        $item = $wpdb->get_row("SELECT * FROM ".self::$table_order_items." WHERE order_item_id = '".$order_item_id."'", ARRAY_A);
         
         if (!empty($item)){
            ///update_av_guests 
            if ($order_status != 'canceled'){
                
                self::update_av_guests_on_delete($order_item_id, $item['booking_obj_id']);
            }
            ///// delete all order item meta
            self::delete_order_item_meta($order_item_id);
            //// delete order item
            $output = $wpdb->query( "DELETE FROM ".self::$table_order_items." WHERE order_item_id = ".$order_item_id );
            
            self::$order_items = array();
        }
          
        return $output;
        
     }
     
////////////////////////
     /**
	 * Delete order item meta
     * @param int $order_item_id
     * @param string $meta_key
     * @return int
	 */
     public static function delete_order_item_meta($order_item_id, $meta_key = ''){
        
        global $wpdb;
        
        $order_item_id = absint($order_item_id);
        
        $where_clauses = $meta_key ? " AND meta_key = '".$meta_key."'" : "";   
        
        $output = $wpdb->query( "DELETE FROM ".self::$table_order_itemmeta." WHERE order_item_id = ".$order_item_id.$where_clauses );
          
        return $output;
        
     }               
    
////////////////////////
     /**
	 * Update order item meta
     * @param int $order_item_id
     * @param string $meta_key
     * @param string $meta_value
     * @return int
	 */
     public static function update_order_item_meta($order_item_id, $meta_key, $meta_value){
        
        global $wpdb;
        
        $output = 0;
        
        $meta_value = maybe_serialize($meta_value);
        
        $order_item_id = absint($order_item_id);
        
        if (is_string($meta_key)){
        
        /// get order item meta
        $meta_arr = $wpdb->get_results("SELECT * FROM ".self::$table_order_itemmeta." WHERE order_item_id = '".$order_item_id."' AND meta_key = '".$meta_key."'", ARRAY_A);
        
        if (!empty($meta_arr)){
            //// update row by meta_id
            //$output = $wpdb->query( "UPDATE ".self::$table_order_itemmeta." SET meta_value = '".$meta_value."' WHERE meta_id = ".$meta_arr[0]['meta_id'] );
            
            $output = $wpdb->update(
              self::$table_order_itemmeta,
              array(
                 'meta_value' => $meta_value,
              ),
              array( 'meta_id' => $meta_arr[0]['meta_id'] )
            );

        } else {
            //// create row
            $wpdb->insert(
                   self::$table_order_itemmeta,
                     array(
                       'order_item_id' => $order_item_id,
                       'meta_key' => $meta_key,
                       'meta_value' => $meta_value,
                     )
            );
            $output = (int)$wpdb->insert_id;
        }
        
        }
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Get order item dates
     * @param int $order_item_id
     * @return array
	 */
     public static function get_order_item_dates($order_item_id){
        
        $output = array();
        
        if (isset(self::$order_item_dates[$order_item_id])){
            
            return self::$order_item_dates[$order_item_id];
            
        }
        
        $meta = self::get_order_item_meta($order_item_id);
        
        $meta = wp_parse_args( $meta, array(
            'date_from' => '',
            'date_to' => '',
        ));
        
        $output['date_from'] = $meta['date_from'];
        $output['date_to'] = $meta['date_to'];
        
        self::$order_item_dates[$order_item_id] = $output;
        
        return $output;
     }   
     
////////////////////////
     /**
	 * Get order item meta
     * @param int $order_item_id
     * @param string $meta_key
     * @return mixed string or array
	 */
     public static function get_order_item_meta($order_item_id, $meta_key = ''){
        
        global $wpdb;
        
        $order_item_id = absint($order_item_id);
        
        if (is_string($meta_key)){
            
            $output = array();
        
            /// get order item meta
            if (isset(self::$order_item_meta[$order_item_id])){
            
              $output = self::$order_item_meta[$order_item_id];
            
            } else {
              
              $meta_arr = $wpdb->get_results("SELECT * FROM ".self::$table_order_itemmeta." WHERE order_item_id = '".$order_item_id."'", ARRAY_A);
        
              if (!empty($meta_arr)){
                foreach($meta_arr as $meta){
                  $output[$meta['meta_key']] = maybe_unserialize($meta['meta_value']);
                }
                
                self::$order_item_meta[$order_item_id] = $output;
              }
            }
            
            return $meta_key ? ( isset($output[$meta_key]) ? $output[$meta_key] : '') : $output;
        
        }
        
        return '';
        
     }
     
////////////////////////
     /**
	 * Get order items with meta
     * @param int $order_id
     * @return array
	 */
     public static function get_order_items($order_id){
        
        global $wpdb;
        
        $output = array();
        
        $order_id = absint($order_id);
        
        if (isset(self::$order_items[$order_id])){
            
            return self::$order_items[$order_id];
            
        }
        
        $query = "SELECT * 
        FROM ".self::$table_order_items." post
        
        LEFT JOIN #get itemmeta
        (
        SELECT * 
        FROM ".self::$table_order_itemmeta."
        ) itemmeta ON post.order_item_id = itemmeta.order_item_id
        
        WHERE (
          post.order_id = ".$order_id."
        )

        ORDER BY post.order_item_id, itemmeta.meta_key ASC  
";
        /////
     
        $results = $wpdb->get_results($query, ARRAY_A);
        $before_order_item_id = 0;
        
        foreach($results as $result){
           if ($before_order_item_id != $result['order_item_id']){
            $before_order_item_id = $result['order_item_id'];
            $output[$result['order_item_id']]['booking_obj_id'] = $result['booking_obj_id'];
            $output[$result['order_item_id']]['order_item_name'] = $result['order_item_name'];
           }
            
           $output[$result['order_item_id']]['meta'][$result['meta_key']] = maybe_unserialize($result['meta_value']);     
            
        }
        
        self::$order_items[$order_id] = $output;
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Get order dates
     * @param int $order_id
     * @return array
	 */
     public static function get_order_dates($order_id){
        
        global $wpdb;
        
        $output = array();
        
        $order_id = absint($order_id);
        
        $query = "SELECT * 
        FROM ".self::$table_order_items." post
        
        LEFT JOIN #get order item date from
        (
        SELECT meta_value AS date_from, order_item_id 
        FROM ".self::$table_order_itemmeta."
        WHERE meta_key = 'date_from'
        ) itemmeta1 ON post.order_item_id = itemmeta1.order_item_id
        
        LEFT JOIN #get order item date to
        (
        SELECT meta_value AS date_to, order_item_id 
        FROM ".self::$table_order_itemmeta."
        WHERE meta_key = 'date_to'
        ) itemmeta2 ON post.order_item_id = itemmeta2.order_item_id
        
        WHERE (
          post.order_id = ".$order_id."
        )

        GROUP BY post.order_item_id
        ORDER BY post.order_item_id ASC  
";
        /////
     
        $results = $wpdb->get_results($query, ARRAY_A);
        foreach($results as $result){
            $output[$result['order_item_id']] = array(
               'date_from' => $result['date_from'],
               'date_to' => $result['date_to'],
            );
        }
        
        return $output;
        
     }          
     
////////////////////////
     /**
	 * Get order prices
     * @param int $order_id
     * @return array
	 */
     public static function get_order_prices($order_id){
        
        global $wpdb;
        
        $output = array();
        
        $order_id = absint($order_id);
        
        if (isset(self::$order_prices[$order_id])){
            
            return self::$order_prices[$order_id];
            
        }
        
        $query = "SELECT * 
        FROM ".self::$table_order_items." post
        
        LEFT JOIN #get price_arr
        (
        SELECT meta_value AS price_arr, order_item_id 
        FROM ".self::$table_order_itemmeta."
        WHERE meta_key = 'price_arr'
        ) itemmeta ON post.order_item_id = itemmeta.order_item_id
        
        WHERE (
          post.order_id = ".$order_id."
        )

        GROUP BY post.order_item_id
        ORDER BY post.order_item_id ASC  
";
        /////
     
        $results = $wpdb->get_results($query, ARRAY_A);
        foreach($results as $result){
            $output[$result['order_item_id']] = maybe_unserialize($result['price_arr']);
        }
        
        self::$order_prices[$order_id] = $output;
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Update order amount
     * @param int $order_id
     * @return float - $prepaid_amount
	 */
     public static function update_order_amount($order_id){
        
        $amount = 0;
        $prepaid_amount = 0;
        $payment_model = 'full';
        
        $item_prices = self::get_order_prices($order_id);
        $all_items = self::get_order_items($order_id);
        
        foreach($item_prices as $order_item_id => $item_price_arr){
            
            $price = BABE_Prices::get_obj_total_price($all_items[$order_item_id]['booking_obj_id'], $item_price_arr);
            $amount += $price['total_with_taxes'];
            $prepaid_amount += $price['total_deposit'];
            $payment_model = $payment_model != 'deposit_full' && $price['payment_model'] != 'full' ? $price['payment_model'] : $payment_model;
        }
        
        update_post_meta($order_id, '_total_amount', $amount);
        //update_post_meta($order_id, '_prepaid_amount', $prepaid_amount);
        update_post_meta($order_id, '_payment_model', $payment_model);
        
        unset(self::$order_meta[$order_id]);
        
        return $prepaid_amount;
        
     }
     
////////////////////////
     /**
	 * Update order start and end dates
     * 
     * @param int $order_id
     * @return
	 */
     public static function update_order_start_end($order_id){
        
        $order_dates = self::get_order_dates($order_id);
        $order_start_arr = array();
        $order_end_arr = array();
        
        foreach($order_dates as $item_dates){
            $order_start_arr[] = $item_dates['date_from'];
            $order_end_arr[] = $item_dates['date_to']; 
        }
        
        usort($order_start_arr, 'BABE_Functions::compare_sql_dates_asc');
        usort($order_end_arr, 'BABE_Functions::compare_sql_dates_desc');
        
        $order_start = isset($order_start_arr[0]) ? $order_start_arr[0] : '';
        $order_end = isset($order_end_arr[0]) ? $order_end_arr[0] : '';
        
        update_post_meta($order_id, '_order_start', $order_start);
        update_post_meta($order_id, '_order_end', $order_end);
        
        unset(self::$order_meta[$order_id]);
        
        return;
        
     }          
     
////////////////////////
     /**
	 * Get order meta
     * @param int $order_id
     * @return array
	 */
     public static function get_order_meta($order_id){
        
        global $wpdb;
        
        $output = array();
        
        $order_id = absint($order_id);
        
        if (isset(self::$order_meta[$order_id])){
            
            return self::$order_meta[$order_id];
            
        }
        
        if ($order_id > 0){

          $meta = array(); 
        
          $query = "SELECT * 
          FROM ".$wpdb->postmeta." pm
          WHERE pm.post_id = ".$order_id."
          ORDER BY pm.meta_key ASC";
        
          $result = $wpdb->get_results($query, ARRAY_A);
          foreach($result as $row){
                $meta[$row['meta_key']] = maybe_unserialize($row['meta_value']);
          }
          $output = $meta;
        
        }
        
        self::$order_meta[$order_id] = $output;
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Remove meta_key starts with underscores
     * @param array $order_meta
     * @return array
	 */
     public static function clear_order_meta($order_meta){
        
        $output = array();
        
        foreach($order_meta as $meta_key => $meta_value){
             if(substr($meta_key, 0, 1) != '_'){
                $output[$meta_key] = $meta_value;
             }
        }
        
        return $output;
     }     
     
////////////////////////
     /**
	 * Delete order
     * @param int $order_id
     * @return boolean
	 */
     public static function delete_order($order_id){
        
        global $wpdb;
        
        $output = false;
        
        $order_id = absint($order_id);
            
        $items = $wpdb->get_results("SELECT * FROM ".self::$table_order_items." WHERE order_id = '".$order_id."'", ARRAY_A);
         
         if (!empty($items)){
            
            $order_status = self::get_order_status($order_id); 
            
            foreach($items as $item){
                self::delete_order_item($item['order_item_id'], $order_status);
            }
            
            self::$order_items = array();
            $output = true;
        }
          
        return $output;
        
     }
     
////////////////////////
     /**
	 * Action on wp trash post
     * @param int $order_id
     * @return
	 */
     public static function trash_order_post($order_id){
        
        $post_type = get_post_type( $order_id );
        $post_status = get_post_status( $order_id );
        if( $post_type == BABE_Post_types::$order_post_type && in_array($post_status, array('publish')) ) {
          self::update_order_status($order_id, 'canceled');
        }
    
    }
    
////////////////////////
     /**
	 * Action on untrash post
     * @param int $order_id
     * @return
	 */
     public static function untrash_order_post($order_id){
        
        $post_type = get_post_type( $order_id );
        if( $post_type == BABE_Post_types::$order_post_type ) {
          //self::order_trash($order_id, false);
        }
    
    }
    
////////////////////////
     /**
	 * Action on delete post
     * @param int $order_id
     * @return
	 */
     public static function delete_order_post($order_id){
        
        $post_type = get_post_type( $order_id );
        if( $post_type == BABE_Post_types::$order_post_type ) { 
           self::delete_order($order_id);
        }
    
    }             
     
////////////////////////
     /**
	 * Update av guests on order trash action
     * @param int $order_id
     * @param boolean $to_trash - to trash or from trash selector
     * @return
	 */
     public static function order_trash($order_id, $to_trash = true){
        
        global $wpdb;
        
        $output = false;
        
        $order_id = absint($order_id);
            
        $items = $wpdb->get_results("SELECT * FROM ".self::$table_order_items." WHERE order_id = ".$order_id, ARRAY_A);
         
         if (!empty($items)){
            
            foreach($items as $item){
                ///update_av_guests                   
                $multiplier = $to_trash ? -1 : 1;
                self::update_av_guests_on_delete($item['order_item_id'], $item['booking_obj_id'], $multiplier);
                
            }
        }
          
        return;
        
     }     
     
//////////////////////////////
    /**
	 * Sanitize vars
     * @param array $arr
     * @return array
	 */
    public static function sanitize_booking_vars($arr){
        
    $output = [];
    
    if( !empty($arr['order_id']) ){
        $output['order_id'] = absint($arr['order_id']);
    }
    
    if( !empty($arr['booking_obj_id']) ){
        $output['booking_obj_id'] = absint($arr['booking_obj_id']);
    }
    
    if( !empty($arr['booking_meeting_point']) ){
        $output['booking_meeting_point'] = absint($arr['booking_meeting_point']);
    }

    if ( !isset($arr['date_from']) ){
        $arr['date_from'] = isset($arr['booking_date_from']) ? $arr['booking_date_from'] : '';
    }

    $arr['date_from'] = sanitize_text_field($arr['date_from']);
    
    $output['date_from'] = BABE_Calendar_functions::isValidDate($arr['date_from'], BABE_Settings::$settings['date_format']) ? BABE_Calendar_functions::date_to_sql($arr['date_from']) : ''; /// now in Y-m-d format

        if ( !isset($arr['date_to']) ){
            $arr['date_to'] = isset($arr['booking_date_to']) ? $arr['booking_date_to'] : '';
        }

    $arr['date_to'] = sanitize_text_field($arr['date_to']);
    
    $output['date_to'] = BABE_Calendar_functions::isValidDate($arr['date_to'], BABE_Settings::$settings['date_format']) ? BABE_Calendar_functions::date_to_sql($arr['date_to']) : ''; /// now in Y-m-d format
    
    $output['date_to'] = !$output['date_to'] ? $output['date_from'] : $output['date_to'];
    
    if ($output['date_from'] && $output['date_to']){
      if( isset($arr['booking_time']) && $arr['booking_time'] && BABE_Calendar_functions::isValidTime($arr['booking_time'], 'H:i') ){
        $output['date_from'] .= ' '.$arr['booking_time'];
        $output['date_to'] .= ' '.$arr['booking_time'];
      } else {
        if(isset($arr['booking_time_from']) && $arr['booking_time_from'] && BABE_Calendar_functions::isValidTime($arr['booking_time_from'], 'H:i')){
          $output['date_from'] .= ' '.$arr['booking_time_from'];
          $output['booking_time_from'] = $arr['booking_time_from'];
        } else {  
          $output['booking_time_from'] = '14:00';  
          $output['date_from'] .= ' '.$output['booking_time_from']; 
        }
        
        if(isset($arr['booking_time_to']) && $arr['booking_time_to'] && BABE_Calendar_functions::isValidTime($arr['booking_time_to'], 'H:i')){
          $output['date_to'] .= ' '.$arr['booking_time_to'];
          $output['booking_time_to'] = $arr['booking_time_to'];
        } else {
            $output['booking_time_to'] = '12:00';  
            $output['date_to'] .= ' '.$output['booking_time_to'];
        }
      }
    }
    
    $output['guests'] = !empty($arr['booking_guests']) ? array_map('absint', (array)$arr['booking_guests']) : [0 => 1];
    
    $output['services'] = !empty($arr['booking_services']) ? array_map('absint', (array)$arr['booking_services']) : [];

        $output['fees'] = !empty($arr['booking_fees']) ? array_map('absint', (array)$arr['booking_fees']) : [];
    
    if ($output['booking_obj_id'] && $output['date_from'] && $output['date_to']){
        
        $date_from_obj = new DateTime($output['date_from']);
        $date_to_obj = new DateTime($output['date_to']);
        
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($output['booking_obj_id']);
        $av_cal = BABE_Calendar_functions::get_av_cal($output['booking_obj_id'], $date_from_obj->format('Y-m-d 00:00:00'), $date_to_obj->format('Y-m-d 23:59:59'));
        
        if ( !empty($av_cal) && $av_cal[$date_from_obj->format('Y-m-d')]['start_day']){
            
            if ($rules_cat['rules']['basic_booking_period'] == 'day' || $rules_cat['rules']['basic_booking_period'] == 'night'){
                $d_interval = date_diff($date_from_obj, $date_to_obj);
                $days_total = $d_interval->format('%a'); // total days
                if ( 
                ( $av_cal[$date_from_obj->format('Y-m-d')]['min_booking_period'] && $days_total < $av_cal[$date_from_obj->format('Y-m-d')]['min_booking_period'] ) 
                || 
                ( $av_cal[$date_from_obj->format('Y-m-d')]['max_booking_period'] && $days_total > $av_cal[$date_from_obj->format('Y-m-d')]['max_booking_period'] )
                ){
                    $output['booking_obj_id'] = 0;
                }
            }
            
        } else {
            $output['booking_obj_id'] = 0;
        }
    }
    
    $output = apply_filters('babe_sanitize_booking_vars', $output, $arr);
    
    return $output;
    }
    
////////////////////////
     /**
	 * Check if we have valid order data
     * @param int $order_id
     * @param string $order_num
     * @param string $order_hash
     * @return boolean
	 */
     public static function is_order_valid($order_id, $order_num, $order_hash){
        
        return self::get_order_number($order_id) == $order_num && self::get_order_hash($order_id) == $order_hash ? true : false;
        
     }
     
////////////////////////
     /**
	 * Check if we have valid order data
     * @param int $order_id
     * @param string $order_num
     * @param string $order_hash
     * @return boolean
	 */
     public static function is_order_admin_valid($order_id, $order_num, $order_admin_hash){
        
        return self::get_order_number($order_id) == $order_num && self::get_order_admin_hash($order_id) == $order_admin_hash ? true : false;
        
     }         
    
////////action_to_checkout/////////////                                          
     /**
	 * Redirect to checkout page
     * @return
	 */
     public static function action_to_checkout(){
        
        if (isset($_POST['booking_obj_id']) && BABE_Post_types::is_post_booking_obj($_POST['booking_obj_id']) && isset($_POST['action']) && $_POST['action'] == 'to_checkout'){
            
            $post_arr = $_POST;
            
            $babe_post = BABE_Post_types::get_post(absint($post_arr['booking_obj_id']));
            ///// get rules
            $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id(absint($post_arr['booking_obj_id']));
            
            if ($rules_cat['rules']['basic_booking_period'] == 'single_custom' && isset($babe_post['start_time']) && $babe_post['start_time'] && isset($babe_post['end_time']) && $babe_post['end_time']){
                
                $start_time_date_obj = DateTime::createFromFormat('H:i', $babe_post['start_time']);
                $end_time_date_obj = DateTime::createFromFormat('H:i', $babe_post['end_time']);
                $post_arr['booking_time_from'] = $start_time_date_obj->format('H:i');
                $post_arr['booking_time_to'] = $end_time_date_obj->format('H:i');
                $post_arr['booking_date_from'] = $babe_post['start_date'];
                $post_arr['booking_date_to'] = $babe_post['end_date'];
                
            }
            
            $post_arr = self::sanitize_booking_vars($post_arr);
            
            if (!empty($post_arr['guests']) && $post_arr['booking_obj_id'] && $post_arr['date_from'] && $post_arr['date_to']){
                
                $av_guests = BABE_Calendar_functions::check_booking_obj_av($post_arr['booking_obj_id'], $post_arr['date_from'], $post_arr['date_to'], $post_arr['guests']);
                
                if ($av_guests){
                    
                    $order_id = self::create_order_draft();
                    
                    $price_arr = BABE_Prices::get_obj_total_price_arr($post_arr['booking_obj_id'], $post_arr['date_from'], $post_arr['guests'], $post_arr['date_to'], $post_arr['services'], $post_arr['fees']);
                    
                    $post_arr = $post_arr + array('meta' => $post_arr);
                    $post_arr['meta']['price_arr'] = $price_arr;
                    
                    $result = self::update_order_item($order_id, $post_arr);
                    $prepaid_amount = self::update_order_amount($order_id);
                    
                    self::update_order_prepaid_amount($order_id, $prepaid_amount);
                    
                    do_action('babe_order_created', $order_id, $post_arr);
                    
                    wp_update_post(array( 'ID' => $order_id, 'post_status' => 'publish' ));
                    
                    if ($result){
                        $order_hash = self::get_order_hash($order_id);
                        $order_number = self::get_order_number($order_id);
                        $args = array(
                          'order_id' => $order_id,
                          'order_num' => $order_number,
                          'order_hash' => $order_hash,
                          'current_action' => 'to_checkout',
                        );
                        $new_url = BABE_Settings::get_checkout_page_url($args);
                        wp_safe_redirect($new_url);
                    }
                }
            }
        }
        
        return;
     }
     
////////action_to_services/////////////                                          
     /**
	 * Redirect to services page
     * @return
	 */
     public static function action_to_services(){
        
        if (isset($_POST['booking_obj_id']) && BABE_Post_types::is_post_booking_obj($_POST['booking_obj_id']) && isset($_POST['action']) && $_POST['action'] == 'to_services'){
            
            $post_arr = self::sanitize_booking_vars($_POST);
            
            if (!empty($post_arr['guests']) && $post_arr['date_from'] && $post_arr['date_to']){
                
                $av_guests = BABE_Calendar_functions::check_booking_obj_av($post_arr['booking_obj_id'], $post_arr['date_from'], $post_arr['date_to'], $post_arr['guests']);
                if ($av_guests){
                    $url_arr = $_POST;
                    unset($url_arr['action']);
                    $url_arr['current_action'] = 'to_services';
                    $new_url = BABE_Settings::get_services_page_url($url_arr);
                    wp_safe_redirect($new_url);
                }
            }
        }
        
        return;
     }     
     
////////checkout_page_prepare/////////////                                          
     /**
	 * Checkout page prepare
     * @return string
	 */
     public static function checkout_page_prepare($content){
        
        $output = $content;
        
        $args = wp_parse_args( $_GET, array(
            'order_id' => 0,
            'order_num' => '',
            'order_hash' => '',
        ));
        
        /// is order data valid
        
        $order_id = absint($args['order_id']);
        
        if (self::is_order_valid($order_id, $args['order_num'], $args['order_hash'])){
        
        /// get order meta
        $order_meta = self::get_order_meta($order_id);
        
        $args['total_amount'] = $order_meta['_total_amount'];
        $args['prepaid_amount'] = $order_meta['_prepaid_amount'];
        $args['payment_model'] = $order_meta['_payment_model'];
        $args['order_currency'] = $order_meta['_order_currency'];
        
        $order_status = $order_meta['_status'];
        
        /// clear order meta
        $order_meta = self::clear_order_meta($order_meta);
        $args['meta'] = $order_meta;
        
        if ( $order_status == 'payment_expected' || $order_status == 'draft'){
        
        if (!isset($order_meta['first_name'])){
            /// get user meta if user is logged in
            $user_info = wp_get_current_user();
            if ($user_info->ID > 0){
                
                $args['meta']['email'] = $user_info->user_email;
                $args['meta']['email_check'] = $user_info->user_email;
                $args['meta']['first_name'] = $user_info->first_name;
                $args['meta']['last_name'] = $user_info->last_name;
                
                $contacts = get_user_meta($user_info->ID, 'contacts', 1);
                if (is_array($contacts)){
                    $args['meta'] += $contacts;
                }
            }
        } else {
            $args['meta']['email_check'] = $args['meta']['email'];
        }
        
        //// select action
        if ($order_status == 'payment_expected' || ($order_status == 'draft' && BABE_Settings::$settings['order_availability_confirm'] == 'auto' )){
            $args['action'] = 'to_pay';
        } else {
            $args['action'] = 'to_av_confirm';
        }
        
        $output .= BABE_html::checkout_form($args);
        
        } //// end if payment_expected or draft
        
        } //// end if is_order_valid
        
        return $output;
     }
     
////////services_page_prepare/////////////                                          
     /**
	 * Services page prepare
     * @return string
	 */
     public static function services_page_prepare($content){
        
        $output = $content;
        
        $args = wp_parse_args( $_GET, array(
            'booking_obj_id' => 0,
        ));
        
        /// is order data valid
        
        $booking_obj_id = absint($args['booking_obj_id']);
        
        if ($booking_obj_id){
            
            $babe_post = BABE_Post_types::get_post($booking_obj_id);
            
            $output .= BABE_html::block_add_services($babe_post);
        
        }
        
        return $output;
     }     
     
////////confirm_page_prepare/////////////                                          
     /**
	 * Confirm page prepare
     * @return string
	 */
     public static function confirm_page_prepare($content){
        
        $output = $content;
        
        $args = wp_parse_args( $_GET, array(
            'order_id' => 0,
            'order_num' => '',
            'order_hash' => '',
        ));
        
        /// is order data valid
        
        $order_id = absint($args['order_id']);
        
        if ($order_id && $args['order_num'] && $args['order_hash'] && self::is_order_valid($order_id, $args['order_num'], $args['order_hash'])){
        
           $args['order_status'] = self::get_order_status($order_id);
           
           //// do actions    
           do_action('babe_order_do_before_confirm_content', $order_id, $args);
        
           if ($args['order_status'] != 'draft'){
        
             $output .= BABE_html::confirm_content($args);
        
           } //// end if not draft
        
        } //// end if is_order_valid
        
        return $output;
     }     
     
//////////////////////////////
    /**
	 * Sanitize checkout vars
     * @param array $arr
     * @return array
	 */
    public static function sanitize_checkout_vars($arr){
        
    $output = [];
    
    $output['order_id'] = isset($arr['order_id']) ? absint($arr['order_id']) : 0;
    
    $output['order_num'] = isset($arr['order_num']) ? sanitize_text_field($arr['order_num']) : '';
    
    $output['order_hash'] = isset($arr['order_hash']) ? sanitize_text_field($arr['order_hash']) : '';
    
    $output['action'] = isset($arr['action']) ? sanitize_text_field($arr['action']) : '';
    
    $output['first_name'] = isset($arr['first_name']) ? sanitize_text_field($arr['first_name']) : '';
    $output['last_name'] = isset($arr['last_name']) ? sanitize_text_field($arr['last_name']) : '';
    $output['email'] = isset($arr['email']) ? sanitize_email($arr['email']) : '';
    $output['email_check'] = isset($arr['email_check']) ? sanitize_email($arr['email_check']) : '';
    $output['phone'] = isset($arr['phone']) ? sanitize_text_field($arr['phone']) : '';

    if ( !empty($arr['extra_guests']) && is_array($arr['extra_guests']) ){

        $ages_arr = BABE_Post_types::get_ages_arr_ordered_by_id();

        $i = 0;

	    foreach ($arr['extra_guests'] as $ind => $guest_data){

	        if ( empty($guest_data) || !is_array($guest_data) ){
	            continue;
            }

	        foreach ($guest_data as $guest_data_key => $guest_data_value){

                $guest_data_key = sanitize_key($guest_data_key);

	            if ( !in_array($guest_data_key, ['first_name', 'last_name', 'age_group']) ){
                    continue;
                }

	            if ( $guest_data_key === 'age_group' ){
                    $guest_data_value = (int)$guest_data_value;
                    if ( !isset($ages_arr[$guest_data_value]) ){
                        continue;
                    }
                } else {
                    $guest_data_value = sanitize_text_field($guest_data_value);
                }

                $output['extra_guests'][$i][$guest_data_key] = $guest_data_value;
            }

            $i++;
	    }
    }

    if (isset($arr['payment']['payment_method'])){
       $output['payment']['payment_method'] = sanitize_key($arr['payment']['payment_method']);
    }
    
    $output['payment']['amount_to_pay'] = isset($arr['payment']['amount_to_pay']) && $arr['payment']['amount_to_pay'] == 'deposit' ? 'deposit' : 'full';
    
    $output['payment']['terms_check'] = !empty($arr['payment']['terms_check']) ? 'agree' : '';
    
    $output = apply_filters('babe_sanitize_checkout_vars', $output, $arr);
    
    return $output;
    }     
     
////////action_to_pay/////////////                                          
     /**
	 * Perform payment actions
     * @return
	 */
     public static function action_to_pay(){
        
        $args = wp_parse_args( $_POST, array(
            'order_id' => 0,
            'order_num' => '',
            'order_hash' => '',
            'action' => ''
        ));
        
        /// is order data valid
        
        $order_id = absint($args['order_id']);
        
        if (($args['action'] == 'to_pay' || ($args['action'] == 'to_av_confirm' && BABE_Settings::$settings['order_availability_confirm'] != 'auto')) && self::is_order_valid($order_id, $args['order_num'], $args['order_hash'])){
            
            $order_status = self::get_order_status($order_id);
            
            //// sanitize $_POST vars
            $args = self::sanitize_checkout_vars($args);
            
            $check = $args['first_name'] && $args['last_name'] && $args['email'] && $args['email'] == $args['email_check'] && $args['phone'];
            $check = apply_filters('babe_order_to_pay_ready', $check, $args);
            
            if ($check && ($order_status == 'draft' || $order_status == 'payment_expected')){ 
                
                // update order meta
                $order_meta = $args; // already sanitized
                unset($order_meta['order_id']);
                unset($order_meta['order_num']);
                unset($order_meta['order_hash']);
                unset($order_meta['action']);
                unset($order_meta['current_action']);
                unset($order_meta['email_check']);
                unset($order_meta['payment']);

                ///// check extra_guests
                $order_items = self::get_order_items($order_id);
                $order = reset($order_items);
                $ages_arr = BABE_Post_types::get_post_ages($order['meta']['booking_obj_id']);
                if ( empty($ages_arr) ){
                    unset($order_meta['extra_guests']);
                }
                /////

                $order_meta = apply_filters('babe_order_before_update_meta', $order_meta, $order_id);
                foreach($order_meta as $order_meta_key => $order_meta_value){
                    update_post_meta($order_id, $order_meta_key, $order_meta_value);
                }
                
               // create or get customer 
               $customer_id = BABE_Users::create_customer($args['email'], $order_meta);
               
               if ($customer_id){
                
                self::update_order_customer($order_id, $customer_id);

                $url_args = [
                    'order_id' => $order_id,
                    'order_num' => $args['order_num'],
                    'order_hash' => $args['order_hash'],
                    'current_action' => 'to_checkout',
                ];

	           $total_amount = BABE_Order::get_order_total_amount($order_id);
               $current_url = BABE_Settings::get_checkout_page_url($url_args);
               $url_args['current_action'] = 'to_confirm';
               $success_url = BABE_Settings::get_confirmation_page_url($url_args);

	           if ( $total_amount == 0 ){
	           	// order is free or coupon have covered full price.
		           self::update_order_status($order_id, 'payment_received');
		           do_action('babe_order_completed', $order_id);
		           wp_safe_redirect($success_url);

	           } else if ($args['action'] == 'to_pay' && isset($args['payment']['payment_method'])){
                  // update order status to payment_expected
                  if ($order_status == 'draft'){
                    self::update_order_status($order_id, 'payment_expected');
                  }

                  //// do payment actions    
                  do_action('babe_order_to_pay_by_'.$args['payment']['payment_method'], $order_id, $args, $current_url, $success_url);
               
               } elseif ($args['action'] == 'to_av_confirm' && $order_status == 'draft'){
                  // update order status to av_confirmation
                  self::update_order_status($order_id, 'av_confirmation');
                  
                  //// do av confirm actions
                  do_action('babe_order_to_av_confirm', $order_id, $args);
                  
                  wp_safe_redirect($success_url);
                  
               }
               
               } //// end if $customer_id
                
            } //// end if $check
        }
        
        return;
     }
     
////////////////////////////
    /**
	 * Get order details from url
     * 
     * @return array
	 */
    public static function get_order_from_url(){

        $output = array();
        
        $args = wp_parse_args( $_GET, array(
            'order_id' => 0,
            'order_num' => '',
            'order_hash' => '',
        ));
        
        $args['order_id'] = absint($args['order_id']);
        
        if (self::is_order_valid($args['order_id'], $args['order_num'], $args['order_hash'])){
            
            $output['order_id'] = $args['order_id'];
            $output['order_num'] = $args['order_num'];
            $output['amount'] = self::get_order_total_amount($args['order_id']);
            $output['prepaid_amount'] = self::get_order_prepaid_amount($args['order_id']);
            
        }    
        
        return $output;
     }      
     
////////////////////////////
    /**
	 * Add checkout form to page.
     * @return string
	 */
    public static function action_to_admin_confirm($content){

        $output = $content;
        
        $args = wp_parse_args( $_GET, array(
            'order_id' => 0,
            'order_num' => '',
            'order_admin_hash' => '',
            'current_action' => '',
            'action_update' => '',
            'check_update' => '',
        ));
        
        $order_id = absint($args['order_id']);
        
        if ($args['current_action'] == 'to_admin_confirm' && BABE_Settings::$settings['order_availability_confirm'] != 'auto' && self::is_order_admin_valid($order_id, $args['order_num'], $args['order_admin_hash'])){
            
            $args['order_status'] = self::get_order_status($order_id);
            
            if ($args['check_update'] && 'av_confirmation' == $args['order_status']){    
                if ($args['action_update'] == 'confirm'){
                   self::update_order_status($order_id, 'payment_expected'); 
                   $args['order_status'] = 'payment_expected'; 
                } else {
                    //not_available
                   self::update_order_status($order_id, 'not_available');
                   $args['order_status'] = 'not_available'; 
                }  
            }
            
            $output .= BABE_html::admin_order_confirm_page_content($args);
            
        }    
        
        return $output;
     }     

////action_order_to_av_confirm//////////     
    /**
	 * Do something on new order.
     * @param int $order_id
     * @return
	 */
    public static function action_order_to_av_confirm($order_id, $args) {
        
        //BABE_Emails::send_admin_email_new_order_av_confirm($order_id);
        
        //BABE_Emails::send_email_new_order_av_confirm($order_id);
        return;
    }
     
///////////////////////////////////////
    /**
	 * Do something on completed order.
     * @param int $order_id
     * @return
	 */
    public static function action_order_completed($order_id) {
        
        //BABE_Emails::send_admin_email_new_order($order_id);
        
        //BABE_Emails::send_email_new_order($order_id);
        
    }     
     
///////////////////////////////////////
    /**
	 * Get admin confirmation page url for confirm actions.
     * @param int $order_id
     * @param string $confirm_action
     * @return string
	 */
    public static function get_admin_confirmation_page($order_id, $confirm_action = 'confirm') {
        
        $order_admin_hash = self::get_order_admin_hash($order_id);
        $order_number = self::get_order_number($order_id);
        
        $args = array(
           'order_id' => $order_id,
           'order_num' => $order_number,
           'order_admin_hash' => $order_admin_hash,
           'current_action' => 'to_admin_confirm',
           'action_update' => $confirm_action,
        );
        
        return BABE_Settings::get_admin_confirmation_page_url($args);
    }
    
///////////////////////////////////////
    /**
	 * Get order page url for payment actions.
     * @param int $order_id
     * @return string
	 */
    public static function get_order_payment_page($order_id) {
        
        $order_hash = self::get_order_hash($order_id);
        $order_number = self::get_order_number($order_id);
        
        $args = array(
           'order_id' => $order_id,
           'order_num' => $order_number,
           'order_hash' => $order_hash,
           'current_action' => 'to_checkout',
        );
        
        return BABE_Settings::get_checkout_page_url($args);
    }
    
///////////////////////////////////////
    /**
	 * Get order page url for confirmation actions.
     * @param int $order_id
     * @return string
	 */
    public static function get_order_confirmation_page($order_id) {
        
        $order_hash = self::get_order_hash($order_id);
        $order_number = self::get_order_number($order_id);
        
        $args = array(
           'order_id' => $order_id,
           'order_num' => $order_number,
           'order_hash' => $order_hash,
           'current_action' => 'to_confirm',
        );
        
        return BABE_Settings::get_confirmation_page_url($args);
    }                          
       
///////////////////////////////////////
}

BABE_Order::init(); 
