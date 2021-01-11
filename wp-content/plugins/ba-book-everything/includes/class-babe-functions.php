<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Functions Class.
 * 
 * @class 		BABE_Functions
 * @version		1.3.0
 * @author 		Booking Algorithms
 */

class BABE_Functions {
    
    ///// cache
    
    static $timezone = '';
    
//////////////////////////////////////
     /**
	 * Get range select options.
	 */ 
     public static function get_range_select_options($start, $end, $step = 1, $value = false){
     
        $output = '';
      
        for($i = $start; $i <= $end; $i += $step){
           $output .= '<option value="'. $i .'" '. selected( $value, $i, false ) .'>'. $i .'</option>';
        }
      
        return $output;
      
     }
     
//////////////////////////////////////
     /**
	 * Array map recursive
     * 
     * @param string $callback
     * @param array $input
     * @return array
	 */ 
     public static function array_map_r($callback, $input) {
        
        $output = array();
        foreach ($input as $key => $data) {
            if (is_array($data)) {
                $output[$key] = self::array_map_r($callback, $data);
            } else {
                $output[$key] = $callback($data);
            }
        }
        
        return $output;
    }     
     
//////////////////////////////////////
     /**
	 * Compare arrays by 'order' field for usort() ASC
     * @param array $a
     * @param array $b
     * @return int
	 */ 
     public static function compare_arrays_by_order_asc($a, $b){
        return intval($a['order']) - intval($b['order']);
     }     
     
//////////////////////////////////////
     /**
	 * Compare dates for usort() ASC
     * @param string $date_1 - format Y-m-d H:i
     * @param string $date_2 - format Y-m-d H:i
     * @return int
	 */ 
     public static function compare_sql_dates_asc($date_1, $date_2){
     
        $ad = new DateTime($date_1);
        $bd = new DateTime($date_2);
        
        if ($ad == $bd) {
            return 0;
        }
        return $ad < $bd ? -1 : 1;
      
     }
     
//////////////////////////////////////
     /**
	 * Compare dates for usort() DESC
     * @param string $date_1 - format Y-m-d H:i
     * @param string $date_2 - format Y-m-d H:i
     * @return int
	 */ 
     public static function compare_sql_dates_desc($date_1, $date_2){
     
        $ad = new DateTime($date_1);
        $bd = new DateTime($date_2);
        
        if ($ad == $bd) {
            return 0;
        }
        return $ad > $bd ? -1 : 1;
      
     }
     
//////////////////////////////////////
     /**
	 * Calculate number of hours between 2 dates
     * 
     * @param string $date_1 - format Y-m-d H:i
     * @param string $date_2 - format Y-m-d H:i
     * 
     * @return int
	 */ 
     public static function dates_diff_hours($date_start, $date_end){
     
        $date1 = new DateTime($date_start);
        $date2 = new DateTime($date_end);
        
        //determine what interval should be used - can change to weeks, months, etc
        $interval = new DateInterval('PT1H');
        
        $periods = new DatePeriod($date1, $interval, $date2);
        $hours = iterator_count($periods);
        
        return $hours;
      
     }
     
//////////////////////////////////////
     /**
	 * Get now DateTime obj with current timezone
     * 
     * @return obj
	 */ 
     public static function datetime_local(){
        
        if (!self::$timezone){
        
          $timezone = get_option('timezone_string');
        
          $wp_offset = get_option('gmt_offset');
        
          if (!$timezone && $wp_offset){
            
            $sign = $wp_offset > 0 ? '+' : '-';
            $min = 60*abs($wp_offset);
            
            $h = floor($min/60);
            $h = $h < 10 ? '0'.$h : $h;
            
            $m = $min%60;
            $m = $m < 10 ? '0'.$m : $m;
            
            $timezone = $sign.$h.':'.$m;
            
          } elseif (!$timezone) {
            $timezone = 'UTC';
          }
          
          self::$timezone = $timezone;
        
        }
        
        $date_now_obj = new DateTime('', new DateTimeZone(self::$timezone));
        
        return $date_now_obj;
      
     }                     
     
//////////////////////////////    
    /**
	 * Close tags
     * @return string
	 */
    public static function closetags($html) {
        
    preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags = $result[1];
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    if (count($closedtags) == $len_opened) {
        return $html;
    }
    $openedtags = array_reverse($openedtags);
    for ($i=0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
            $html .= '</'.$openedtags[$i].'>';
        } else {
            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
    }
    return $html;
    
    }
    
///////////////////////////
    /**
	 * Get distance between two points (given the latitude/longitude of those points).
     * @param float $lat1, $lon1 = Latitude and Longitude of point 1 (in decimal degrees)
     * @param float $lat2, $lon2 = Latitude and Longitude of point 2 (in decimal degrees)
     * @param string $unit = the unit you desire for results:
     * 'M' is statute miles (default), 'K' is kilometers, 'N' is nautical miles
     * @return float
	 */
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit = 'K') {
        
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        
        if ($unit == "K") {
            return ($miles * 1.609344);
        } elseif ($unit == "N") {
            return ($miles * 0.8684);
        } else {
          return $miles;
        }
     }

