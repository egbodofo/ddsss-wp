<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Calendar_functions Class.
 * 
 * @class 		BABE_Calendar_functions
 * @version		1.3.2
 * @author 		Booking Algorithms
 */

class BABE_Calendar_functions {

    // sunday number
    static $week_sunday = 0;
    
    // first day number on the calendar week line
    static $week_first_day = 0;
    
    // last day number on the calendar week line
    static $week_last_day = 6;
    
    // date format for admin js calendars
    static $date_format = 'd/m/Y';
    
    // DB tables
    static $table_av_cal;
    
    // months names
    static $months_names = array();

    // cache

    private static $av_cal = [];

    private static $av_guests = [];
    
///////////////////////////////////////    
    /**
	 * Setup vars based on start of week 
	 */
    public static function init() {
        global $wpdb;
        self::$table_av_cal = $wpdb->prefix.'babe_av_cal';
        
        if(get_option('start_of_week') != 0){
           self::$week_first_day = 1;
           self::$week_sunday = 7;
           self::$week_last_day = 7;
        }
        
        self::$months_names = self::get_months_arr();       
	}
///////////////////////////////////////
///////////////////////////////////////
    /**
	 * Get months locale names.
     * @return array
	 */
    public static function get_months_arr(){ 
    
    return array(
      'January' => __('January', BABE_TEXTDOMAIN ),
      'February' => __('February', BABE_TEXTDOMAIN ),
      'March' => __('March', BABE_TEXTDOMAIN ),
      'April' => __('April', BABE_TEXTDOMAIN ),
      'May' => __('May', BABE_TEXTDOMAIN ),
      'June' => __('June', BABE_TEXTDOMAIN ),
      'July' => __('July', BABE_TEXTDOMAIN ),
      'August' => __('August', BABE_TEXTDOMAIN ),
      'September' => __('September', BABE_TEXTDOMAIN ),
      'October' => __('October', BABE_TEXTDOMAIN ),
      'November' => __('November', BABE_TEXTDOMAIN ),
      'December' => __('December', BABE_TEXTDOMAIN ),  
     );
          
    }
    
///////////////////////////////////////
    /**
	 * Get months locale names.
     * @return array
	 */
    public static function get_months_arr_short(){ 
    
    return array(
      'Jan' => __('Jan', BABE_TEXTDOMAIN ),
      'Feb' => __('Feb', BABE_TEXTDOMAIN ),
      'Mar' => __('Mar', BABE_TEXTDOMAIN ),
      'Apr' => __('Apr', BABE_TEXTDOMAIN ),
      'May' => __('May', BABE_TEXTDOMAIN ),
      'Jun' => __('Jun', BABE_TEXTDOMAIN ),
      'Jul' => __('Jul', BABE_TEXTDOMAIN ),
      'Aug' => __('Aug', BABE_TEXTDOMAIN ),
      'Sep' => __('Sep', BABE_TEXTDOMAIN ),
      'Oct' => __('Oct', BABE_TEXTDOMAIN ),
      'Nov' => __('Nov', BABE_TEXTDOMAIN ),
      'Dec' => __('Dec', BABE_TEXTDOMAIN ),  
     );
          
    }
    
///////////////////////////////////////
    /**
	 * Get week days ODBC indexes (for MySQL DAYOFWEEK()) from PHP indexes.
     * 
     * @return array
	 */
    public static function week_days_to_odbc_arr(){ 
    
    return !self::$week_sunday ? array(
      0 => 1,
      1 => 2,
      2 => 3,
      3 => 4,
      4 => 5,
      5 => 6,
      6 => 7,   
     ) : array(
      1 => 2,
      2 => 3,
      3 => 4,
      4 => 5,
      5 => 6,
      6 => 7,
      7 => 1,   
     );     
    }        
    
///////////////////////////////////////
    /**
	 * Get week days short names.
     * @return array
	 */
    public static function get_week_days_arr(){ 
    
    return !self::$week_sunday ? array(
      0 => __('Sun', BABE_TEXTDOMAIN ),
      1 => __('Mon', BABE_TEXTDOMAIN ),
      2 => __('Tue', BABE_TEXTDOMAIN ),
      3 => __('Wed', BABE_TEXTDOMAIN ),
      4 => __('Thu', BABE_TEXTDOMAIN ),
      5 => __('Fri', BABE_TEXTDOMAIN ),
      6 => __('Sat', BABE_TEXTDOMAIN ),   
     ) : array(
      1 => __('Mon', BABE_TEXTDOMAIN ),
      2 => __('Tue', BABE_TEXTDOMAIN ),
      3 => __('Wed', BABE_TEXTDOMAIN ),
      4 => __('Thu', BABE_TEXTDOMAIN ),
      5 => __('Fri', BABE_TEXTDOMAIN ),
      6 => __('Sat', BABE_TEXTDOMAIN ),
      7 => __('Sun', BABE_TEXTDOMAIN ),   
     );     
    }
    
///////////////////////////////////////
    /**
	 * Get week days short names.
     * @return array
	 */
    public static function get_week_days_arr_2(){ 
    
    return !self::$week_sunday ? array(
      0 => __('Su', BABE_TEXTDOMAIN ),
      1 => __('Mo', BABE_TEXTDOMAIN ),
      2 => __('Tu', BABE_TEXTDOMAIN ),
      3 => __('We', BABE_TEXTDOMAIN ),
      4 => __('Th', BABE_TEXTDOMAIN ),
      5 => __('Fr', BABE_TEXTDOMAIN ),
      6 => __('Sa', BABE_TEXTDOMAIN ),   
     ) : array(
      1 => __('Mo', BABE_TEXTDOMAIN ),
      2 => __('Tu', BABE_TEXTDOMAIN ),
      3 => __('We', BABE_TEXTDOMAIN ),
      4 => __('Th', BABE_TEXTDOMAIN ),
      5 => __('Fr', BABE_TEXTDOMAIN ),
      6 => __('Sa', BABE_TEXTDOMAIN ),
      7 => __('Su', BABE_TEXTDOMAIN ),   
     );     
    }    

///////////////////////////////////////
    /**
	 * Get week day short name by its number.
     * @param int $i - week day number.
     * @return array
	 */
    public static function get_week_day($i){
      $arr = self::get_week_days_arr();
      if ($i > 7 || $i < 0) $i = 1;
      $i = $i%7;
      if (self::$week_sunday && $i==0){
            $i = 7; 
      }
       
      return $arr[$i];
    }

///////////////////////////////////////
    /**
	 * Get week days short names list.
     * @return array
	 */
    public static function cmb2_get_week_options(){
        return self::get_week_days_arr();    
    }

///////////////////////////////////////
    /**
	 * Get week day number.
     * 
     * @param Date Object $date_obj (PHP).
     * 
     * @return int
	 */
    public static function get_week_day_num($date_obj){
        $day_num = !self::$week_sunday ? $date_obj->format("w") : $date_obj->format("N");
        return $day_num;
    }

///////////////////////////////////////
    /**
	 * Get next week day number.
     * @param int - current day number.
     * @return int
	 */
    public static function get_next_week_day_num($w){
        $w = ($w+1)%7;
        if (self::$week_sunday && $w==0){
            $w = 7; 
        }
        return $w;
    }

///////////////////////////////////////
    /**
	 * Is the day number - last day number on the calendar week line?
     * @param int - day number.
     * @return boolean
	 */
    public static function is_week_day_weekend($w){
        return (self::$week_last_day == $w) ? true : false; 
    }
///////////////////////////////////////
    /**
	 * Is date is valid date
     * @param string $date.
     * @param string $format - PHP date format
     * @return boolean
	 */
    public static function isValidDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, esc_attr($date));
        return $d && $d->format($format) == $date; 
    }

