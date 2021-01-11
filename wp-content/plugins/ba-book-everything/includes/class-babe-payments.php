<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Payments Class.
 * Get general settings
 * @class 		BABE_Payments
 * @version		1.0.0
 * @author 		Booking Algorithms
 */

class BABE_Payments {
    
    static $payment_methods = array();
    
    // DB tables
    static $table_token_items;
    
    static $table_token_itemmeta;
    
    ///// cache
    
    private static $token_item_meta = array();
    
//////////////////////////////
    /**
	 * Hook in tabs.
	 */
    public static function init() {
        
        global $wpdb;
        self::$table_token_items = $wpdb->prefix.'babe_payment_tokens';
        self::$table_token_itemmeta = $wpdb->prefix.'babe_payment_tokenmeta';
        
        add_action( 'init', array( __CLASS__, 'init_payment_methods_array') );
        
        add_filter( 'query_vars', array( __CLASS__, 'register_query_var'), 10 );
        
        add_action( 'init', array( __CLASS__, 'rewrite_rule'), 1 );
        
        add_action( 'template_redirect', array( __CLASS__, 'payment_server_response'), 1);
        
	}
    
////////////////////////
     /**
	 * Init $payment_methods array
     * @return array
	 */
     public static function init_payment_methods_array(){
        
        self::$payment_methods['cash'] = __('Pay later', BABE_TEXTDOMAIN);
        
        do_action( 'babe_payment_methods_init', self::$payment_methods);
        
        return self::$payment_methods;
        
     }
     
////////////////////////
     /**
	 * Add payment method
     * @param string $method
     * @param string $method_title
     * @return
	 */
     public static function add_payment_method($method, $method_title){
        
        $method = sanitize_key($method);
        $method_title = sanitize_text_field($method_title);
        
        self::$payment_methods[$method] = $method_title;
        
        return;
        
     }
     
////////////////////////
     /**
	 * Remove payment method
     * @param string $method
	 */
     public static function remove_payment_method($method){
        
        $method = sanitize_key($method);
        
        if (isset(self::$payment_methods[$method])){
            unset(self::$payment_methods[$method]);
        }
     } 

////////////////////////
     /**
	 * Payment server response
     *
	 */
     public static function payment_server_response(){
        
        if (get_query_var('payment_gateway', '')){
            
           $payment_gateway = sanitize_key(get_query_var('payment_gateway')); 
            
           do_action( 'babe_payment_server_response');
           
           do_action( 'babe_payment_server_'.$payment_gateway.'_response');
           
           exit;
        }
     }
     
///////////////////////////////////////
    /**
	 * Register query var
     * 
     * @param array $vars
     * 
     * @return array
	 */
    public static function register_query_var( $vars ) {
        $vars[] = 'payment_gateway';
        return $vars;
    }
    
///////////////////////////////////////
    /**
	 * Add rewrite rules
     * 
     * @param
     *
	 */
    public static function rewrite_rule() {
        
       add_rewrite_tag('%payment_gateway%', '([^&]+)');
    }         
     
///////////////////////////////////////
    /**
	 * Get page url gor payment server response.
     * 
     * @param string $method - payment method
     * 
     * @return string
	 */
    public static function get_payment_server_response_page_url($method) {
        $url = home_url();
        $url = add_query_arg('payment_gateway', $method, $url);
        
        return $url;
    } 
    
////////////////////////
     /**
	 * Save payment token
     * 
     * @param array $args
     * @param string $token_type - charge or refund
     * 
     * @return int
	 */
     public static function save_token($args, $token_type = 'charge'){
        
        global $wpdb;
        
        $args = wp_parse_args( $args, array(
            'gateway_id' => '',
            'token' => '',
            'user_id' => 0,
            'order_id' => 0,
            'amount' => 0,
            'type' => $token_type,
            'is_default' => 0, 
        ));
        
        $wpdb->insert(
               self::$table_token_items,
                  array(
                     'gateway_id' => $args['gateway_id'],
                     'token' => $args['token'],
                     'order_id' => $args['order_id'],
                     'amount' => $args['amount'],
                     'user_id' => $args['user_id'],
                     'type' => $args['type'],
                     'is_default' => $args['is_default'],
                  )
        );
        
        $meta_args = $args;
        
        unset($meta_args['gateway_id']);
        unset($meta_args['token']);
        unset($meta_args['order_id']);
        unset($meta_args['amount']);
        unset($meta_args['user_id']);
        unset($meta_args['type']);
        unset($meta_args['is_default']);
        
        $token_id = $wpdb->insert_id;
        
        foreach ($meta_args as $meta_key => $meta_value){
            self::update_token_meta($token_id, $meta_key, $meta_value);
        }
        
        return $token_id;
     }
     
////////////////////////
     /**
	 * Update token meta
     * 
     * @param int $token_id
     * @param string $meta_key
     * @param string $meta_value
     * @return int
	 */
     public static function update_token_meta($token_id, $meta_key, $meta_value){
        
        global $wpdb;
        
        $output = 0;
        
        $meta_value = maybe_serialize($meta_value);
        
        $token_id = absint($token_id);
        
        if (is_string($meta_key)){
        
        /// get order item meta
        $meta_arr = $wpdb->get_results("SELECT * FROM ".self::$table_token_itemmeta." WHERE payment_token_id = ".$token_id." AND meta_key = '".$meta_key."'", ARRAY_A);
        
        if (!empty($meta_arr)){
            //// update row by meta_id
            $output = $wpdb->query( "UPDATE ".self::$table_token_itemmeta." SET meta_value = '".$meta_value."' WHERE meta_id = ".$meta_arr[0]['meta_id'] );

        } else {
            //// create row
            $wpdb->insert(
                   self::$table_token_itemmeta,
                     array(
                       'payment_token_id' => $token_id,
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
	 * Get token item meta
     * 
     * @param int $token_id
     * @param string $meta_key
     * @return mixed string or array
	 */
     public static function get_token_item_meta($token_id, $meta_key = ''){
        
        global $wpdb;
        
        $token_id = absint($token_id);
        
        if (is_string($meta_key)){
            
            $output = array();
        
            /// get token item meta
            if (isset(self::$token_item_meta[$token_id])){
            
              $output = self::$token_item_meta[$token_id];
            
            } else {
              
              $meta_arr = $wpdb->get_results("SELECT * FROM ".self::$table_token_itemmeta." WHERE payment_token_id = ".$token_id, ARRAY_A);
        
              if (!empty($meta_arr)){
                foreach($meta_arr as $meta){
                  $output[$meta['meta_key']] = maybe_unserialize($meta['meta_value']);
                }
                
                self::$token_item_meta[$token_id] = $output;
              }
            }
            
            return $meta_key ? ( isset($output[$meta_key]) ? $output[$meta_key] : '') : $output;
        
        }
        
        return '';
        
     }
     
////////////////////////
     /**
	 * Get order all tokens
     * 
     * @param int $order_id
     * 
     * @return array
	 */
     public static function get_order_all_tokens($order_id){
        
        global $wpdb;
        
        $output = array();
        
        $order_id = absint($order_id);
        
        $tokens_arr = $wpdb->get_results("
        SELECT * FROM ".self::$table_token_items." token
        
        LEFT JOIN #get dates
        (
        SELECT meta_value AS token_date, payment_token_id 
        FROM ".self::$table_token_itemmeta."
        WHERE meta_key = 'token_date'
        ) pm ON token.token_id = pm.payment_token_id 
        
        WHERE token.order_id = ".$order_id."
        
        ORDER BY type ASC, token_date DESC, gateway_id ASC
        
        ", ARRAY_A);
        
        if (!empty($tokens_arr)){
        
          foreach ($tokens_arr as $token_arr){
            
            $token_meta = self::get_token_item_meta($token_arr['token_id']);
            
            $output[$token_arr['type']][$token_arr['token_date']] = array(
                'token_id' => $token_arr['token_id'],
                'token' => $token_arr['token'],
                'gateway_id' => $token_arr['gateway_id'],
                'amount' => $token_arr['amount'],
                'is_default' => $token_arr['is_default'],
                'meta' => $token_meta,
            );
            
          } 
        
        }
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Get order all tokens by date desc
     * 
     * @param int $order_id
     * 
     * @return array
	 */
     public static function get_order_tokens_history($order_id){
        
        global $wpdb;
        
        $output = array();
        
        $order_id = absint($order_id);
        
        $tokens_arr = $wpdb->get_results("
        SELECT * FROM ".self::$table_token_items." token
        
        LEFT JOIN #get dates
        (
        SELECT meta_value AS token_date, payment_token_id 
        FROM ".self::$table_token_itemmeta."
        WHERE meta_key = 'token_date'
        ) pm ON token.token_id = pm.payment_token_id 
        
        WHERE token.order_id = ".$order_id."
        
        ORDER BY token_date DESC
        
        ", ARRAY_A);
        
        if (!empty($tokens_arr)){
        
          foreach ($tokens_arr as $token_arr){
            
            $token_meta = self::get_token_item_meta($token_arr['token_id']);
            
            $output[$token_arr['token_date']] = array(
                'type' => $token_arr['type'],
                'token_id' => $token_arr['token_id'],
                'token' => $token_arr['token'],
                'gateway_id' => $token_arr['gateway_id'],
                'amount' => $token_arr['amount'],
                'is_default' => $token_arr['is_default'],
                'meta' => $token_meta,
            );
            
          } 
        
        }
        
        return $output;
        
     }     
     
////////////////////////
     /**
	 * Get order last charge token
     * 
     * @param int $order_id
     * 
     * @return array
	 */
     public static function get_order_last_charge_token($order_id){
        
        $output = array();
        
        $tokens = self::get_order_all_tokens($order_id);
        
        if (isset($tokens['charge'])){
            
            $charge_tokens = $tokens['charge'];
            
            $output = reset($charge_tokens);
            
        }
        
        return $output;
     }
     
////////////////////////
     /**
	 * Get order tokens for refund
     * 
     * @param int $order_id
     * 
     * @return array
	 */
     public static function get_order_tokens_for_refund($order_id){
        
        $output = array();
        
        $tokens = self::get_order_all_tokens($order_id);
        
        $charge_tokens = isset($tokens['charge']) ? $tokens['charge'] : array();
        
        $refunded_tokens = isset($tokens['refund']) ? $tokens['refund'] : array();
        
        if (!empty($charge_tokens)){
        
         foreach ($charge_tokens as $token_date => $charge_token){
            
            $av_amount = $charge_token['amount'];
            
            $token = $charge_token['token'];
            
            if (!empty($refunded_tokens)){
            
              foreach ($refunded_tokens as $refunded_token){
                
                if ($token == $refunded_token['token']){
                    
                    $av_amount = $av_amount - $refunded_token['amount'];
                    
                }
                
              }
            
            }
            
            $output[] = array(
                'amount' => $av_amount,
                'token_id' => $charge_token['token_id'],
                'token' => $token,
                'gateway_id' => $charge_token['gateway_id'],
                'meta' => $charge_token['meta'],
            );
            
         }
        
        }
        
        return $output;
     }                         
     
////////////////////////
     /**
	 * Complete order with payment
     * 
     * @param int $order_id
     * @param string $payment_method
     * @param string $token
     * @param float $amount
     * @param string $currency
     * @param array $args
     * 
     * @return int
	 */
     public static function do_complete_order($order_id, $payment_method, $token, $amount, $currency = '', $args = array()){
        
        $currency = $currency ? $currency : BABE_Currency::get_currency();
        
        $date_now_obj = BABE_Functions::datetime_local();
        
        $token_args = array(
            'gateway_id' => $payment_method,
            'token' => $token,
            'user_id' => BABE_Order::get_order_customer($order_id),
            'order_id' => $order_id,
            'currency' => $currency,
            'amount' => $amount,
            'token_date' => $date_now_obj->format('Y-m-d H:s'),
        );
        
        foreach ($args as $key => $val){
            $key_name = sanitize_key($key);
            if (!isset($token_args[$key_name])){
                $token_args[$key_name] = $val;
            }
        }
                
        if ($amount > 0){
            // save token
            $token_id = self::save_token($token_args, 'charge');
            BABE_Order::update_order_prepaid_received($order_id, $amount);
            BABE_Order::update_order_prepaid_amount($order_id, 0);
            BABE_Order::update_order_status($order_id, 'payment_received');
            do_action('babe_order_paid', $order_id, $amount, $currency);        
        }
        
        return; 
        
     }
     
////////////////////////
     /**
	 * Complete order with payment
     * 
     * @param int $order_id
     * @param string $payment_method
     * @param string $token
     * @param float $amount
     * @param array $token_arr
     *
	 */
     public static function do_after_refund_order($order_id, $payment_method, $token, $amount, $token_arr){
        
        $currency = isset($token_arr['meta']['currency']) ? $token_arr['meta']['currency'] : BABE_Currency::get_currency();
        
        $date_now_obj = BABE_Functions::datetime_local();
        
        $token_args = array(
            'gateway_id' => $payment_method,
            'token' => $token,
            'user_id' => BABE_Order::get_order_customer($order_id),
            'order_id' => $order_id,
            'currency' => $currency,
            'amount' => $amount,
            'token_date' => $date_now_obj->format('Y-m-d H:s'),
        );
                
        if ($amount > 0){
            // save token
            $token_id = self::save_token($token_args, 'refund');
            BABE_Order::update_order_refunded_amount($order_id, $amount);
            do_action('babe_order_refunded', $order_id, $amount, $currency, $payment_method);        
        }
     }                                        
        
////////////////////    
}

BABE_Payments::init(); 