///////////////////////////////////////
    /**
	 * Get page url with args.
     * @param int $post_id
     * @param array $args
     * @return string
	 */
    public static function get_page_url_with_args($post_id, $args = array()) {
        $url = $post_id ? get_permalink($post_id) : '';
        if (!empty($args) && $url){
            //$args = array_map('rawurlencode', $args);
            //$url = add_query_arg($args, $url);
            
            $query = defined('PHP_QUERY_RFC3986') ? http_build_query($args, null, '&', PHP_QUERY_RFC3986) : http_build_query($args);
            $addon = strpos( $url, '?' ) !== false ? '&' : '?';
            $url = $url.$addon.$query;
        }
        
        return $url;
    }    
    
///////////////////////////////////////
    /**
	 * Get page content.
     * @param int $post_id
     * @return string
	 */
    public static function get_page_content($post_id) {
        
        $post = get_post($post_id);
        $output = !empty($post) ? apply_filters('the_content', $post->post_content) : '';
        
        return $output;
    }    
         
///////////////////////////////////////

/**
 * Get template, passing attributes and including the file.
 *
 * @param string $template_name
 * @param array $args
 * @param string $template_dir
 * @param string $default_path
 * @return
 */
public static function get_template( $template_name, $args = array(), $template_dir = '', $default_path = '' ) {
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}

	$located = self::locate_template( $template_name, $template_dir, $default_path );

	if ( ! file_exists( $located ) ) {
		return;
	}

	$located = apply_filters( 'babe_get_template', $located, $template_name, $args, $template_dir, $default_path );

	do_action( 'babe_before_template_part', $template_name, $template_dir, $located, $args );

	include( $located );

	do_action( 'babe_after_template_part', $template_name, $template_dir, $located, $args );
    
    return;
}

///////////////////////////////////////////////

/**
 * Get the HTML template
 * @param string $template_name
 * @return string
 */
public static function get_template_html( $template_name, $args = array(), $template_dir = '', $default_path = '' ) {
	ob_start();
	self::get_template( $template_name, $args, $template_dir, $default_path );
	return ob_get_clean();
}

///////////////////////////////////////////////
/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_dir	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @param string $template_name
 * @param string $template_dir
 * @param string $default_path
 * @return string
 */
public static function locate_template( $template_name, $template_dir = '', $default_path = '' ) {
    
	if ( ! $template_dir ) {
		$template_dir = BABE_PLUGIN_SLUG;
	}

	if ( ! $default_path ) {
		$default_path = BABE_PLUGIN_DIR . '/templates/';
	}

	// Look theme first
	$template = locate_template(
		array(
			trailingslashit( $template_dir ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found.
	return apply_filters( 'babe_locate_template', $template, $template_name, $template_dir );
}

//////////////////////////////////
/**
 * Get the pager HTML
 * @param int $max_num_pages
 * @return string
 */
public static function pager($max_num_pages){

     $pl_args = array(
     'base'     => add_query_arg('paged','%#%'),
     'format'   => '?paged=%#%',
     'total'    => $max_num_pages,
     'current'  => max(1, get_query_var('paged')),
     //How many numbers to either side of current page, but not including current page.
     'end_size' => 1,
     //Whether to include the previous and next links in the list or not.
     'mid_size' => 2,
     'prev_text' => __('&laquo; Previous', BABE_TEXTDOMAIN), // text for previous page
     'next_text' => __('Next &raquo;', BABE_TEXTDOMAIN), // text for next page
     );
      
     $pl_args = apply_filters('babe_pager_args', $pl_args);

     return '<div class="babe_pager">'.paginate_links($pl_args).'</div>';
}                        
    
///////////////////////////////////////
}