///////////////////////
     /**
	 * Is time is valid time
     * @param string $time
     * @param string $format - PHP time format
     * @return boolean
	 */
    public static function isValidTime($time, $format = ''){
        $format = $format ? 'Y-m-d '.$format : 'Y-m-d '.get_option('time_format');
        $date = '2017-01-01 '.$time;
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date; 
    }
    
////////////////////////
     /**
	 * Convert d/m/Y or m/d/Y to SQL format
     * @param string $date
     * @return string
	 */
     public static function date_to_sql($date){    
        $d = DateTime::createFromFormat(BABE_Settings::$settings['date_format'], $date);
        return $d ? $d->format('Y-m-d') : '';
     }
////////////////////////
     /**
	 * Convert SQL date format to d/m/Y or m/d/Y
     * @param string $date
     * @return string
	 */
     public static function date_from_sql($date){
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d ? $d->format(BABE_Settings::$settings['date_format']) : '';
     }
        
////////////////////////
     /**
	 * Update availability calendar
     * 
     * @param int $booking_obj_id
     * @param string $date_from - d/m/Y or m/d/Y
     * @param string $date_to - d/m/Y or m/d/Y
     * @param array $schedule
     * @param int $cyclic_start_every
     * @param int $cyclic_av
     * 
     * @return
	 */
     public static function update_av_cal($booking_obj_id, $date_from, $date_to, $schedule = array(), $cyclic_start_every = 0, $cyclic_av = 0){
        
        global $wpdb;
        
        $date_start = self::date_to_sql($date_from);
        $date_end = self::date_to_sql($date_to);
        $cyclic_start_every = absint($cyclic_start_every);
        $cyclic_av = absint($cyclic_av);
        
        /// normalize
        if ($cyclic_start_every > 1){
            $cyclic_av = !$cyclic_av ? 1 : $cyclic_av;
            $cyclic_start_every = $cyclic_start_every <= $cyclic_av ? 0 : $cyclic_start_every;
        } else {
            $cyclic_start_every = 0;
        }
        
        $where_clauses = '';
        
        $av_cal_all = $wpdb->get_results("SELECT * FROM ".self::$table_av_cal." WHERE booking_obj_id = '".$booking_obj_id."' ORDER BY date_from ASC", ARRAY_A);
        
        if (!empty($av_cal_all)){
            foreach($av_cal_all as $item){ 
               $date_arr[$item['date_from']] = 0;                
            }
        } else {
            $date_arr = array();
        }
        
        
        $new_date_arr = array();
        
        $begin = new DateTime( $date_start );
        $end = new DateTime( $date_end );
        $end->modify( '+1 day' );
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        $av_date = true;
        //$cyclic
        $test_start_date = clone($begin);
        $test_end_date = clone($end);
        if ($cyclic_start_every){
            $test_end_date = clone($begin);
            $test_end_date->modify("+".($cyclic_av - 1)." days");
        }
        
        foreach($daterange as $date){
            
            if ($cyclic_start_every && $test_start_date == $date){
                $av_date = true;
            }
            
            /////
            if ($av_date){
            
            $day_num = self::get_week_day_num($date);
            if(!empty($schedule)){
                if(isset($schedule[$day_num])){
                foreach($schedule[$day_num] as $time){
                    $cur_date = new DateTime($date->format('Y-m-d').' '.$time);
                    if (isset($date_arr[$cur_date->format('Y-m-d H:i:s')])){
                        $date_arr[$cur_date->format('Y-m-d H:i:s')] = 1;
                    } else {
                        $new_date_arr[$cur_date->format('Y-m-d H:i:s')] = 1;
                    } 
                } //// end foreach $schedule[$day_num]
              } /// end if isset($schedule[$day_num])  
            } else {
                if (isset($date_arr[$date->format('Y-m-d H:i:s')])){
                        $date_arr[$date->format('Y-m-d H:i:s')] = 1;
                    } else {
                        $new_date_arr[$date->format('Y-m-d H:i:s')] = 1;
                    }
            }
            
            }
            ////
            
            if ($cyclic_start_every && $test_end_date == $date){
                $av_date = false;
                $test_start_date->modify("+".$cyclic_start_every." days");
                $test_end_date = clone($test_start_date);
                $test_end_date->modify("+".($cyclic_av-1)." days");  
            }
               
        }
        
        /// reset in_schedule to 0 where $date_arr = 0
        $reset_arr = array();
        foreach($date_arr as $date_sql => $val){
            if (!$val){
                $reset_arr[] = "'".$date_sql."'";
            }
        }
        
        $prepare_result = $wpdb->query( "UPDATE ".self::$table_av_cal." SET in_schedule = 1 WHERE booking_obj_id = ".$booking_obj_id." AND in_schedule = 2" );
        
        if (!empty($reset_arr)){
            
            $in_statement = implode(", ", $reset_arr);
            $result = $wpdb->query( "UPDATE ".self::$table_av_cal." SET in_schedule = 2 WHERE booking_obj_id = ".$booking_obj_id." AND date_from IN (".$in_statement.")" );
   
        }
   
        /// add dates from $new_date_arr to schedule
        self::add_dates_to_av_cal($booking_obj_id, $new_date_arr);
        
        /// clear av_cal
        $wpdb->query( $wpdb->prepare( 'DELETE FROM '.self::$table_av_cal.' WHERE booking_obj_id = %d AND in_schedule = 2 AND guests = 0', $booking_obj_id ) );
        
        self::update_av_cal_excluded_dates($booking_obj_id);
        
        return;
        
     }
     
