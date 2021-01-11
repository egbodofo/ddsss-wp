<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Order_admin Class.
 * Get general settings
 * @class 		BABE_Order_admin
 * @version		1.3.9
 * @author 		Booking Algorithms
 */

class BABE_Order_admin {
    
    private static $nonce_title = 'orders-payment-request-nonce';
    
//////////////////////////////
    /**
	 * Hook in tabs.
	 */
    public static function init() {
        
        add_filter( 'manage_'.BABE_Post_types::$order_post_type.'_posts_columns', array( __CLASS__, 'order_table_head'));
        add_action( 'manage_'.BABE_Post_types::$order_post_type.'_posts_custom_column', array( __CLASS__, 'order_table_content'), 10, 2 );

        add_filter( 'posts_where', array( __CLASS__, 'search_where' ));
        add_filter( 'posts_join', array( __CLASS__, 'search_join' ));
        add_filter( 'posts_groupby', array( __CLASS__, 'search_group_by' ));
        
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueued_assets' ) );
        
        add_action( 'wp_ajax_order_request_payment', array( __CLASS__, 'ajax_order_request_payment'));
	}
    
//////////////////////////////
    /**
	 * Enqueue assets.
	 */
    public static function enqueued_assets() {
        
     global $current_screen; 
        
     if (isset($_GET['post_type']) && $_GET['post_type'] == BABE_Post_types::$order_post_type && !empty($current_screen) && $current_screen->base == 'edit'){   
        wp_enqueue_style( 'babe-admin-orders-style', plugins_url( "css/admin/babe-admin-edit.css", BABE_PLUGIN ));
        
        wp_enqueue_script( 'babe-admin-orders-js', plugins_url( "js/admin/babe-admin-edit.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
        wp_localize_script( 'babe-admin-orders-js', 'babe_edit_lst', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce(self::$nonce_title)
         )
        );
        
        }
      
     }
     
///////////////////////////////////////    
    /**
	 * Save rate.
	 */
    public static function ajax_order_request_payment(){
        global $wpdb;
        $output = '';
        
        if (isset($_POST['prepaid_amount']) && isset($_POST['order_id']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title ) && BABE_Users::current_user_can_edit_post($_POST['order_id'])){
             
             $order_id = absint($_POST['order_id']);
             $prepaid_amount = (float)$_POST['prepaid_amount'];
             
             if ( BABE_Order::get_order_hash($order_id) && $prepaid_amount > 0 ){
                
                BABE_Order::update_order_prepaid_amount($order_id, $prepaid_amount);
                BABE_Order::update_order_status($order_id, 'payment_expected');
                $output = __('Done!', BABE_TEXTDOMAIN);
                
             }
        }
        
        echo $output;
        wp_die();                   
    }         
    
////////////////////////
    /**
	 * Add search results from post meta.
     * @param string $join - join sql clauses
     * @return string
	 */
    public static function search_join ($join){
    global $pagenow, $wpdb;
    if ( isset( $_GET['s'] )){
    if ( is_admin() && $pagenow=='edit.php' && $_GET['post_type']==BABE_Post_types::$order_post_type && $_GET['s'] != '') {
        $join .='LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id LEFT JOIN '.BABE_Order::$table_order_items. ' ON '. $wpdb->posts . '.ID = ' . BABE_Order::$table_order_items . '.order_id LEFT JOIN '.BABE_Order::$table_order_itemmeta. ' ON '. BABE_Order::$table_order_items . '.order_item_id = ' . BABE_Order::$table_order_itemmeta . '.order_item_id ';
     }
    }
    return $join;
}

////////////////////////
    /**
	 * Add search results from post meta.
     * @param string $where - where sql clauses
     * @return string
	 */
    public static function search_where( $where ){
    global $pagenow, $wpdb;
    if ( isset( $_GET['s'] )){
    if ( is_admin() && $pagenow=='edit.php' && $_GET['post_type']==BABE_Post_types::$order_post_type && $_GET['s'] != '') {
        
        $new_where = "(".$wpdb->posts.".post_title LIKE $1) OR ((".$wpdb->postmeta.".meta_key = '_status') AND (".$wpdb->postmeta.".meta_value LIKE $1)) OR ((".$wpdb->postmeta.".meta_key = 'first_name') AND (".$wpdb->postmeta.".meta_value LIKE $1)) OR ((".$wpdb->postmeta.".meta_key = 'last_name') AND (".$wpdb->postmeta.".meta_value LIKE $1)) OR ((".$wpdb->postmeta.".meta_key = 'email') AND (".$wpdb->postmeta.".meta_value LIKE $1)) OR ((".$wpdb->postmeta.".meta_key = 'phone') AND (".$wpdb->postmeta.".meta_value LIKE $1)) OR (".BABE_Order::$table_order_items.".order_item_name LIKE $1) OR ((".BABE_Order::$table_order_itemmeta.".meta_key = 'date_from') AND (".BABE_Order::$table_order_itemmeta.".meta_value LIKE $1))";
        
        $new_where = apply_filters('babe_admin_order_search_where_clauses', $new_where);
        
        $where = preg_replace(
       "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
       $new_where, $where );
     }
    }
    return $where;
}

////////////////////////
    /**
	 * Add search results from post meta.
     * @param string $groupby - group by sql clauses
     * @return string
	 */
    public static function search_group_by($groupby) {
    global $pagenow, $wpdb;
    if ( isset( $_GET['s'] )){
      if ( is_admin() && $pagenow == 'edit.php' && $_GET['post_type']==BABE_Post_types::$order_post_type && $_GET['s'] != '' ) {
        $groupby = "$wpdb->posts.ID";
      }
    }  
    return $groupby;
}

/////////////////////
    /**
	 * Add order custom column heads.
     * @param array $defaults
     * @return array
	 */
    public static function order_table_head( $defaults ) {
    
    $defaults['date_created']   = __('Date of Booking', BABE_TEXTDOMAIN);
    $defaults['items']  = __('Items', BABE_TEXTDOMAIN);          
    $defaults['date_from']    = __('Date from', BABE_TEXTDOMAIN);
    $defaults['date_to']   = __('Date to', BABE_TEXTDOMAIN);
    $defaults['guests']   = __('Guests', BABE_TEXTDOMAIN);
    $defaults['total_amount'] = __('Total amount', BABE_TEXTDOMAIN);
    $defaults['prepaid_amount'] = __('Prepaid amount', BABE_TEXTDOMAIN);
    $defaults['status'] = __('Status', BABE_TEXTDOMAIN);
    $defaults['prepaid_received'] = __('Prepaid received', BABE_TEXTDOMAIN);

    unset($defaults['date']);
    return $defaults;
}

///////////////////////////////////
    /**
	 * Add order custom column content.
     * @param string $column_name
     * @param int $post_id
     * @return array
	 */
    public static function order_table_content( $column_name, $post_id ) {
    
    if ($column_name == 'date_created') {
      echo get_the_date( get_option("date_format").' '.get_option('time_format'), $post_id );
    }
    
    if ($column_name == 'items') {
        
      $order_items = BABE_Order::get_order_items($post_id);
      $items = '<ul>';      
      foreach($order_items as $order_item_id => $item_meta){
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($item_meta['booking_obj_id']);
        $items .= '<li>'.$item_meta['order_item_name'].'</li>';
      }
      $items .= '</ul>';
        
      echo $items;
    }
    
    if ($column_name == 'date_from') {
        
      $order_items = BABE_Order::get_order_items($post_id);
      $date_from = '<ul>';
      
      foreach($order_items as $order_item_id => $item_meta){
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($item_meta['booking_obj_id']);
        $date_from_obj = new DateTime($item_meta['meta']['date_from']);        
        $date_from .= '<li>'.$date_from_obj->format(get_option('date_format').' '.get_option('time_format')).'</li>';
      }
      $date_from .= '</ul>';
        
      echo $date_from;
    }
    
    if ($column_name == 'date_to') {
        
      $order_items = BABE_Order::get_order_items($post_id);
      $date_to = '<ul>';
      foreach($order_items as $order_item_id => $item_meta){
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($item_meta['booking_obj_id']);
        $date_to_obj = new DateTime($item_meta['meta']['date_to']);
        if ($rules_cat['rules']['basic_booking_period'] == 'recurrent_custom'){
            $duration = (array)get_post_meta($item_meta['booking_obj_id'], 'duration', 1);
            $duration = wp_parse_args( $duration, array(
             'd' => 0,
             'h' => 0,
             'i' => 0,
            ));
            $date_to_obj->modify( '+'.$duration['d'].' days +'.$duration['h'].' hours +'.$duration['i'].' minutes' );
        }
        $date_to .= '<li>'.$date_to_obj->format(get_option('date_format').' '.get_option('time_format')).'</li>';
      }
      $date_to .= '</ul>';
      
      echo $date_to;
    }
    
    if ($column_name == 'guests') {
        
      $order_items = BABE_Order::get_order_items($post_id);
      $guests = '<ul>';
      foreach($order_items as $order_item_id => $item_meta){
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($item_meta['booking_obj_id']);
        $guests .= '<li>'.array_sum($item_meta['meta']['guests']).'</li>';
      }
      $guests .= '</ul>';  
        
      echo $guests;
    }

    if ($column_name == 'total_amount') {
       echo BABE_Currency::get_currency_price(BABE_Order::get_order_total_amount($post_id));
    }
    
    if ($column_name == 'prepaid_amount') {
       echo BABE_Currency::get_currency_price(BABE_Order::get_order_prepaid_amount($post_id));
    }
    
    if ($column_name == 'prepaid_received') {
        
        $expected_amount = BABE_Order::get_order_prepaid_amount($post_id);
        
        $prepaid_received = BABE_Order::get_order_prepaid_received($post_id) - BABE_Order::get_order_refunded_amount($post_id);
       
       echo BABE_Currency::get_currency_price($prepaid_received);
       
       $request_prepaid_amount = !$expected_amount ? BABE_Order::get_order_total_amount($post_id) - $prepaid_received : $expected_amount;
       
       $status = BABE_Order::get_order_status($post_id);
       
       if (
           $expected_amount &&
           (
               'payment_deferred' == $status
               || 'payment_expected' == $status
               || 'payment_received' == $status
               || 'completed' == $status
           )
       ){
       
       echo '
       <div class="babe_payment_request">
         <span class="babe_payment_request_button babe_payment_request_open button btn button-secondary">'.__('Request Payment', BABE_TEXTDOMAIN).'</span>
         <div class="babe_payment_request_body" style="display:none;">
            <span class="babe_payment_request_currency">'.BABE_Currency::get_currency_symbol().'</span><input type="text" value="'.$request_prepaid_amount.'" class="babe_payment_request_input">
            <span class="babe_payment_request_button babe_payment_request_send button btn button-primary" data-order-id="'.$post_id.'">'.__('Send', BABE_TEXTDOMAIN).'</span>
            <span class="babe_payment_request_button babe_payment_request_cancel button btn button-primary">'.__('Cancel', BABE_TEXTDOMAIN).'</span>
            <span class="spin_f"><i class="fas fa-spinner fa-spin"></i></span>
         </div>
       </div>';
       
       }
    }
    
    if ($column_name == 'status') {
        $status = BABE_Order::get_order_status($post_id);
      echo '<div class="babe_admin_edit_order_status order_status_'.$status.'">'.BABE_Order::$order_statuses[$status].'</div>';
    }

}                          
        
////////////////////    
}

BABE_Order_admin::init(); 
