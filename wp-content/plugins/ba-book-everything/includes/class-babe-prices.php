<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Prices Class.
 * 
 * @class 		BABE_Prices
 * @version		1.3.9
 * @author 		Booking Algorithms
 */

class BABE_Prices {
    
    // DB tables
    static $table_rate;
    
    static $table_rate_meta;
    
    static $table_discount;
    
    private static $nonce_title = 'prices-tpl-nonce';
    
//////////////////////////////
    /**
	 * Hook in tabs.
	 */
    public static function init() {  
       global $wpdb;
       self::$table_rate = $wpdb->prefix.'babe_rates';
       self::$table_rate_meta = $wpdb->prefix.'babe_rates_meta';
       self::$table_discount = $wpdb->prefix.'babe_discount';
       
       add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueued_assets' ) );
       add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueue_scripts' ) );
       
       add_action( 'wp_ajax_get_price_details_form', array( __CLASS__, 'ajax_get_price_details_form'));
       add_action( 'wp_ajax_get_price_details_block', array( __CLASS__, 'ajax_get_price_details_block'));
       add_action( 'wp_ajax_save_rate', array( __CLASS__, 'ajax_save_rate'));
       add_action( 'wp_ajax_delete_rate', array( __CLASS__, 'ajax_delete_rate'));
       add_action( 'wp_ajax_check_base_rate', array( __CLASS__, 'ajax_check_base_rate'));
       add_action( 'wp_ajax_rates_reorder', array( __CLASS__, 'ajax_rates_reorder'));
       
	}
    
///////////////////////////////////////
    /**
	 * Enqueue assets.
	 */
    public static function wp_enqueue_scripts() {
        
      if (isset($_GET['inner_page']) && $_GET['inner_page'] == 'edit-post' && isset($_GET['edit_post_id']) && $_GET['edit_post_id'] && BABE_Users::current_user_can_edit_post($_GET['edit_post_id'])){
        
     wp_enqueue_script( 'babe-modal-js', plugins_url( "js/babe-modal.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
     
     wp_enqueue_style( 'babe-modal-style', plugins_url( "css/babe-modal.css", BABE_PLUGIN ));

     wp_enqueue_script( 'babe-prices-js', plugins_url( "js/admin/babe-admin-prices.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
     wp_localize_script( 'babe-prices-js', 'babe_prices_lst', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'date_format' => BABE_Settings::$settings['date_format'] == 'd/m/Y' ? 'dd/mm/yy' : 'mm/dd/yy',
            'nonce' => wp_create_nonce(self::$nonce_title)
         )
     );

          wp_enqueue_style( 'babe-admin-prices-style', plugins_url( "css/admin/babe-admin-prices.css", BABE_PLUGIN ));
      }

     }     

///////////////////////////////////////
    /**
	 * Enqueue assets admin.
	 */
    public static function enqueued_assets() {
        
     global $current_screen;  
        
     if (!empty($current_screen) && $current_screen->post_type == BABE_Post_types::$booking_obj_post_type && ($current_screen->base == 'post' || $current_screen->base == 'post-new')){
        
     wp_enqueue_script( 'babe-admin-modal-js', plugins_url( "js/babe-modal.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
     
     wp_enqueue_style( 'babe-admin-modal-style', plugins_url( "css/babe-modal.css", BABE_PLUGIN ));
     
     wp_enqueue_script( 'babe-admin-prices-js', plugins_url( "js/admin/babe-admin-prices.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
     wp_localize_script( 'babe-admin-prices-js', 'babe_prices_lst', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'date_format' => BABE_Settings::$settings['date_format'] == 'd/m/Y' ? 'dd/mm/yy' : 'mm/dd/yy',
            'nonce' => wp_create_nonce(self::$nonce_title)
         )
     );
  
     wp_enqueue_style( 'babe-admin-prices-style', plugins_url( "css/admin/babe-admin-prices.css", BABE_PLUGIN ));
     }

     }    

//////////////////////////////
    /**
	 * Get rates for $booking_obj_id.
     * @param int $booking_obj_id.
     * @param datetime $datetime_from - MySQL datetime YYYY-MM-DD HH:MM:SS.
     * @param datetime $datetime_to - MySQL datetime YYYY-MM-DD HH:MM:SS.
     * @return array
	 */
    public static function get_rates($booking_obj_id, $datetime_from = '', $datetime_to = '') {
       global $wpdb;
       
       $clauses = '';
       
       if ($datetime_from){
           $clauses .= " AND ( date_to >= '".$datetime_from."' OR date_to IS NULL )";
       }
       
       if ($datetime_to){
           $clauses .= " AND ( date_from <= '".$datetime_to."' OR date_from IS NULL )";
       }
       
       if ($datetime_from && $datetime_to){
            $rate_date_from = new DateTime( $datetime_from );
            $rate_date_to = new DateTime( $datetime_to );
            if ($rate_date_to == $rate_date_from){
                $rate_date_to->modify('+1 day');
            }
            $d_interval = date_diff($rate_date_from, $rate_date_to);
            $days_total = $d_interval->format('%a'); // total days
            // if < 7 days check the apply days
            if ( 0 < $days_total && $days_total < 7){
                $tmp_clauses_arr = [];
                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($rate_date_from, $interval, $rate_date_to);
                foreach($daterange as $date){
                   $date_cal_day_num = BABE_Calendar_functions::get_week_day_num($date);
                   $tmp_clauses_arr[] = "LOCATE('i:".$date_cal_day_num.";', apply_days) > 0";
                }
                if ( !empty($tmp_clauses_arr) ){
                   $clauses .= " AND ( ".implode(' OR ', $tmp_clauses_arr)." )";
                }
            }
       }
       
       $rates = $wpdb->get_results("SELECT * FROM ".self::$table_rate." WHERE booking_obj_id = ".absint($booking_obj_id).$clauses." ORDER BY rate_order ASC, price_from ASC, date_from DESC, date_to DESC", ARRAY_A);
       
       $rates_arr = self::parse_db_rates_to_rates_arr($rates);
       
       return $rates_arr;   
	}
    
//////////////////////////////////////        
    /**
	 * Parse rates from DB to rates array
     * @param array $rates.
     * @return array
	 */
    public static function parse_db_rates_to_rates_arr($rates){
       
       $rates_arr = array(); 
        
       foreach ($rates as $rate){
           $rates_arr[] = array_map( 'maybe_unserialize', $rate);
       }
       
       return $rates_arr;
        
    }
    
///////////////////////////////////////
   /**
	 * Get conditional signs
     * 
     * @return array
	 */
    public static function get_conditional_signs() {
        
        return array(
                       1 => '>',
                       2 => '>=',
                       3 => '<',
                       4 => '<=',
                       5 => '=',
                       6 => '!=',
                    );
    }
    
///////////////////////////////////////
   /**
	 * Get rate units
     * 
     * @param array $rules
     * @return array
	 */
    public static function get_rate_units($rules) {
        
        $output = array(
           'units' => '',
           'unit' => '',
        );
        
        if ($rules['basic_booking_period'] == 'night'){
            $output['units'] = __('nights', BABE_TEXTDOMAIN);
            $output['unit'] = __('night', BABE_TEXTDOMAIN);
        } elseif ($rules['basic_booking_period'] == 'day'){
            $output['units'] = __('days', BABE_TEXTDOMAIN);
            $output['unit'] = __('day', BABE_TEXTDOMAIN);
        } elseif ($rules['basic_booking_period'] == 'hour'){
            $output['units'] = __('hours', BABE_TEXTDOMAIN);
            $output['unit'] = __('hour', BABE_TEXTDOMAIN);
        }
                
        if ($output['unit']){
            if ($rules['booking_mode'] != 'object'){
                $output['unit'] .= ' '.__('person', BABE_TEXTDOMAIN);
            }
        } elseif ($rules['booking_mode'] != 'object') {
            if ($rules['booking_mode'] == 'places'){
                $output['units'] = __('places', BABE_TEXTDOMAIN);
                $output['unit'] = __('place', BABE_TEXTDOMAIN);
            } else {
                $output['units'] = __('tickets', BABE_TEXTDOMAIN);
                $output['unit'] = __('ticket', BABE_TEXTDOMAIN);
            }
        }
        
        if ($output['unit']){
            $output['unit'] = ' / '.$output['unit'];
        } 
        
        $output = apply_filters('babe_get_rate_units', $output, $rules);
        
        return $output;
    }           
    
//////////////////////////////////////        
    /**
	 * Is there a base rate?
     * @param int $booking_obj_id.
     * @return boolean
	 */
    public static function base_rate_exists($booking_obj_id) {
        global $wpdb;
        
        $rate_id = $wpdb->get_var("SELECT rate_id FROM ".self::$table_rate." WHERE booking_obj_id = ".absint($booking_obj_id)." LIMIT 1");
        
        return $rate_id ? true : false;
    }

///////////////////////////////////////    
    /**
	 * Create fields for price adding.
	 */
    public static function ajax_get_price_details_form(){
        
        $output = '';
        
        if (isset($_POST['post_id']) && isset($_POST['cat_slug']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title ) && BABE_Users::current_user_can_edit_post($_POST['post_id'])){
             $post_id = (int)$_POST['post_id'];
             $cat_slug = sanitize_text_field($_POST['cat_slug']);
             $rules = BABE_Booking_Rules::get_rule_by_cat_slug($cat_slug);
             
             if ( !empty($rules) ){
                
                $days_arr = BABE_Calendar_functions::get_week_days_arr();
                $ages = BABE_Post_types::get_ages_arr();
                
                $units_arr = self::get_rate_units($rules);
                
                $units = $units_arr['units'];
                $unit = $units_arr['unit'];
                
                $output .= '<h3>'.__('New rate', BABE_TEXTDOMAIN).' <span id="rate_new_open" class="btn button button-secondary">+</span></h3>';
                
                $output .= '
                <div class="rate_form_inner no_active">    
                    <div class="rate_title">
                        <label for="_rate_title">'.__('Title:', BABE_TEXTDOMAIN).'</label>
                        <input type="text" name="_rate_title" id="_rate_title" value="" placeholder="'.__('(required)', BABE_TEXTDOMAIN).'">
                      <div class="rate_dates">
                       <label for="_rate_type">'.__('Date from:', BABE_TEXTDOMAIN).'</label>
                       <input type="text" class="cmb2-text-small" name="_rate_date_from" id="_rate_date_from" value="" placeholder="'.__('no limits', BABE_TEXTDOMAIN).'">
                       <label for="_rate_type">'.__('Date to:', BABE_TEXTDOMAIN).'</label>
                       <input type="text" class="cmb2-text-small" name="_rate_date_to" id="_rate_date_to" value="" placeholder="'.__('no limits', BABE_TEXTDOMAIN).'">
                      </div>
                    </div>
                    
                    <div class="rate_min_max">
                       <label for="_rate_type">'.__('Minimum booking:', BABE_TEXTDOMAIN).'</label>
                       <input type="text" class="cmb2-text-small" name="_rate_min_booking" id="_rate_min_booking" value="" placeholder="'.__('no limits', BABE_TEXTDOMAIN).'"><span class="rate-label-units">'.$units.'</span>
                       <label for="_rate_type">'.__('Maximum booking:', BABE_TEXTDOMAIN).'</label>
                       <input type="text" class="cmb2-text-small" name="_rate_max_booking" id="_rate_max_booking" value="" placeholder="'.__('no limits', BABE_TEXTDOMAIN).'"><span class="rate-label-units">'.$units.'</span>
                    </div>
                    ';
                    
                    $output .= '
                    <div class="rate_apply_days">
                        <label>'.__('Rate applies to days:', BABE_TEXTDOMAIN).'</label>
                        <ul class="cmb2-checkbox-list cmb2-list">
                    ';
                    foreach ($days_arr as $day_num => $day_title){
                         $output .= '<li><input type="checkbox" class="cmb2-option" name="apply_days['.$day_num.']" id="apply_days'.$day_num.'" value="'.$day_num.'" checked="checked"><label for="apply_days'.$day_num.'">'.$day_title.'</label></li>';
                    }
                    $output .= '
                        </ul>
                    </div>
                    ';
                    
                    $output .= '
                    <div class="rate_start_days">
                        <label>'.__('Start days:', BABE_TEXTDOMAIN).'</label>
                        <ul class="cmb2-checkbox-list cmb2-list">
                    ';
                    foreach ($days_arr as $day_num => $day_title){
                         $output .= '<li><input type="checkbox" class="cmb2-option" name="start_days['.$day_num.']" id="start_days'.$day_num.'" value="'.$day_num.'" checked="checked"><label for="start_days'.$day_num.'">'.$day_title.'</label></li>';
                    }
                    $output .= '
                        </ul>
                    </div>
                    ';
                    
                    ////// price
                    
                    $output .= '
                    <div class="set-price-general">
                      <h4>'.__('General price', BABE_TEXTDOMAIN).'</h4>';    
                    
                    $output .= '
                      <table class="age-prices">
                        <tbody>';
                    $price_type = 'general';
                    if ($rules['ages']){
                      foreach ($ages as $age_arr){
                         $output .= '<tr><td><span class="age_title">'. $age_arr['name'] . ' (' . $age_arr['description'] . ')</span> '.BABE_Currency::get_currency_symbol().' </td><td><input class="set-age-price age-price-'.$price_type.'" name="_price_'.$price_type.'['.$age_arr['age_id'].']" data-ind="'.$age_arr['age_id'].'" type="text" value="">'.$unit.'</td></tr>'; 
                      }
                    } else {
                       $output .= '<tr><td> '.BABE_Currency::get_currency_symbol().' </td><td><input class="set-age-price age-price-'.$price_type.'" name="_price_'.$price_type.'[0]" data-ind="0" type="text" value="">'.$unit.'</td></tr>'; 
                    }
                    $output .= '
                        </tbody>
                      </table>
                    </div>';
                    
                    ////// price from
                    
                    $output .= '
                    <div class="set-price-from">
                      <label for="_price_from">'.__('Price from: ', BABE_TEXTDOMAIN).'</label>
                      '.BABE_Currency::get_currency_symbol().' <input class="age-price-from cmb2-text-small" name="_price_from" id="_price_from" type="text" value="">'.$unit.'
                    </div>
                    ';
                    
                    ////// conditional prices
                    
                    $signs = self::get_conditional_signs();
                    
                    $output .= '
                    <div class="set-price-conditional">
                      <h4>'.__('Conditional prices', BABE_TEXTDOMAIN).'</h4>
                      <ol id="rate-price-conditional-holder"></ol>
                      <div id="rate-price-conditional-generator">
                         <span class="conditional_start_label">'.__('IF', BABE_TEXTDOMAIN).'</span>
                         <select class="cmb2-select-list cmb2-list select_option_gray" name="conditional_guests_sign_tmp">
                           <option class="option_gray" value="0" selected="selected">'.__("(don't use)", BABE_TEXTDOMAIN).'</option>
                    ';
                    foreach ($signs as $key => $sign){
                         $output .= '<option value="'.$key.'">'.$sign.'</option>';
                    }
                    $output .= '
                        </select>
                        <input class="cmb2-text-small" name="conditional_guests_number_tmp" type="text" value=""><span class="conditional_guests_number_label">'.__('guests', BABE_TEXTDOMAIN).'</span>';
                        
                    if ( $rules['basic_booking_period'] == 'night' || $rules['basic_booking_period'] == 'day' ){    
                        
                        $output .= '
                        <span class="conditional_operator_label">'.__('AND', BABE_TEXTDOMAIN).'</span>
                        
                        <select class="cmb2-select-list cmb2-list select_option_gray" name="conditional_units_sign_tmp">
                           <option class="option_gray" value="0" selected="selected">'.__("(don't use)", BABE_TEXTDOMAIN).'</option>
                    ';
                       foreach ($signs as $key => $sign){
                         $output .= '<option value="'.$key.'">'.$sign.'</option>';
                       }
                       $output .= '
                        </select>
                        <input class="cmb2-text-small" name="conditional_units_number_tmp" type="text" value=""><span class="conditional_units_number_label">'.$units.'</span>';
                    }    
                    
                    $output .= '
                    <div class="conditional_result_label">'.__('Price', BABE_TEXTDOMAIN).'</div>';    
                    $output .= '
                      <table class="age-prices">
                        <tbody>';
                    $price_type = 'conditional-tmp';
                    if ($rules['ages']){
                      foreach ($ages as $age_arr){
                         $output .= '<tr><td><span class="age_title">'. $age_arr['name'] . ' (' . $age_arr['description'] . ') '.BABE_Currency::get_currency_symbol().' </span></td><td><input class="set-age-price age-price-'.$price_type.'" name="_price_'.$price_type.'['.$age_arr['age_id'].']" data-ind="'.$age_arr['age_id'].'" type="text" value="">'.$unit.'</td></tr>'; 
                      }
                    } else {
                       $output .= '<tr><td><span class="age_title"> '.BABE_Currency::get_currency_symbol().' </span></td><td><input class="set-age-price age-price-'.$price_type.'" name="_price_'.$price_type.'[0]" data-ind="0" type="text" value="">'.$unit.'</td></tr>'; 
                    }
                    $output .= '
                        </tbody>
                      </table>
                    ';                    
                       
                    $output .= '
                        <button class="btn button button-secondary" id="add_price_conditional">'.__('Add conditional price', BABE_TEXTDOMAIN).'</button>
                      </div>
                    ';
                    
                    
                    $output .= '  
                    </div>
                    ';
                    
                    //////////////////////////////////
                    
                    $output .= '
                    <div class="rate-save-button">
                       <button class="btn button button-primary" id="add_price">'.__('Save rate', BABE_TEXTDOMAIN).'</button><span class="spin_f no_active"><i class="fas fa-spinner fa-spin fa-2x"></i></span>
                    </div>
               </div>     
                    ';
               
             } // end if !empty($rules)
        }
        
        echo $output;
        wp_die();
        
    }         
        
///////////////////////////////////////    
    /**
	 * Create fields for price viewing.
	 */
    public static function ajax_get_price_details_block(){
        
        $output = '';
        
        if (isset($_POST['post_id']) && isset($_POST['cat_slug']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title ) && BABE_Users::current_user_can_edit_post($_POST['post_id'])){
           $post_id = (int)$_POST['post_id'];
           $cat_slug = sanitize_text_field($_POST['cat_slug']);
           $rules = BABE_Booking_Rules::get_rule_by_cat_slug($cat_slug);
           $ages = BABE_Post_types::get_ages_arr();
           $ages_arr_ordered_by_id = BABE_Post_types::get_ages_arr_ordered_by_id();
           $days_arr = BABE_Calendar_functions::get_week_days_arr();
             
           if ( !empty($rules) ){
                    
            $rates = self::get_rates($post_id);
            $days_arr = BABE_Calendar_functions::get_week_days_arr();
            
            if ( !empty($rates) ){
                
                $units_arr = self::get_rate_units($rules);
                $units = $units_arr['units'];
                $unit = $units_arr['unit'];
                
                foreach($rates as $rate){
                    
                    $output .= '
                <div class="view-rate-block" data-rate-id="'.$rate['rate_id'].'" data-order="'.$rate['rate_order'].'">
                    <div class="view-rate-title opened" data-rate-id="'.$rate['rate_id'].'">'.$rate['rate_title'];
                        
                    $output .= '<div class="view-rate-dates">';
                    if ($rate['date_from']){
                        $date_from = new DateTime($rate['date_from']);
                        $output .= $date_from->format(get_option('date_format')).' - ';
                    }
                        
                    if ($rate['date_to']){
                        $date_to = new DateTime($rate['date_to']); 
                        $output .= $rate['date_from'] ? '' : ' - ';
                        $output .= $date_to->format(get_option('date_format'));
                    }
                    $output .= '</div>';
                                
                    $output .= '
                    </div>
                    <div class="view-rate-details opened" data-rate-id="'.$rate['rate_id'].'">';    
                    //// get details
                    $output .= '
                    <div class="view-rate-details-item">       
                    ';
                    
                    if ( is_array($rate['apply_days']) ){
                    $output .= '
                    <div class="rate_apply_days">
                        <span class="rate_details_label">'.__('Rate applies to days:', BABE_TEXTDOMAIN).'</span> <span class="rate_details_value rate_apply_days_value">';
                    $tmp_days = array();
                    foreach ($days_arr as $day_num => $day_title){
                        if ( in_array($day_num, $rate['apply_days']) ){
                            $tmp_days[] = $day_title;
                        }
                    }
                    if ( count($tmp_days) == 7 ){
                        $tmp_days = array( __('All', BABE_TEXTDOMAIN) );
                    }
                    $output .= implode(', ', $tmp_days);
                    $output .= '</span>
                    </div>
                    ';
                    }
                    
                    if ( is_array($rate['start_days']) ){
                    $output .= '
                    <div class="rate_start_days">
                        <span class="rate_details_label">'.__('Start days:', BABE_TEXTDOMAIN).'</span> <span class="rate_details_value rate_start_days_value">';
                    $tmp_days = array();
                    foreach ($days_arr as $day_num => $day_title){
                        if ( in_array($day_num, $rate['start_days']) ){
                            $tmp_days[] = $day_title;
                        }
                    }
                    if ( count($tmp_days) == 7 ){
                        $tmp_days = array( __('All', BABE_TEXTDOMAIN) );
                    }
                    $output .= implode(', ', $tmp_days);
                    $output .= '</span>
                    </div>
                    ';
                    }
                    
                    $output .= '
                    <div class="rate_min_max">';
                    if ( $rate['min_booking_period'] ){
                        $output .= '
                        <span class="rate_details_label">'.__('Minimum booking:', BABE_TEXTDOMAIN).'</span> <span class="rate_details_value">'.$rate['min_booking_period'].' '.$units.'</span>
                        ';
                    }
                    if ( $rate['max_booking_period'] ){
                        $output .= '
                        <span class="rate_details_label">'.__('Maximum booking:', BABE_TEXTDOMAIN).'</span> <span class="rate_details_value">'.$rate['max_booking_period'].' '.$units.'</span>
                        ';
                    }
                    $output .= '
                    </div>';
                    
                    $output .= '
                    <div class="rate_price_from">
                      <span class="rate_details_label">'.__('Price from: ', BABE_TEXTDOMAIN).'</span> <span class="rate_details_value">'.BABE_Currency::get_currency_price($rate['price_from']).$unit.'</span>
                    </div>
                    ';
                    
                    if ( !empty($rate['price_general']) ){
                    $output .= '
                    <div class="rate_price_general">
                      <span class="rate_details_label">'.__('General price: ', BABE_TEXTDOMAIN).'</span>';
                    
                    $tmp_prices = array();
                    foreach($rate['price_general'] as $age_id => $price){
                       $age_title = !$age_id || !isset($ages_arr_ordered_by_id[$age_id]) ? '' : $ages_arr_ordered_by_id[$age_id]['name'] . ' (' . $ages_arr_ordered_by_id[$age_id]['description'] . ')';
                       $menu_order = isset($ages_arr_ordered_by_id[$age_id]) ? $ages_arr_ordered_by_id[$age_id]['menu_order'] : 0;
                       $tmp_prices[$menu_order] = '<span class="price_age_title">'. $age_title . '</span> <span class="price_age_value">'.BABE_Currency::get_currency_price($price).$unit.'</span>';
                     }
                     ksort($tmp_prices);
                     $output .= implode(' | ', $tmp_prices);
                     $output .= '
                    </div>
                    ';
                    }
                    
                    if ( !empty($rate['prices_conditional']) ){
                        
                        $signs = self::get_conditional_signs();
                        $output .= '
                    <div class="rate_prices_conditional">
                      <h4 class="rate_details_label">'.__('Conditional prices', BABE_TEXTDOMAIN).'</h4>
                      <ol class="rate_prices_conditional_details">';
                      
                        foreach($rate['prices_conditional'] as $price_conditional){
                            
                            $output .= '<li class="conditional_price_block">';
                            
                            $tmp_output = '';
                            
                            if ( isset($price_conditional['conditional_guests_sign']) && isset($price_conditional['conditional_guests_number']) && isset($signs[$price_conditional['conditional_guests_sign']]) ){
                                $tmp_output .= '<span class="prices_conditional_if">'.__('guests', BABE_TEXTDOMAIN).' '.$signs[$price_conditional['conditional_guests_sign']].' '.$price_conditional['conditional_guests_number']. '</span> ';
                            }
                            
                            if ( isset($price_conditional['conditional_units_sign']) && isset($price_conditional['conditional_units_number']) && isset($signs[$price_conditional['conditional_units_sign']]) ){
                                $tmp_output .= $tmp_output ? '<span class="prices_conditional_if">'.__('AND', BABE_TEXTDOMAIN). '</span> ' : '';
                                
                                $tmp_output .= '<span class="prices_conditional_if">'.$units.' '.$signs[$price_conditional['conditional_units_sign']].' '.$price_conditional['conditional_units_number']. '</span>';
                            }
                            
                            $output .= $tmp_output.' <span class="prices_conditional_then">'.__('Price', BABE_TEXTDOMAIN).'</span> ';
                            
                            $tmp_prices = array();
                            foreach($price_conditional['conditional_price'] as $age_id => $price){
                                $age_title = !$age_id || !isset($ages_arr_ordered_by_id[$age_id]) ? '' : $ages_arr_ordered_by_id[$age_id]['name'] . ' (' . $ages_arr_ordered_by_id[$age_id]['description'] . ')';
                                $menu_order = isset($ages_arr_ordered_by_id[$age_id]) ? $ages_arr_ordered_by_id[$age_id]['menu_order'] : 0;
                                $tmp_prices[$menu_order] = '<span class="price_age_title">'. $age_title . '</span> <span class="price_age_value">'.BABE_Currency::get_currency_price($price).$unit.'</span>';
                            }
                            ksort($tmp_prices);
                            $output .= implode(' | ', $tmp_prices);
                            $output .= '</li>';
                        }
                        
                        $output .= '
                      </ol>  
                    </div>
                    ';
                    }
                    
                    $output .= '
                    </div>'; // end view-rate-details-item
                    
                    $output .= '
                    <div class="view-rate-details-item-del" data-rate-id="'.$rate['rate_id'].'">
                           <i class="fas fa-trash-alt"></i>
                    </div>';   

                    $output .= '
                    </div>
                 </div>                
            '; //// end view-rate-block
                           
                } //////// end foreach rates
                    
             } // end if $rates   
           } // end if $rules  
         }
         
        echo $output;
        wp_die();  
    }
    
///////////ajax_check_base_rate////////
    /**
	 * Is there a base rate?
	 */
    public static function ajax_check_base_rate(){
        $output = '';
        
        if (isset($_POST['post_id']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title ) && BABE_Users::current_user_can_edit_post($_POST['post_id'])){
             $post_id = intval($_POST['post_id']);
             $output = self::base_rate_exists($post_id) ? 1 : '';
        }     
        
        echo $output;
        wp_die();  
    }
    
//////////////ajax_delete_rate/////////    
    /**
	 * Delete selected rate.
	 */
    public static function ajax_delete_rate(){
        
        $output = '';
        
        if (isset($_POST['post_id']) && isset($_POST['rate_id']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title ) && BABE_Users::current_user_can_edit_post($_POST['post_id'])){
           $rate_id = absint($_POST['rate_id']); 
           
           $output = self::delete_rate_by_id($rate_id); 
        }
        
        echo $output;
        wp_die();  
    }
    
///////////////////////    
    /**
	 * Delete rate by id
     * 
     * @param int $rate_id
     * 
     * @return int
	 */
    public static function delete_rate_by_id($rate_id){
        global $wpdb;
        
        $output = 0;
        
        $rate_id = absint($rate_id); 
        $old_rate = $wpdb->get_row("SELECT * FROM ".self::$table_rate." WHERE rate_id = ".$rate_id, ARRAY_A);
       
       if(!empty($old_rate)){
           /// delete from DB
           $wpdb->query( $wpdb->prepare( 'DELETE FROM '.self::$table_rate.' WHERE rate_id = %d', $rate_id ) );
           $output = 1;
       }
            
       return $output;  
    }
    
///////////////////////    
    /**
	 * Delete discounts by booking object id
     * 
     * @param int $booking_obj_id
     * 
     * @return int
	 */
    public static function delete_discounts_by_booking_obj_id($booking_obj_id){
        global $wpdb;
        
        $output = 0;
        
        $booking_obj_id = absint($booking_obj_id); 
        $old_discounts = $wpdb->get_results("SELECT * FROM ".self::$table_discount." WHERE booking_obj_id = ".$booking_obj_id, ARRAY_A);
       
       if(!empty($old_discounts)){
           /// delete from DB
           $wpdb->query( $wpdb->prepare( 'DELETE FROM '.self::$table_discount.' WHERE booking_obj_id = %d', $booking_obj_id) );
           
           $output = 1;
       }
       
       return $output;  
    }    
    
///////////////////////    
    /**
	 * Delete rates by booking object id
     * 
     * @param int $booking_obj_id
     * 
     * @return int
	 */
    public static function delete_rates_by_booking_obj_id($booking_obj_id){
        global $wpdb;
        
        $output = 0;
        
        $booking_obj_id = absint($booking_obj_id); 
        $old_rates = $wpdb->get_results("SELECT * FROM ".self::$table_rate." WHERE booking_obj_id = ".$booking_obj_id, ARRAY_A);
       
       if(!empty($old_rates)){
           /// delete from DB
           $wpdb->query( $wpdb->prepare( 'DELETE FROM '.self::$table_rate.' WHERE booking_obj_id = %d', $booking_obj_id ) );
           
           $output = 1;
       }
            
       return $output;  
    }    
        
///////////////////////////////////////    
    /**
	 * Save rate.
	 */
    public static function ajax_save_rate(){
        global $wpdb;
        $output = '';
        
        if (isset($_POST['post_id']) && isset($_POST['cat_slug']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title ) && BABE_Users::current_user_can_edit_post($_POST['post_id'])){
             $post_arr = self::sanitize_prices_post_arr();
             
             $rate_id = self::save_rate($post_arr);
        }
        
        echo $output;
        wp_die();                   
    }
    
///////////////////////////////////////    
    /**
	 * Reorder rates
	 */
    public static function ajax_rates_reorder(){
        global $wpdb;
        $output = '';
        
        if (isset($_POST['post_id']) && absint($_POST['post_id']) && isset($_POST['rate_orders']) && is_array($_POST['rate_orders']) && !empty($_POST['rate_orders']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title ) && BABE_Users::current_user_can_edit_post($_POST['post_id'])){
             
             $rate_orders = array_map('absint', $_POST['rate_orders']);
             $rates = $wpdb->get_results("SELECT rate_id, rate_order FROM ".self::$table_rate." WHERE booking_obj_id = ".absint($_POST['post_id'])." ORDER BY rate_order ASC", ARRAY_A);
             
             if (!empty($rates)){
                
                $new_rates = array();
                foreach($rates as $ind => $rate){
                    $new_rates[$ind] = $rate;
                    if ( isset( $rate_orders[$rate['rate_id']] ) ){
                        $new_rates[$ind]['rate_order'] = $rate_orders[$rate['rate_id']];
                    }
                }
                
                $sql = "INSERT INTO ".self::$table_rate." (rate_id,rate_order) VALUES ";
                
                $start_loop = true;
                foreach ($new_rates as $new_rate){
                    if (!$start_loop) {
                        $sql .= ", ";
                    } else {
                        $start_loop = false;
                    }
                    $sql .= "(".$new_rate['rate_id'].",".$new_rate['rate_order'].")";
                }
                
                $sql .= " ON DUPLICATE KEY UPDATE rate_order=VALUES(rate_order)";
                $new_result = $wpdb->query($sql);
                
             }             
        }
        
        echo $output;
        wp_die();                   
    }    
    
///////////////////////////////////////    
    /**
	 * Save rate.
     * 
     * @param array $post_arr
     * 
     * @return int - rate ID
	 */
    public static function save_rate($post_arr){
        global $wpdb;
        $output = 0;
        
        $rules = BABE_Booking_Rules::get_rule_by_cat_slug($post_arr['cat_slug']);
             
        if (!empty($rules) && $post_arr['post_id'] && !empty($post_arr['_price_general']) && !empty($post_arr['_rate_title']) ){
            
             if ( !empty($post_arr['_prices_conditional']) ){
                usort($post_arr['_prices_conditional'], 'BABE_Functions::compare_arrays_by_order_asc');
             }
                
             $ins_arr = array(
                'booking_obj_id' => $post_arr['post_id'],
                'rate_title' => $post_arr['_rate_title'],
                'apply_days' => serialize($post_arr['apply_days']),
                'start_days' => serialize($post_arr['start_days']),
                'min_booking_period' => $post_arr['_rate_min_booking'],
                'max_booking_period' => $post_arr['_rate_max_booking'],
                'price_general' => serialize($post_arr['_price_general']),
                'prices_conditional' => serialize($post_arr['_prices_conditional']),
             );
                   
             if ($post_arr['_rate_date_from']){
                $ins_arr['date_from'] = $post_arr['_rate_date_from'];
             } 
             if ($post_arr['_rate_date_to']){
                $ins_arr['date_to'] = $post_arr['_rate_date_to'];
             }
                
             if ($post_arr['_price_from'] === ''){
                $main_age_id = BABE_Post_types::get_main_age_id($rules);
                $post_arr['_price_from'] = isset($post_arr['_price_general'][$main_age_id]) ? $post_arr['_price_general'][$main_age_id] : ( isset($post_arr['_price_general'][0]) ? $post_arr['_price_general'][0] : 0 );                        
             }
                
             $ins_arr['price_from'] = $post_arr['_price_from']; 
 
             //// create new row
             $wpdb->insert(
                self::$table_rate,
                $ins_arr
             );
             $output = $wpdb->insert_id;     
        } /// end if !empty $rules
        
        return $output;                 
    }    
    
//////////////////////////////
    /**
	 * Sanitize prices POST array
     * @return array
	 */
    public static function sanitize_prices_post_arr(){
        
    $output = array();
    
    $output['post_id'] = isset($_POST['post_id']) && $_POST['post_id'] ? intval($_POST['post_id']) : 0;
    $output['cat_slug'] = isset($_POST['cat_slug']) && $_POST['cat_slug'] ? sanitize_text_field($_POST['cat_slug']) : '';
    $output['_rate_title'] = isset($_POST['_rate_title']) && $_POST['_rate_title'] ? sanitize_text_field($_POST['_rate_title']) : '';
    
    $output['_rate_date_from'] = isset($_POST['_rate_date_from']) && BABE_Calendar_functions::isValidDate($_POST['_rate_date_from'], BABE_Settings::$settings['date_format']) ? BABE_Calendar_functions::date_to_sql($_POST['_rate_date_from']).' 00:00:00' : ''; /// now in Y-m-d format
    
    $output['_rate_date_to'] = isset($_POST['_rate_date_to']) && BABE_Calendar_functions::isValidDate($_POST['_rate_date_to'], BABE_Settings::$settings['date_format']) ? BABE_Calendar_functions::date_to_sql($_POST['_rate_date_to']).' 23:59:59' : ''; /// now in Y-m-d format
    
    $output['_price_from'] = isset($_POST['_price_from']) && $_POST['_price_from'] !== '' ? floatval($_POST['_price_from']) : '';
    
    $output['_rate_min_booking'] = isset($_POST['_rate_min_booking']) ? intval($_POST['_rate_min_booking']) : 0;
    
    $output['_rate_max_booking'] = isset($_POST['_rate_max_booking']) ? intval($_POST['_rate_max_booking']) : 0;
    
    $output['_price_general'] = isset($_POST['_price_general']) ? array_map( 'floatval', (array)$_POST['_price_general']) : array();
    
    $output['_prices_conditional'] = isset($_POST['_prices_conditional']) ? BABE_Functions::array_map_r( 'floatval', (array)$_POST['_prices_conditional'] ) : array();
    
    $output['start_days'] = isset($_POST['start_days']) ? array_map( 'absint', (array)$_POST['start_days']) : array();
    
    $output['apply_days'] = isset($_POST['apply_days']) ? array_map( 'absint', (array)$_POST['apply_days']) : array();
    
    return $output;
    }

//////////////////////////////
//////////////////////////////
    /**
	 * Get total price clear and price with taxes by booking_obj_id from calculated $price_arr
     * 
     * @param int $booking_obj_id
     * @param array $price_arr
     * @return array
	 */
    public static function get_obj_total_price($booking_obj_id, $price_arr = array()){
        
        $price['total'] = 0;
        $price['total_with_taxes'] = 0;
        
        $price['total_item'] = 0;
        $price['total_item_with_taxes'] = 0;
        
        $price['total_services'] = [];
        $price['total_services_with_taxes'] = array();

        $price['total_fees'] = isset($price_arr['fees']) ? $price_arr['fees'] : [];
        
        if (isset($price_arr['clear_with_taxes'])){
            foreach ($price_arr['clear'] as $age_id => $item_price){
                $price['total_item'] += $item_price;
            }
            foreach ($price_arr['clear_with_taxes'] as $age_id => $item_price){
                $price['total_item_with_taxes'] += $item_price;
            }
        }
        /// apply discount
        if ($price_arr['discount']){
            $multiplier = (100 - $price_arr['discount'])/100;
            $price['total_item'] = $price['total_item']*$multiplier;
            $price['total_item_with_taxes'] = $price['total_item_with_taxes']*$multiplier;
        }
        
        if (isset($price_arr['services'])){
            foreach ($price_arr['services'] as $service_id => $service_prices){
                  $price['total_services'][$service_id] = 0;
                  $price['total_services_with_taxes'][$service_id] = 0;
                  foreach ($service_prices['clear'] as $age_id => $item_price){
                    $price['total_services'][$service_id] += $item_price;
                  }
                  foreach ($service_prices['clear_with_taxes'] as $age_id => $item_price){
                    $price['total_services_with_taxes'][$service_id] += $item_price;
                  }
            }
        }
        
        $price['total'] = $price['total_item'] + array_sum($price['total_services']);
        $price['total_with_taxes'] = $price['total_item_with_taxes'] + array_sum($price['total_services_with_taxes']) + array_sum($price['total_fees']);
        
        $price['deposit'] = $price_arr['deposit'];
        $price['total_deposit'] = isset($price_arr['deposit_fixed']) && $price_arr['deposit_fixed'] > 0 ? $price_arr['deposit_fixed'] : round($price['total_with_taxes']*$price_arr['deposit']/100, 2);
        $price['payment_model'] = $price_arr['payment_model'];
        
        $price = apply_filters('babe_obj_total_price', $price, $booking_obj_id, $price_arr);
        
        return $price;
    }

//////////////////////////////
    /**
	 * Get total prices array by booking_obj_id
     *
     * @param int $booking_obj_id
     * @param string $date_from - format Y-m-d H:i
     * @param array $guests
     * @param string $date_to - format Y-m-d H:i
     * @param array $services
     * @param array $fees
     *
     * @return array
	 */
    public static function get_obj_total_price_arr($booking_obj_id, $date_from, $guests = [], $date_to = '', $services = [], $fees = []){
        
        $prices = array();
        
        $date_to = !$date_to ? $date_from : $date_to;
        
        $begin = new DateTime( $date_from );
        $end = new DateTime( $date_to );
        
        $begin_check = new DateTime( $begin->format('Y-m-d') );
        $end_check = new DateTime( $end->format('Y-m-d') );
        
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($booking_obj_id);
        
        $rates = self::get_rates($booking_obj_id, $begin->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s'));
        
        $guests_for_obj = $rules_cat['rules']['ages'] ? $guests : array( 0 => array_sum($guests));
        
        if (
            $rules_cat['rules']['basic_booking_period'] == 'night'
            || $rules_cat['rules']['basic_booking_period'] == 'day'
            || $rules_cat['rules']['basic_booking_period'] == 'hour'
        ){
            //// get complex price
            
            if ($rules_cat['rules']['basic_booking_period'] == 'day' && $begin_check == $end_check){
              //  $end->modify( '+1 day' );
            }  
            
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval, $end);
            foreach($daterange as $date){
              $date_rates_arr[$date->format("Y-m-d")] = 0; //// initial dates arr
            }
            
            foreach ($rates as $rate){
                // workaround for base rate
                    $rate['date_from'] = $rate['date_from'] ? $rate['date_from'] : $date_from;
                    $rate['date_to'] = $rate['date_to'] ? $rate['date_to'] : $date_to;
                    
                    //////
                    $rate_date_from = new DateTime( $rate['date_from'] );
                    $rate_date_to = new DateTime( $rate['date_to'] );
                    
                    $rate_begin_obj = $rate_date_from < $begin ? clone($begin) : clone($rate_date_from);
                    $rate_end_obj = $rate_date_to > $end ? clone($end) : clone($rate_date_to);
                    
                    $date_subrange = new DatePeriod($rate_begin_obj, $interval, $rate_end_obj);
                    
                    $rate_start = '';
                    $rate_end = '';
                    $last_date = '';
                    
                    foreach($date_subrange as $date){
                        
                        $date_cal_day_num = BABE_Calendar_functions::get_week_day_num($date);
                        
                        if ( 
                          !$date_rates_arr[$date->format("Y-m-d")] 
                          && isset($rate['apply_days'][$date_cal_day_num]) 
                        ){
                            $rate_start = !$rate_start ? $date->format("Y-m-d H:i") : $rate_start;
                            $date_rates_arr[$date->format("Y-m-d")] = $rate['rate_id'];
                        } elseif ( 
                          (
                            ( !$date_rates_arr[$date->format("Y-m-d")]
                              && !isset($rate['apply_days'][$date_cal_day_num])
                            )
                            ||
                            ( $date_rates_arr[$date->format("Y-m-d")]
                              && $date_rates_arr[$date->format("Y-m-d")] != $rate['rate_id']
                             )
                           ) && $rate_start
                        ){
                            $rate_end = $last_date;
                        }
                        if ($rate_start && $rate_end){
                            //// add prices
                            $prices = self::calculate_price($rate_start, $rate_end, $rate, $guests_for_obj, $rules_cat, $prices);
                            
                            $rate_start = '';
                            $rate_end = '';
                        }
                        $last_date = $date->format("Y-m-d H:i");
                    }
                    if ($rate_start && !$rate_end){
                        if ($rules_cat['rules']['basic_booking_period'] == 'hour'){
                            $last_date = $rate_end_obj->format("Y-m-d H:i");
                        }
                    //// add prices
                    $prices = self::calculate_price($rate_start, $last_date, $rate, $guests_for_obj, $rules_cat, $prices);
                    }
            }      
            
        } else {
            //// get base price foreach guest 
            $rate = $rates[0];
            $rate_start = $date_from;
            $rate_end = $date_to;
            $prices = self::calculate_price($rate_start, $rate_end, $rate, $guests_for_obj, $rules_cat, $prices);
        }
        
        //// get discount
        $discount_arr = BABE_Post_types::get_post_discount($booking_obj_id);
        $prices += $discount_arr;
        
        $deposit = apply_filters('babe_deposit_percents', $rules_cat['rules']['deposit'], $booking_obj_id, $rules_cat );
        
        $prices['deposit'] = $rules_cat['rules']['payment_model'] != 'full' && $deposit && $deposit <= 100 && $deposit > 0 ? $deposit : 100;
        
        $prices['deposit_fixed'] = $rules_cat['rules']['payment_model'] != 'full' ? (float)get_post_meta($booking_obj_id, 'deposit_fixed', 1) : 0;
        
        $prices['payment_model'] = $rules_cat['rules']['payment_model'];

        /////

        foreach ($services as $service_id){
            $serv_tmp_prices = self::get_service_price($booking_obj_id, $service_id, $rules_cat, $date_from, $guests, $date_to, $prices);

            $prices['services'] = isset($prices['services']) ? $prices['services'] + $serv_tmp_prices['services'] : $serv_tmp_prices['services'];
        }

        /////

        foreach ($fees as $fee_id){
            $fee_tmp_prices = self::get_fee_price($booking_obj_id, $fee_id, $rules_cat, $date_from, $guests, $date_to, $prices);

            $prices['fees'] = isset($prices['fees']) ? $prices['fees'] + $fee_tmp_prices['fees'] : $fee_tmp_prices['fees'];
        }
        
        return $prices;
        
    }
    
///////////////////////////////    
    /**
	 * Calculate price with selected rate
     * @param string $rate_start - format Y-m-d H:i
     * @param string $rate_end - format Y-m-d H:i
     * @param array $rate
     * @param array $guests
     * @param array $rules_cat
     * @param array $prices
     * @return array
	 */
    public static function calculate_price($rate_start, $rate_end, $rate, $guests, $rules_cat, $prices){
    
      $days_total = 0;
      if ($rules_cat['rules']['basic_booking_period'] == 'single_custom' || $rules_cat['rules']['basic_booking_period'] == 'recurrent_custom'){
          $multiplier = 1;
      } else {
        $rate_date_from = new DateTime( $rate_start );
        $rate_date_to = new DateTime( $rate_end );

        $d_interval_start = date_diff($rate_date_from, $rate_date_to);

        $rate_date_to->modify( '+1 day' );
                      
        $d_interval = date_diff($rate_date_from, $rate_date_to);
        
        $days_total = $d_interval->format('%a'); // total days
        $multiplier = $days_total;

        if ( $rules_cat['rules']['basic_booking_period'] == 'hour' ){
            $multiplier = $d_interval_start->format('%a')*24 + $d_interval_start->format('%h');
        }

      }
      
      $tax_am = (float)apply_filters('babe_prices_calculate_price_post_tax', BABE_Post_types::get_post_tax($rules_cat['post_id']), $rules_cat['post_id'])/100;

      $signs = self::get_conditional_signs();
      $guests_total = array_sum($guests);
      $prices_arr = array();
      
      foreach ($guests as $age_id => $guests_number){
        
            if ( $guests_number ){
        
            $multiplier_local = $rules_cat['rules']['booking_mode'] != 'object' || $age_id ? $multiplier*$guests_number : $multiplier;
            $prices_arr['clear'][$age_id] = isset($prices['clear'][$age_id]) ? $prices['clear'][$age_id] : 0;
            ////////////////////
            
            $price_clear = isset($rate['price_general'][$age_id]) ? $rate['price_general'][$age_id]*$multiplier_local : (isset($rate['price_general'][0]) ? $rate['price_general'][0]*$multiplier_local : 0);
            
            /// check conditional prices
            if ( !empty($rate['prices_conditional']) ){
                foreach($rate['prices_conditional'] as $price_conditional){
                    
                    $check = false;
                    $first = false;
                    
                    if ( isset($price_conditional['conditional_guests_sign']) && isset($price_conditional['conditional_guests_number']) && isset($signs[$price_conditional['conditional_guests_sign']]) ){
                       $first = true; 
                       if( version_compare( (string)$guests_total, (string)$price_conditional['conditional_guests_number'], $signs[$price_conditional['conditional_guests_sign']]) ){
                          $check = true;
                       } else {
                          $check = false;
                       }
                    }
                    if ( $days_total && ( !$first || ($first && $check) ) && isset($price_conditional['conditional_units_sign']) && isset($price_conditional['conditional_units_number']) && isset($signs[$price_conditional['conditional_units_sign']]) ){
                       if( version_compare( (string)$days_total, (string)$price_conditional['conditional_units_number'], $signs[$price_conditional['conditional_units_sign']]) ){
                          $check = true;
                       } else {
                          $check = false;
                       }
                    }
                    if ($check){
                        $price_clear = isset($price_conditional['conditional_price'][$age_id]) ? $price_conditional['conditional_price'][$age_id]*$multiplier_local : (isset($price_conditional['conditional_price'][0]) ? $price_conditional['conditional_price'][0]*$multiplier_local : 0);
                    }
                    
                }
            }  //// end check conditional price
            ////////////////////
            
            $prices_arr['clear'][$age_id] += $price_clear;

            $prices_arr['clear_with_taxes'][$age_id] = isset($prices['clear_with_taxes'][$age_id]) ? $prices['clear_with_taxes'][$age_id] : 0;
            $prices_arr['clear_with_taxes'][$age_id] += $price_clear + round($price_clear * $tax_am, 2);
            
            } ///// end if $guests_number
      }
      
      return $prices_arr;

   }
    
///////////////////////////////    
    /**
	 * Get amount by service
     * 
     * @param int $booking_obj_id
     * @param int $service_id
     * @param array $rules_cat - rules with category_meta
     * @param string $date_from - format Y-m-d H:i
     * @param array $guests
     * @param string $date_to - format Y-m-d H:i
     * @param array $prices
     * @return array
	 */
    public static function get_service_price($booking_obj_id, $service_id, $rules_cat, $date_from, $guests = array(), $date_to = '', $prices = array()){
        
        $prices_arr = array();
        
        $date_to = !$date_to ? $date_from : $date_to;

        $tax_am = (float)apply_filters('babe_prices_get_service_price_post_tax', BABE_Post_types::get_post_tax($booking_obj_id), $booking_obj_id)/100;
        // $tax = 1 + $tax_am;
            
         /// get service meta
         $service_meta = (array)get_post_meta($service_id);
         foreach($service_meta as $key=>$val){
                $service_meta[$key] = maybe_unserialize($val[0]);
         }
         
         if (!isset($service_meta['prices'])){
            $service_meta['prices'][0] = 0;
         }
         
         if (isset($service_meta['service_type']) && isset($service_meta['price_type'])){
            $begin = new DateTime( $date_from );
            $end = new DateTime( $date_to );
            if ($service_meta['service_type'] == 'day' || $service_meta['service_type'] == 'person_day'){
              $end->modify( '+1 day' );
            }
            $d_interval = date_diff($begin, $end);
            $multiplier = $service_meta['service_type'] == 'person' || $service_meta['service_type'] == 'booking' ? 1 : $d_interval->format('%a'); // total days or nights
            
            if ($service_meta['service_type'] == 'booking' || $service_meta['service_type'] == 'day' || $service_meta['service_type'] == 'night'){  ///// per booking, per day, per night
                $price_clear = (float)$service_meta['prices'][0];
                if ($service_meta['service_type'] == 'booking' && $service_meta['price_type'] == 'percent'){
                    $obj_total_price = self::get_obj_total_price($booking_obj_id, $prices);
                    $multiplier = $price_clear/100;
                    $prices_arr['services'][$service_id]['clear'][0] = $obj_total_price['total_item']*$multiplier;
                    $prices_arr['services'][$service_id]['clear_with_taxes'][0] = round($obj_total_price['total_item_with_taxes']*$multiplier, 2);
                } else {
                    $prices_arr['services'][$service_id]['clear'][0] = $price_clear*$multiplier;
                    $prices_arr['services'][$service_id]['clear_with_taxes'][0] = ($price_clear + round($price_clear * $tax_am, 2))*$multiplier;   
                }
            } else { ///// per person, per person_day, per person_night
                $tmp_price = 0;
                
                foreach ($guests as $age_id => $guests_number){
                    
                    if ( $guests_number ){
                    
                      if (isset($service_meta['prices'][$age_id])){
                        $price_clear = (float)$service_meta['prices'][$age_id];
                        $tmp_price += $price_clear;
                        $prices_arr['services'][$service_id]['clear'][$age_id] = $price_clear*$guests_number*$multiplier;
                        $prices_arr['services'][$service_id]['clear_with_taxes'][$age_id] = ($price_clear + round($price_clear * $tax_am, 2))*$guests_number*$multiplier;                   
                      }
                    
                    }
                } //// end foreach $guests
                if (!$tmp_price && !empty($guests)){
                    ///// we have $service_meta['prices'][0] only and $guests without 0 index 
                    //// get total guests
                    $guests_number = array_sum($guests);
                        $price_clear = (float)$service_meta['prices'][0];
                        $tmp_price += $price_clear;
                        $prices_arr['services'][$service_id]['clear'][0] = $price_clear*$guests_number*$multiplier;
                        $prices_arr['services'][$service_id]['clear_with_taxes'][0] = ($price_clear + round($price_clear * $tax_am, 2))*$guests_number*$multiplier;
                }
            }  //// end if $service_meta['service_type'] == ...  
            
         } //// end if all service meta present
        
        return $prices_arr;
        
    }

///////////////////////////////
    /**
     * Get amount by fee
     *
     * @param int $booking_obj_id
     * @param int $fee_id
     * @param array $rules_cat - rules with category_meta
     * @param string $date_from - format Y-m-d H:i
     * @param array $guests
     * @param string $date_to - format Y-m-d H:i
     * @param array $prices
     * @return array
     */
    public static function get_fee_price($booking_obj_id, $fee_id, $rules_cat, $date_from, $guests = [], $date_to = '', $prices = []){

        $prices_arr = [];

        /// get fee meta
        $fee_meta = (array)get_post_meta($fee_id);
        foreach($fee_meta as $key=>$val){
            $fee_meta[$key] = maybe_unserialize($val[0]);
        }

        $price = isset($fee_meta['price']) ? (float)$fee_meta['price'] : 0;

        if ( $fee_meta['price_type'] == 'percent' ){
            $obj_total_price = self::get_obj_total_price($booking_obj_id, $prices);
            $prices_arr['fees'][$fee_id] = $obj_total_price['total_item_with_taxes']*$price/100;
        } else {
            $prices_arr['fees'][$fee_id] = $price;
        }

        return $prices_arr;

    }

///////////////////////////////

    
}

BABE_Prices::init(); 
   