///////////////////////    
    /**
	 * Delete av cal by booking object id
     * 
     * @param int $booking_obj_id
     * 
     * @return int
	 */
    public static function delete_av_cal_by_booking_obj_id($booking_obj_id){
        global $wpdb;
        
        $output = 0;
        
        $booking_obj_id = absint($booking_obj_id); 
        $old_av_cal = $wpdb->get_results("SELECT * FROM ".self::$table_av_cal." WHERE booking_obj_id = ".$booking_obj_id, ARRAY_A);
       
       if(!empty($old_av_cal)){
           /// delete from DB
           $wpdb->query( $wpdb->prepare( 'DELETE FROM '.self::$table_av_cal.' WHERE booking_obj_id = %d', $booking_obj_id ) );
           
           $output = 1;
       }
            
       return $output;  
    }     
     
////////////////////////
     /**
	 * Update availability calendar excluded dates
     * 
     * @param int $booking_obj_id
     * 
     * @return
	 */
     public static function update_av_cal_excluded_dates($booking_obj_id){
        
        global $wpdb;
        
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($booking_obj_id);
        $categories_week_arr = isset($rules_cat['category_meta']) && isset($rules_cat['category_meta']['categories_week']) ? (array)$rules_cat['category_meta']['categories_week'] : array();
        $categories_week = !empty($categories_week_arr) ? array_flip($categories_week_arr) : array();
        
        $week_days = self::get_week_days_arr();
        $odbc_days = self::week_days_to_odbc_arr();
        
        $exclude_daynums = array();
        
        foreach ($week_days as $day_num => $day_title){
            
            if (!isset($categories_week[$day_num])){
                $exclude_daynums[] = $odbc_days[$day_num];
            }
            
        }
        
        $excluded_dates_statement = "";
        
        if (!empty($exclude_daynums)){
            $excluded_dates_statement .= " OR DAYOFWEEK(date_from) IN (".implode(", ", $exclude_daynums).")";   
        }
        
        $excluded_dates_meta = (array)get_post_meta( $booking_obj_id, 'excluded_dates', 1 );        
        
        if (!empty($excluded_dates_meta)){
            
            foreach($excluded_dates_meta as $excluded_date){
                
                if (is_array($excluded_date) && isset($excluded_date['excluded_date']) && self::isValidDate($excluded_date['excluded_date'], BABE_Settings::$settings['date_format'])){
                    
                    $date_exc_obj = new DateTime(self::date_to_sql($excluded_date['excluded_date']));
                    
                    $excluded_dates_statement .= " OR date_from LIKE '".$date_exc_obj->format('Y-m-d')." %'";
                    
                }
                
            }
            
        }
        
        $prepare_result = $wpdb->query( "UPDATE ".self::$table_av_cal." SET in_schedule = 1 WHERE booking_obj_id = ".$booking_obj_id." AND in_schedule = 0" );
        
        if ($excluded_dates_statement){
            
            $excluded_dates_statement = substr($excluded_dates_statement, 3);
        
            $result = $wpdb->query( "UPDATE ".self::$table_av_cal." SET in_schedule = 0 WHERE booking_obj_id = ".$booking_obj_id." AND (".$excluded_dates_statement.")" );
        
        }
        
        return;
        
     }     
     
////////////////////////
     /**
	 * Add dates to availability calendar
     * 
     * @param int $booking_obj_id
     * @param array $new_date_arr
     * 
     * @return
	 */
     public static function add_dates_to_av_cal($booking_obj_id, $new_date_arr){
        
        global $wpdb;
        
        if (!empty($new_date_arr)){
            
            $sql = "INSERT INTO ".self::$table_av_cal." (booking_obj_id,date_from,guests,in_schedule) VALUES ";
            $start_loop = true;
            foreach($new_date_arr as $date_sql => $val){
                
               if (!$start_loop) {
                  $sql .= ", ";
               } else {
                  $start_loop = false;
               }
                
               $sql .= "(".$booking_obj_id.",'".$date_sql."',0,1)";
            }
            $sql .= " ON DUPLICATE KEY UPDATE guests=VALUES(guests),in_schedule=VALUES(in_schedule)";
            
            $new_result = $wpdb->query($sql); /// db optimized
        }
     
        return;
     }           

////////////////////////
     /**
	 * Get availability calendar
     * @param int $booking_obj_id
     * @param string $date_from - Y-m-d H:i:s, must be valid
     * @param string $date_to - Y-m-d H:i:s
     * @param array $order_item_args
     * @return array
	 */
     public static function get_av_cal($booking_obj_id, $date_from = '', $date_to = '', $order_item_args = []){
        
        global $wpdb;
        
        $output = [];

         ////// try to found in cache

         // create hash of the query args
         $args_hash = hash('sha256', $booking_obj_id.$date_from.$date_to.json_encode($order_item_args, 512));

         if ( isset( self::$av_cal[$args_hash] ) ){
             return self::$av_cal[$args_hash];
         }

         ////////////////////////
        
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($booking_obj_id);
        
        $stop_booking_before = $rules_cat['rules']['stop_booking_before'] ? absint(get_post_meta( $booking_obj_id, 'stop_booking_before', true )) : 0;        
        
        // normalize dates
        
        $date_now_obj = BABE_Functions::datetime_local();
        
        $date_to = !$date_from ? date("Y-m-d", strtotime('+'. absint(BABE_Settings::$settings['av_calendar_max_months']) . ' months')) : (!$date_to ? $date_from : $date_to);
        $date_from = !$date_from ? $date_now_obj->format("Y-m-d") : $date_from;

        $date_from_obj = new DateTime($date_from);
        $date_to_obj = new DateTime($date_to);
        
        if($date_from_obj == $date_to_obj){
           $date_to_obj = new DateTime($date_from_obj->format('Y-m-d 23:59:59')); 
        }
        
        $today_obj = BABE_Functions::datetime_local();
        
        //// check stop booking before ... hours //////////
        
        if ($today_obj->format('Y-m-d') == $date_from_obj->format('Y-m-d')){
            if ($rules_cat['rules']['basic_booking_period'] == 'recurrent_custom'){
                $today_obj->modify( '+'.$stop_booking_before.' hours' );
                if ($today_obj >= $date_to_obj) {
                    return $output;
                } elseif ($today_obj >= $date_from_obj){
                    $date_from_obj = new DateTime($today_obj->format('Y-m-d H:i'));
                } 
            }
        }
        
        $item_max_guests = absint(get_post_meta( $booking_obj_id, 'guests', 1 ));
 
        $max_guests = $item_max_guests * BABE_Post_types::get_post_items_number($booking_obj_id);
        
        $max_guests_add = !empty($order_item_args) && isset($order_item_args['booking_obj_id']) && $booking_obj_id == $order_item_args['booking_obj_id'] ? array_sum($order_item_args['guests']) : 0;
        
        if ($max_guests_add){
            
            if ($rules_cat['rules']['booking_mode'] == 'object'){
                $max_guests_add = max($max_guests_add, $item_max_guests);
            }
            
            if ($rules_cat['rules']['basic_booking_period'] == 'night'){
            
             $date_tmp_from = new DateTime($order_item_args['date_from']);
             $date_tmp_to = new DateTime($order_item_args['date_to']);
            
             $date_test_from_obj = new DateTime($date_tmp_from->format('Y-m-d'));
             $date_test_to_obj = new DateTime($date_tmp_to->format('Y-m-d'));
             
           } else {
             $date_test_from_obj = new DateTime($order_item_args['date_from']);
             $date_test_to_obj = new DateTime($order_item_args['date_to']);
           }
            
            if ($date_from_obj >= $date_test_from_obj){
                $date_from_obj = new DateTime($date_test_from_obj->format('Y-m-d H:i'));
            }
         }        
        
        //////////////////
        
        $datetime_from = $date_from_obj->format('Y-m-d H:i:s');
        $datetime_to = $date_to_obj->format('Y-m-d H:i:s');
        
        ///////////////
       
       if (self::$week_sunday){
           $av_day_exp = "IF( DATE_FORMAT(av.date_from, '%w') < 1, 7, DATE_FORMAT(av.date_from, '%w') )";
       } else {
           $av_day_exp = "DATE_FORMAT(av.date_from, '%w')";
       }
       
       //////////////
        
        //$guests_filter = $rules_cat['rules']['booking_mode'] == 'object' ? "guests = 0" : "guests < ".$max_guests;
        $guests_filter = "av.guests <= ".$max_guests;
        
        $query = "SELECT DISTINCT *, DATE_FORMAT(av.date_from, '%Y-%m-%d') AS cal_date, DATE_FORMAT(av.date_from, '%H:%i') AS cal_time, CAST(DATE_FORMAT(av.date_from, '%Y') AS UNSIGNED) AS cal_year, CAST(DATE_FORMAT(av.date_from, '%m') AS UNSIGNED) AS cal_month, CAST(DATE_FORMAT(av.date_from, '%d') AS UNSIGNED) AS cal_day, (".$max_guests." - av.guests) AS av_guests, ".$av_day_exp." AS cal_day_num, IF( LOCATE( CONCAT('i:', ".$av_day_exp.", ';'), t_rate.start_days) > 0, 1, 0) AS start_day
        FROM ".self::$table_av_cal." av
        
        INNER JOIN # get rates
        (
        SELECT rate_id, booking_obj_id AS rate_booking_obj_id, rate_title, date_from AS rate_date_from, date_to AS rate_date_to, apply_days, start_days, min_booking_period, max_booking_period, price_from, price_general, prices_conditional, rate_order
        FROM ".BABE_Prices::$table_rate."
        ORDER BY rate_booking_obj_id ASC, rate_order ASC, price_from ASC, rate_date_from DESC, rate_date_to DESC
        LIMIT 10000
        ) t_rate ON av.booking_obj_id = t_rate.rate_booking_obj_id AND ( t_rate.rate_date_to >= av.date_from OR t_rate.rate_date_to IS NULL ) AND ( t_rate.rate_date_from <= av.date_from OR t_rate.rate_date_from IS NULL ) AND ( LOCATE( CONCAT('i:', ".$av_day_exp.", ';'), t_rate.apply_days) > 0 )
        
        WHERE (
           av.booking_obj_id = ".$booking_obj_id."
          AND
           ".$guests_filter."
          AND
           av.in_schedule = 1
          AND av.date_from >= '".$datetime_from."'
          AND av.date_from <= '".$datetime_to."'
        )
        
        GROUP BY av.date_from
        ORDER BY av.date_from ASC, t_rate.rate_order ASC
";

        /// get av_cal
        $av_cal = $wpdb->get_results($query, ARRAY_A);
        
        if (!empty($av_cal)){
        $before_date = '';
        
        foreach($av_cal as $cal_row){
          
          if ($before_date != $cal_row['cal_date']){
            $output[$cal_row['cal_date']]['date'] = $cal_row['cal_date'];
            $output[$cal_row['cal_date']]['year'] = $cal_row['cal_year'];
            $output[$cal_row['cal_date']]['month'] = $cal_row['cal_month'];
            $output[$cal_row['cal_date']]['day'] = $cal_row['cal_day'];
            
            $output[$cal_row['cal_date']]['day_num'] = $cal_row['cal_day_num'];
            $output[$cal_row['cal_date']]['rate_id'] = $cal_row['rate_id'];
            $output[$cal_row['cal_date']]['rate_title'] = $cal_row['rate_title'];
            $output[$cal_row['cal_date']]['rate_date_from'] = $cal_row['rate_date_from'];
            $output[$cal_row['cal_date']]['rate_date_to'] = $cal_row['rate_date_to'];
            $output[$cal_row['cal_date']]['apply_days'] = maybe_unserialize($cal_row['apply_days']);
            $output[$cal_row['cal_date']]['start_days'] = maybe_unserialize($cal_row['start_days']);
            $output[$cal_row['cal_date']]['start_day'] = $cal_row['start_day'];
            $output[$cal_row['cal_date']]['min_booking_period'] = $cal_row['min_booking_period'];
            $output[$cal_row['cal_date']]['max_booking_period'] = $cal_row['max_booking_period'];
            $output[$cal_row['cal_date']]['price_from'] = $cal_row['price_from'];
            $output[$cal_row['cal_date']]['price_general'] = maybe_unserialize($cal_row['price_general']);
            $output[$cal_row['cal_date']]['prices_conditional'] = maybe_unserialize($cal_row['prices_conditional']);
            $output[$cal_row['cal_date']]['rate_order'] = $cal_row['rate_order'];
            
            $before_date = $cal_row['cal_date'];
         }
         
         $curren_date_obj = new DateTime($cal_row['date_from']);
         
         $cal_row_av_guests = absint($cal_row['av_guests']) >= $item_max_guests ? $item_max_guests : absint($cal_row['av_guests']);
         
         if ($max_guests_add && $curren_date_obj >= $date_test_from_obj && $curren_date_obj <= $date_test_to_obj){
            $test_av_guests = $cal_row_av_guests + $max_guests_add;
            
            if (
                (
                    ( $rules_cat['rules']['basic_booking_period'] == 'day'
                        || $rules_cat['rules']['basic_booking_period'] == 'hour'
                    )
                    && $cal_row['cal_time'] == '00:00'
                )
                || (
                    $rules_cat['rules']['basic_booking_period'] != 'day'
                    || $rules_cat['rules']['basic_booking_period'] != 'hour'
                )
            ){
                $output[$cal_row['cal_date']]['times'][$cal_row['cal_time']] = $rules_cat['rules']['booking_mode'] == 'object' && $test_av_guests < $item_max_guests ? 0: $test_av_guests;
            }

         } else {
            
            $output[$cal_row['cal_date']]['times'][$cal_row['cal_time']] = $rules_cat['rules']['booking_mode'] == 'object' && $cal_row_av_guests < $item_max_guests ? 0: $cal_row_av_guests;
            
         }
         
         if (
             (
                 $rules_cat['rules']['basic_booking_period'] == 'day'
                 || $rules_cat['rules']['basic_booking_period'] == 'hour'
             )
             &&
             $output[$cal_row['cal_date']]['min_booking_period']
         ){
             $output[$cal_row['cal_date']]['start_day'] = $output[$cal_row['cal_date']]['times'][$cal_row['cal_time']] ? $cal_row['start_day'] : 0;
         }
         
        } /// end foreach $av_cal 
        }

         self::$av_cal[$args_hash] = $output;
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Check booking obj availability
     * @param int $booking_obj_id
     * @param string $date_from - Y-m-d H:i:s, must be valid
     * @param string $date_to - Y-m-d H:i:s
     * @param array $guests_arr
     * @param array $order_item_args
     * 
     * @return int
	 */
     public static function check_booking_obj_av($booking_obj_id, $date_from = '', $date_to = '', $guests_arr = array(), $order_item_args = array()){
        
        $output = 0;
        
        $guests = array_sum($guests_arr);
        
        if ($guests > 0){
            
            $av_guests = self::get_av_guests($booking_obj_id, $date_from, $date_to, $order_item_args);
            
            $output = $av_guests >= $guests ? $av_guests : 0;
            
        }
        
        return $output;
        
     }     
     
////////////////////////
     /**
	 * Get availability guests number
     * @param int $booking_obj_id
     * @param string $date_from - Y-m-d H:i:s, must be valid
     * @param string $date_to - Y-m-d H:i:s
     * @param array $order_item_args
     * 
     * @return int
	 */
     public static function get_av_guests($booking_obj_id, $date_from = '', $date_to = '', $order_item_args = []){
        
        global $wpdb;
        
        $output = 0;

         ////// try to found in cache

         // create hash of the query args
         $args_hash = hash('sha256', $booking_obj_id.$date_from.$date_to.json_encode($order_item_args, 512));

         if ( isset( self::$av_guests[$args_hash] ) ){
             return self::$av_guests[$args_hash];
         }

         /////////////////////

         $booking_obj_id = absint($booking_obj_id);
        
        $item_max_guests = absint(get_post_meta( $booking_obj_id, 'guests', 1 ));
 
        $max_guests = $item_max_guests * BABE_Post_types::get_post_items_number($booking_obj_id);
        
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($booking_obj_id);
        
        $stop_booking_before = $rules_cat['rules']['stop_booking_before'] ? absint(get_post_meta( $booking_obj_id, 'stop_booking_before', 1 )) : 0;
        
        // normalize dates
        $date_now_obj = BABE_Functions::datetime_local();
        
        $date_to = !$date_from ? date("Y-m-d", strtotime("+1 year")) : (!$date_to ? $date_from : $date_to);
        $date_from = !$date_from ? $date_now_obj->format("Y-m-d") : $date_from;

        $date_from_obj = new DateTime($date_from);
        $date_to_obj = new DateTime($date_to);
        
        if ($rules_cat['rules']['basic_booking_period'] == 'single_custom'){
            $date_from_obj = new DateTime($date_from_obj->format('Y-m-d 00:00:00'));
            $date_to_obj = new DateTime($date_from_obj->format('Y-m-d 23:59:59'));   
        }
        
        if( $date_from_obj == $date_to_obj 
            && ( $rules_cat['rules']['basic_booking_period'] != 'recurrent_custom'
               || ( $rules_cat['rules']['basic_booking_period'] == 'recurrent_custom' && $date_from_obj->format('H:i') == '00:00' )
            )
        ){
           $date_to_obj = new DateTime($date_from_obj->format('Y-m-d 23:59:59')); 
        }
        
        $today_obj = BABE_Functions::datetime_local();
        
        //// check stop booking before ... hours //////////
        if ($today_obj->format('Y-m-d') == $date_from_obj->format('Y-m-d')){
            if ($rules_cat['rules']['basic_booking_period'] == 'recurrent_custom'){
                $today_obj->modify( '+'.$stop_booking_before.' hours' );
                if ($today_obj >= $date_to_obj) {
                    return 0;
                } elseif ($today_obj >= $date_from_obj){
                    $date_from_obj = new DateTime($today_obj->format('Y-m-d H:i'));
                }  
            }
        }
        
        $max_guests_add = !empty($order_item_args) && isset($order_item_args['booking_obj_id']) && $booking_obj_id == $order_item_args['booking_obj_id'] ? array_sum($order_item_args['guests']) : 0;
        
        if ($max_guests_add){
            
            if ($rules_cat['rules']['booking_mode'] == 'object'){
                $max_guests_add = max($max_guests_add, $item_max_guests);
            }
            
           if ($rules_cat['rules']['basic_booking_period'] == 'night'){
            
             $date_tmp_from = new DateTime($order_item_args['date_from']);
             $date_tmp_to = new DateTime($order_item_args['date_to']);
            
             $date_test_from_obj = new DateTime($date_tmp_from->format('Y-m-d'));
             $date_test_to_obj = new DateTime($date_tmp_to->format('Y-m-d'));
           } else {
             $date_test_from_obj = new DateTime($order_item_args['date_from']);
             $date_test_to_obj = new DateTime($order_item_args['date_to']);
           }
         }
        
        /////////hold support///////
        
        if (( $rules_cat['rules']['basic_booking_period'] == 'day' || $rules_cat['rules']['basic_booking_period'] == 'hour' ) && $rules_cat['rules']['hold']){
            $date_from_obj->modify('-'.$rules_cat['rules']['hold'].' hours');
            $date_from_obj->modify('+2 minutes');
            $date_to_obj->modify('+'.$rules_cat['rules']['hold'].' hours');
            $date_to_obj->modify('-2 minutes');
        }
        
        $datetime_from = $date_from_obj->format('Y-m-d H:i:s');
        $datetime_to = $date_to_obj->format('Y-m-d H:i:s');
        
        $query = "SELECT *, DATE_FORMAT(date_from, '%H:%i') AS cal_time, (".$max_guests." - guests) AS av_guests
        FROM ".self::$table_av_cal."
        
        WHERE (
           booking_obj_id = ".$booking_obj_id."
          AND date_from ".($rules_cat['rules']['basic_booking_period'] == 'hour' ? ">" : ">=")." '".$datetime_from."'
          AND date_from ".($rules_cat['rules']['basic_booking_period'] == 'night' || $rules_cat['rules']['basic_booking_period'] == 'hour' ? "<" : "<=")." '".$datetime_to."'
        )
        
        ORDER BY date_from ASC    
";
        /// get av_cal
        
        $av_cal = $wpdb->get_results($query, ARRAY_A);
        
        $av_guests_arr = array();
        
        if (!empty($av_cal)){
            
            $d_interval = date_diff($date_from_obj, $date_to_obj);
            $days_total = $d_interval->format('%a'); // total days
            if ($rules_cat['rules']['basic_booking_period'] != 'night' || !$days_total){
                $days_total = $days_total + 1;
            }
            
            $days_count = 0;
            $prev_date = '';
        
        foreach($av_cal as $cal_row){
            
            if( $cal_row['in_schedule'] != 1 && $cal_row['cal_time'] == '00:00' ){
                return 0;
            }
         
         $curren_date_obj = new DateTime($cal_row['date_from']);
         
         if ($prev_date != $curren_date_obj->format('Y-m-d')){
            $prev_date = $curren_date_obj->format('Y-m-d');
            $days_count++;
         }
         
         $cal_row_av_guests = absint($cal_row['av_guests']) >= $item_max_guests ? $item_max_guests : absint($cal_row['av_guests']);
         
         if ($max_guests_add && $curren_date_obj >= $date_test_from_obj && $curren_date_obj <= $date_test_to_obj){
            $test_av_guests = $cal_row_av_guests + $max_guests_add;
            
            if (
                (
                    (
                        $rules_cat['rules']['basic_booking_period'] == 'day'
                        || $rules_cat['rules']['basic_booking_period'] == 'hour'
                    )
                    && $cal_row['cal_time'] == '00:00'
                )
                || (
                    $rules_cat['rules']['basic_booking_period'] != 'day'
                    && $rules_cat['rules']['basic_booking_period'] != 'hour'
                )
            ){
                $av_guests_arr[] = $rules_cat['rules']['booking_mode'] == 'object' && $test_av_guests < $item_max_guests ? 0 : $test_av_guests;
                
            }
            
         } else {
            
            $av_guests_arr[] = $rules_cat['rules']['booking_mode'] == 'object' && $cal_row_av_guests < $item_max_guests ? 0 : $cal_row_av_guests;
            
         }         
         
        }
        
        $output = $rules_cat['rules']['basic_booking_period'] == 'recurrent_custom' && $rules_cat['rules']['booking_mode'] != 'object' ? max($av_guests_arr) : min($av_guests_arr);
        
        if ($days_count < $days_total){
            $output = 0;
        }
        
        } elseif (
            (
                $rules_cat['rules']['basic_booking_period'] == 'day'
                || $rules_cat['rules']['basic_booking_period'] == 'hour'
            )
            && $date_from_obj->format('Y-m-d') == $date_to_obj->format('Y-m-d')
        ){
            
            $av_cal = self::get_av_cal($booking_obj_id, $date_from_obj->format('Y-m-d 00:00:00'), $date_from_obj->format('Y-m-d 23:59:59'), $order_item_args);
            
            if (!empty($av_cal)){
                $is_free_time = false;
                foreach($av_cal[$date_from_obj->format('Y-m-d')]['times'] as $time => $time_guests){
                    $cmp_date = new DateTime($date_from_obj->format('Y-m-d '.$time));
                    if ($cmp_date < $date_from_obj){
                        $is_free_time = $time_guests ? true : false;
                    }
                }
                
                if ($is_free_time){
                    $output = $item_max_guests;
                }
            }
        }

         self::$av_guests[$args_hash] = $output;
        
        return $output;
        
     }
     
////////////////////////
     /**
	 * Update (add or substract) guests number
     * @param int $booking_obj_id
     * @param string $date_from - Y-m-d H:i:s, must be valid
     * @param string $date_to - Y-m-d H:i:s
     * @param int $guests - positive or negative
     * @return boolean
	 */
     public static function update_av_guests($booking_obj_id, $date_from, $date_to, $new_guests){
        
        global $wpdb;
        
        $output = 0;
        $booking_obj_id = absint($booking_obj_id);
        
        $new_guests = (int)$new_guests;
        $item_max_guests = absint(get_post_meta( $booking_obj_id, 'guests', 1 ));
        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($booking_obj_id);
        
        if ($rules_cat['rules']['booking_mode'] == 'object'){
            $sign = $new_guests > 0 ? 1 : -1;
            $new_guests = $item_max_guests*$sign;
        }

        $date_from_obj = new DateTime($date_from);
        $date_to_obj = new DateTime($date_to);
        
        if ($rules_cat['rules']['basic_booking_period'] == 'single_custom'){  
            $date_from_obj = new DateTime($date_from_obj->format('Y-m-d 00:00:00'));
            $date_to_obj = new DateTime($date_from_obj->format('Y-m-d 23:59:59'));
        }
        
        $hold = $rules_cat['rules']['hold'] ? $rules_cat['rules']['hold'] : 1;
        $date_to_extra_obj = clone($date_to_obj);
        $date_to_extra_obj->modify('+'.$hold.' hours');
        
        $datetime_from = $rules_cat['rules']['basic_booking_period'] != 'night' ? $date_from_obj->format('Y-m-d H:i:s') : $date_from_obj->format('Y-m-d 00:00:00');
        $datetime_to = $rules_cat['rules']['basic_booking_period'] != 'night' ? $date_to_obj->format('Y-m-d H:i:s') : $date_to_obj->format('Y-m-d 00:00:00');
        
        if (
            $new_guests
            && (
                $rules_cat['rules']['basic_booking_period'] == 'day'
                || $rules_cat['rules']['basic_booking_period'] == 'hour'
            )
            && (
                $date_from_obj->format('H:i:s') != '00:00:00'
                || $date_to_obj->format('H:i:s') != '00:00:00'
            )
        ){
            //// maybe add $datetime_from and $datetime_to to $table_av_cal
            $av_cal = $wpdb->get_results("SELECT * FROM ".self::$table_av_cal." WHERE booking_obj_id = '".$booking_obj_id."' AND in_schedule = '1' AND date_from >= '".$datetime_from."' AND date_from <= '".$datetime_to."' ORDER BY date_from ASC", ARRAY_A);
            $new_date_arr = array();
            $date_arr = array();
            if (!empty($av_cal)){
                foreach($av_cal as $item){
                   $date_arr[$item['date_from']] = 0; 
                }
            }
            
            if (!isset($date_arr[$datetime_from])){
                $new_date_arr[$datetime_from] = 1;
            }
            if (!isset($date_arr[$datetime_to])){
                $new_date_arr[$datetime_to] = 1;
            }
            self::add_dates_to_av_cal($booking_obj_id, $new_date_arr);
        }
        
        ////////////////////
        if (
            $new_guests < 0
            && (
                $rules_cat['rules']['basic_booking_period'] == 'day'
                || $rules_cat['rules']['basic_booking_period'] == 'hour'
            )
        ){
            //// clear db from none 00:00:00 time lines
            $where_clauses_arr = array();
            if ($date_from_obj->format('H:i:s') != '00:00:00'){
                $where_clauses_arr[] = "date_from = '".$datetime_from."'";
            }
            if ($date_to_obj->format('H:i:s') != '00:00:00'){
                $where_clauses_arr[] = "date_from = '".$datetime_to."'";
            }
            
            if (!empty($where_clauses_arr)){    
                $where_clauses = "AND (".implode(' OR ',$where_clauses_arr).")";
                $wpdb->query( $wpdb->prepare( 'DELETE FROM '.self::$table_av_cal.' WHERE booking_obj_id = %d '.$where_clauses, $booking_obj_id ) );                
            }
            ///// reset holded 00:00:00
            if ($date_to_extra_obj->format('Y-m-d') != $date_to_obj->format('Y-m-d') && $date_to_extra_obj->format('H:i:s') != '00:00:00'){
                
                $query = "UPDATE ".self::$table_av_cal." SET guests = 0
                WHERE (
                  booking_obj_id = ".$booking_obj_id."
                AND date_from = '".$date_to_extra_obj->format('Y-m-d 00:00:00')."'
                )";
                /// update guests
                $new_result = $wpdb->query($query, ARRAY_A);
                
                $av_cal_extra = $wpdb->get_results("SELECT * FROM ".self::$table_av_cal." WHERE booking_obj_id = '".$booking_obj_id."' AND date_from = '".$date_to_extra_obj->format('Y-m-d H:i:s')."' ORDER BY date_from ASC", ARRAY_A);
                if (!empty($av_cal_extra) && !$av_cal_extra[0]['date_from']){
                    $wpdb->query( $wpdb->prepare( 'DELETE FROM '.self::$table_av_cal.' WHERE id = %d', $av_cal_extra[0]['id'] ) );       
                }
                
            }
            
        }
        /////////////////////////
        
        $query = "UPDATE ".self::$table_av_cal." SET guests = guests + ".$new_guests."
        
        WHERE (
           booking_obj_id = ".$booking_obj_id."
          AND date_from >= '".$datetime_from."'
          AND date_from ".($rules_cat['rules']['basic_booking_period'] == 'night' ? "<" : "<=")." '".$datetime_to."'
        )    
";
        /// update guests
        $output = $wpdb->query($query, ARRAY_A);
        
        //// hold 00:00:00 and add extra availability hours for day booking period
        if (
            $new_guests
            && (
                $rules_cat['rules']['basic_booking_period'] == 'day'
                || $rules_cat['rules']['basic_booking_period'] == 'hour'
            )
            && $date_to_extra_obj->format('H:i:s') != '00:00:00'
        ){
            
            if ( $date_to_extra_obj->format('Y-m-d') != $date_to_obj->format('Y-m-d') ){
                $query = "UPDATE ".self::$table_av_cal." SET guests = guests + ".$new_guests."
                WHERE (
                  booking_obj_id = ".$booking_obj_id."
                AND date_from = '".$date_to_extra_obj->format('Y-m-d 00:00:00')."'
                )";
                /// hold 00:00:00
                $new_result = $wpdb->query($query, ARRAY_A);                
            }
            
            $av_cal_extra = $wpdb->get_results("SELECT * FROM ".self::$table_av_cal." WHERE booking_obj_id = '".$booking_obj_id."' AND in_schedule = 1 AND date_from = '".$date_to_extra_obj->format('Y-m-d H:i:s')."' ORDER BY date_from ASC", ARRAY_A); 
            if (empty($av_cal_extra)){
                self::add_dates_to_av_cal($booking_obj_id, array( $date_to_extra_obj->format('Y-m-d H:i:s') => 1) );                    
            }
            
        }
        
        return $output;
        
     }           

/////////////////////////////    
    
}

BABE_Calendar_functions::init();
