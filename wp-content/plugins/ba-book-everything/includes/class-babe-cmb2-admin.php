<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_CMB2_admin Class.
 * 
 * @class 		BABE_CMB2_admin
 * @version		1.3.0
 * @author 		Booking Algorithms
 */

class BABE_CMB2_admin {
    
    private static $nonce_title = 'cmb2-tpl-nonce';

    private static $posts_options = [];
    
//////////////////////////////
    /**
	 * Hook in tabs.
	 */
    public static function init() {       
        add_action( 'cmb2_admin_init', array( __CLASS__, 'categories_metabox' ), 10, 1);
        add_action( 'cmb2_admin_init', array( __CLASS__, 'ages_metabox' ), 10, 1);
        add_action( 'cmb2_admin_init', array( __CLASS__, 'taxonomies_metabox' ), 10, 1);
        add_action( 'cmb2_admin_init', array( __CLASS__, 'taxonomies_list_metabox' ), 10, 1);
        
        add_action( 'cmb2_admin_init', array( __CLASS__, 'booking_obj_metabox' ), 10, 1);
        add_action( 'cmb2_init', array( __CLASS__, 'booking_obj_metabox' ), 10, 1);
        add_action( 'cmb2_booking_obj_after_select_category', array( __CLASS__, 'booking_obj_after_select_category' ), 10, 2);
        add_action( 'cmb2_booking_obj_before_av_dates', array( __CLASS__, 'booking_obj_before_av_dates' ), 10, 2);
        
        add_action( 'cmb2_admin_init', array( __CLASS__, 'faq_metabox' ), 10, 1);
        add_action( 'cmb2_init', array( __CLASS__, 'faq_metabox' ), 10, 1);

        add_action( 'cmb2_admin_init', array( __CLASS__, 'fee_metabox' ), 10, 1);
        add_action( 'cmb2_init', array( __CLASS__, 'fee_metabox' ), 10, 1);
        
        add_action( 'cmb2_admin_init', array( __CLASS__, 'service_metabox' ), 10, 1);
        add_action( 'cmb2_init', array( __CLASS__, 'service_metabox' ), 10, 1);
        add_action( 'cmb2_service_before_service_type', array( __CLASS__, 'service_before_service_type_front' ), 10, 2);
        
        add_action( 'cmb2_save_field', array( __CLASS__, 'cmb2_save_field'), 10, 4 );
        add_filter( 'cmb2_can_save', array( __CLASS__, 'cmb2_can_save'), 10, 2 );
        
        add_action( 'cmb2_admin_init', array( __CLASS__, 'order_metabox' ), 10, 1);
        add_action( 'cmb2_admin_init', array( __CLASS__, 'order_items_metabox' ), 20, 1);
        add_action( 'cmb2_admin_init', array( __CLASS__, 'order_customer_metabox' ), 30, 1);
        add_action( 'cmb2_admin_init', array( __CLASS__, 'order_customer_extra_guests_metabox' ), 40, 1);
        
        add_action( 'cmb2_admin_init', array( __CLASS__, 'mpoints_metabox' ), 10, 1);
        
        add_action( 'wp_ajax_save_schedule', array( __CLASS__, 'ajax_save_schedule'));
        
        add_action( 'wp_ajax_generate_coupon_number', array( __CLASS__, 'ajax_generate_coupon_number_admin'));
        
        //add_action( 'wp_insert_post', array( __CLASS__, 'update_booking_obj_post'), 10, 3 );
        add_action( 'wp_insert_post', array( __CLASS__, 'update_tmp_post_data'), 10, 3 );
        add_action( 'cmb2_save_post_fields_booking_obj_metabox', array( __CLASS__, 'update_booking_obj_post'), 10, 3 );
        
        add_action( 'cmb2_admin_init', array( __CLASS__, 'coupon_metabox' ), 10, 1);
        
        add_filter( 'cmb2_render_coupon_expiration_date', array( __CLASS__, 'cmb2_coupon_expiration_date'), 10, 5 );
        
        add_filter( 'cmb2_render_price_details', array( __CLASS__, 'cmb2_price_details'), 10, 5 );
        add_filter( 'cmb2_render_service_prices', array( __CLASS__, 'cmb2_service_prices'), 10, 5 );
        add_filter( 'cmb2_render_object_code', array( __CLASS__, 'cmb2_object_code'), 10, 5 );
        add_filter( 'cmb2_render_duration', array( __CLASS__, 'cmb2_duration'), 10, 5 );
        add_filter( 'cmb2_render_time_shift', array( __CLASS__, 'cmb2_time_shift'), 10, 5 );
        add_filter( 'cmb2_render_schedule', array( __CLASS__, 'cmb2_schedule'), 10, 5 );
        
        add_filter( 'cmb2_render_address', array( __CLASS__, 'cmb2_address'), 10, 5 );
        add_filter( 'cmb2_render_mpoints_select', array( __CLASS__, 'cmb2_mpoints_select'), 10, 5 );
        add_filter( 'cmb2_render_text_title', array( __CLASS__, 'cmb2_text_title'), 10, 5 );
        add_filter( 'cmb2_render_tax_children_multicheck', array( __CLASS__, 'cmb2_tax_children_multicheck'), 10, 5 );
        add_filter( 'cmb2_sanitize_tax_children_multicheck', array( __CLASS__, 'cmb2_sanitize_tax_children_multicheck'), 10, 5 );
        
        add_filter( 'cmb2_render_discount', array( __CLASS__, 'cmb2_discount'), 10, 5 );
        add_filter( 'cmb2_sanitize_discount', array( __CLASS__, 'cmb2_sanitize_discount'), 10, 5 );
        
        add_filter( 'cmb2_render_order_items', array( __CLASS__, 'cmb2_order_items'), 10, 5 );
        
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );
        
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueued_assets' ) );
                
	}
//////////////////////////////
    /**
	 * Enqueue assets.
	 */
    public static function wp_enqueued_assets() {
        
        global $post;
        
      if (isset($_GET['inner_page']) && $_GET['inner_page'] == 'edit-post' && isset($_GET['edit_post_id']) && $_GET['edit_post_id'] && BABE_Users::current_user_can_edit_post($_GET['edit_post_id'])){
        
     wp_enqueue_script( 'babe-cmb2-js', plugins_url( "js/admin/babe-admin-cmb2.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
     wp_localize_script( 'babe-cmb2-js', 'babe_cmb2_lst', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'date_format' => BABE_Settings::$settings['date_format'] == 'd/m/Y' ? 'dd/mm/yy' : 'mm/dd/yy',
            'nonce' => wp_create_nonce(self::$nonce_title),
            'start_lat' => BABE_Settings::$settings['google_map_start_lat'],
            'start_lng' => BABE_Settings::$settings['google_map_start_lng'],
            'start_zoom' => BABE_Settings::$settings['google_map_zoom']
         )
     );
     } 
      
     }
     
//////////////////////////////
    /**
	 * Enqueue assets admin.
	 */
    public static function admin_enqueue_scripts() {
        
     global $current_screen;   
        
     if (isset($_GET['post_type']) && isset($_GET['taxonomy']) && $_GET['post_type'] == BABE_Post_types::$booking_obj_post_type && !empty($current_screen) && $current_screen->base == 'edit-tags'){   
     wp_enqueue_style( 'babe-admin-categories-style', plugins_url( "css/admin/babe-admin-categories.css", BABE_PLUGIN ));
      }
      
      wp_enqueue_script( 'babe-util-js', plugins_url( "js/util.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
     
     wp_enqueue_script( 'babe-modal-adv-js', plugins_url( "js/modal.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
     
     wp_enqueue_style( 'babe-modal-style', plugins_url( "css/babe-modal.css", BABE_PLUGIN ));
      
     wp_enqueue_script( 'babe-admin-select2-js', plugins_url( "js/select2.full.min.js", BABE_PLUGIN ), array('jquery'), '1.0', true ); 
     
     wp_enqueue_script( 'babe-google-api', "https://maps.googleapis.com/maps/api/js?key=".BABE_Settings::$google_api_key."&libraries=places", array('jquery'), '', true );
      
     wp_enqueue_script( 'babe-admin-cmb2-js', plugins_url( "js/admin/babe-admin-cmb2.js", BABE_PLUGIN ), array('jquery'), '1.0', true );
     wp_localize_script( 'babe-admin-cmb2-js', 'babe_cmb2_lst', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'date_format' => BABE_Settings::$settings['date_format'] == 'd/m/Y' ? 'dd/mm/yy' : 'mm/dd/yy',
            'nonce' => wp_create_nonce(self::$nonce_title),
            'start_lat' => BABE_Settings::$settings['google_map_start_lat'],
            'start_lng' => BABE_Settings::$settings['google_map_start_lng'],
            'start_zoom' => BABE_Settings::$settings['google_map_zoom']
         )
     );
     
     wp_enqueue_style( 'babe-admin-select2-style', plugins_url( "css/select2.min.css", BABE_PLUGIN ));
     
     wp_enqueue_script('jquery-ui-datepicker');
     wp_enqueue_style('jquery-ui-admin-style', plugins_url( "css/jquery-ui.min.css", BABE_PLUGIN ), '', '1.12.1', 'all');
     
     wp_enqueue_style('babe-fontawesome', plugins_url( "fonts/fontawesome-free/css/all.min.css", BABE_PLUGIN ));
     
      wp_enqueue_style( 'babe-admin-cmb2-style', plugins_url( "css/admin/babe-admin-cmb2.css", BABE_PLUGIN )); 
      
     }
     
///////////////////////////////////////    
    /**
	 * Ajax generate unique coupon number from admin
	 */
    public static function ajax_generate_coupon_number_admin(){
        
        $output = '';
        
        if (isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title )){  
            $output = BABE_Coupons::generate_coupon_num();
        }
        
        echo $output;
        wp_die();                   
    }      
     
//////////////////////////////////////
     /**
	 * Register coupon expiration date field.
	 */ 
     public static function cmb2_coupon_expiration_date($field, $value, $object_id, $object_type, $field_type){
     
      $output = '';
      
      $output .= '<div class="coupon-expiration-date">
       '.BABE_Coupons::get_coupon_expiration_date($object_id).'
      </div>';
    
      echo $output;
     }
     
///////////////////////////////////////
    /**
	 * Register coupon extra fields.
	 */
    public static function coupon_metabox() {
      $prefix = '_coupon_';
      
      ////////////main metabox////////////////

      $cmb = new_cmb2_box( array(
        'id'            => 'coupon_metabox',
        'title'         => __( '&nbsp;', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$coupon_post_type, ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Coupon Code (unique)', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'number',
         'type'    => 'text',
         'default' => BABE_Coupons::generate_coupon_num(),         
         'attributes'  => array(
           'required'    => 'required',
           'class' => 'medium-text',
         ),
         'after_field' => ' <span id="coupon_generate_num" class="button button-primary button-large">'.__( 'Generate', BABE_TEXTDOMAIN ).'</span><span id="coupon_generate_num_loader"></span>',
      ) );

	    $cmb->add_field( array(
		    'name'       => __( 'Percent, ', BABE_TEXTDOMAIN ) .'%',
		    'id'         => $prefix . 'percent',
		    'type'       => 'text',
		    'description' => __( 'Will be used by default if both amount and percent fields filled.', BABE_TEXTDOMAIN ),
		    'attributes' => array(
			    'type' => 'number',
			    'min' => '1',
			    'pattern' => '[0-9]*',
			    'class' => 'medium-text',
		    ),
	    ) );

      $cmb->add_field( array(
      'name'       => __( 'Amount, ', BABE_TEXTDOMAIN ).BABE_Currency::get_currency_symbol(),
      'id'         => $prefix . 'amount',
      'type'       => 'text',
      'attributes' => array(
           'type' => 'number',
           'min' => '1',
           'pattern' => '[0-9]*',
           //'required'    => 'required',
           'class' => 'medium-text',
          ),
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Status', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'status',
         'type'    => 'select',
         'show_option_none' => false,
         'options' => BABE_Coupons::$coupon_statuses,
      ) );
      
      $cmb->add_field( array(
      'name' => __( 'Expiration date', BABE_TEXTDOMAIN ),
      'id'   => $prefix . 'end_date',
      'type' => 'coupon_expiration_date',
       ) );
      
    }               
     
/////////////cmb2_service_prices//////
     /**
	 * Register service prices fields.
	 */ 
     public static function cmb2_service_prices($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '';
      
      $output .= '<div class="service_prices_block" data-obj-id="'.$object_id.'">
      
      <div class="service_price_item">
         <label for="'.$field_type->_id( '_0' ).'">'.__( 'General, ', BABE_TEXTDOMAIN ).BABE_Currency::get_currency_symbol().' | %</label>
      '.$field_type->input( array(
			'name'  => $field_type->_name( '[0]' ),
			'id'    => $field_type->_id( '_0' ),
			'value' => isset($value[0]) ? $value[0] : 0,
            'class' => 'medium-text',
            'required'    => 'required',
		) ).'
       </div>';
      
      $ages = BABE_Post_types::get_ages_arr();
      
      if (!empty($ages)){
        
        $output .= '<h4>'.__( 'price by age (used instead of the general):', BABE_TEXTDOMAIN ).'</h4>';
        
      foreach ($ages as $age_arr){
        
        $output .= '<div class="service_price_item">
         <label for="'.$field_type->_id( '_'.$age_arr['age_id'] ).'">'.$age_arr['name'] . ' (' . $age_arr['description'] . '), '.BABE_Currency::get_currency_symbol().' | %</label>
      '.$field_type->input( array(
			'name'  => $field_type->_name( '['.$age_arr['age_id'].']' ),
			'id'    => $field_type->_id( '_'.$age_arr['age_id'] ),
			'value' => isset($value[$age_arr['age_id']]) ? $value[$age_arr['age_id']] : '',
            'class' => 'medium-text',
		) ).'
       </div>';
      }
      }
      
      $output .= ' 
       </div>';
    
      echo $output;
     }     
     
//////////////////////////////////////
     /**
	 * Register booking_obj price_details fields.
	 */ 
     public static function cmb2_price_details($field, $value, $object_id, $object_type, $field_type){
     
      $output = '';
      
      $output .= '<div id="prices-block" data-obj-id="'.$object_id.'">
      </div>
      <div id="prices-form" data-obj-id="'.$object_id.'">
      </div>';
      
      $output .= '<div id="babe_overlay_container">
            <div id="confirm_del_rate" class="babe_overlay_inner">
              <span id="modal_close"><i class="fas fa-times"></i></span>
              <h1>'.__('Delete selected rate?', BABE_TEXTDOMAIN).'</h1>
                  <input type="button" name="cancel" id="cancel" class="button babe-button-1" value="'.__('Cancel', BABE_TEXTDOMAIN).'">
                  <input type="button" name="delete" id="delete" class="button babe-button-2" value="'.__('Delete', BABE_TEXTDOMAIN).'">
            </div>
            </div>
            <div id="babe_overlay"></div>';  
    
      echo $output;
     }
  
//////////////////////////////////////
     /**
	 * Register booking_obj duration fields.
	 */ 
     public static function cmb2_duration($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '';
      
      // make sure we specify each part of the value we need.
	  $value = wp_parse_args( $value, array(
		'd' => '',
		'h' => '',
		'i' => '',
	  ) );
      
      $output .= '<div class="duration_block" data-obj-id="'.$object_id.'">
      <div class="duration_select"><label for="'.$field_type->_id( '_d' ).'">'.__( 'Days', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->select( array(
			'name'  => $field_type->_name( '[d]' ),
			'id'    => $field_type->_id( '_d' ),
			'options' => BABE_Functions::get_range_select_options(0, 30, 1, $value['d']),
			'desc'  => '',
		) ).'
       </div>
       
       <div class="duration_select"><label for="'.$field_type->_id( '_h' ).'">'.__( 'Hours', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->select( array(
			'name'  => $field_type->_name( '[h]' ),
			'id'    => $field_type->_id( '_h' ),
			'options' => BABE_Functions::get_range_select_options(0, 23, 1, $value['h']),
			'desc'  => '',
		) ).'
       </div>
       
       <div class="duration_select"><label for="'.$field_type->_id( '_i' ).'">'.__( 'Minutes', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->select( array(
			'name'  => $field_type->_name( '[i]' ),
			'id'    => $field_type->_id( '_i' ),
			'options' => BABE_Functions::get_range_select_options(0, 55, 5, $value['i']),
			'desc'  => '',
		) ).'
       </div>
        
       </div>';
    
      echo $output;
     }

//////////////////////////////////////
     /**
	 * Register booking_obj time_shift fields.
	 */ 
     public static function cmb2_time_shift($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '';
      
      // make sure we specify each part of the value we need.
	  $value = wp_parse_args( $value, array(
		'h' => '',
		'i' => '',
	  ) );
      
      $output .= '<div class="time_shift_block" data-obj-id="'.$object_id.'">
 
       <div class="time_shift_select"> - 
      '.$field_type->select( array(
			'name'  => $field_type->_name( '[h]' ),
			'id'    => $field_type->_id( '_h' ),
			'options' => BABE_Functions::get_range_select_options(0, 23, 1, $value['h']),
			'desc'  => '',
		) ).'
       <label for="'.$field_type->_id( '_h' ).'">'.__( 'Hours', BABE_TEXTDOMAIN ).'</label> 
       </div>
       
       <div class="time_shift_select"> - 
      '.$field_type->select( array(
			'name'  => $field_type->_name( '[i]' ),
			'id'    => $field_type->_id( '_i' ),
			'options' => BABE_Functions::get_range_select_options(0, 55, 5, $value['i']),
			'desc'  => '',
		) ).'
       <label for="'.$field_type->_id( '_i' ).'">'.__( 'Minutes', BABE_TEXTDOMAIN ).'</label> 
       </div>
        
       </div>';
    
      echo $output;
     }
     
///////////tax_children_multicheck////////     
     /**
	 * Register booking_obj tax_children_multicheck fields.
	 */ 
     public static function cmb2_tax_children_multicheck($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '';
      
      $selected_arr = array();
      
      $post_terms_ids = wp_get_post_terms($object_id, $field->args['taxonomy'], array("fields" => "ids"));
      if (!empty($post_terms_ids)){
        foreach($post_terms_ids as $term_id){
          $selected_arr[] = $term_id;
        }
      }
      
      $output .= BABE_Post_types::get_terms_children_hierarchy(array(
		'taxonomy' => $field->args['taxonomy'],
        'view' => 'multicheck', // 'select', 'multicheck' or 'list'
        'id' => $field_type->_id(),
        'name' => $field_type->_name(),
        'data-conditional-id' => isset($field->args['attributes']['data-conditional-id']) ? $field->args['attributes']['data-conditional-id'] : '',
        'data-conditional-value' => isset($field->args['attributes']['data-conditional-value']) ? $field->args['attributes']['data-conditional-value'] : '',
	  ), $selected_arr);
    
      echo $output;
     }     
     
///////////cmb2_sanitize_discount////////     
     /**
	 * Sanitize discount fields.
	 */ 
     public static function cmb2_sanitize_discount( $override_value, $value, $object_id, $field_args, $sanitizer_object ) {
        Global $wpdb;
        
        /// get discount
        $discount_db = $wpdb->get_row("SELECT * FROM ".BABE_Prices::$table_discount." WHERE booking_obj_id = '".$object_id."'", ARRAY_A);
        $update_id = isset($discount_db['id']) ? $discount_db['id'] : 0;
        
        if(!empty($value) && $value['discount'] && $value['date_from'] && $value['date_to'] && BABE_Calendar_functions::isValidDate($value['date_from'], BABE_Settings::$settings['date_format']) && BABE_Calendar_functions::isValidDate($value['date_to'], BABE_Settings::$settings['date_format'])){
            $discount = floatval($value['discount']);
            $date_from = BABE_Calendar_functions::date_to_sql($value['date_from']);
            $date_to = BABE_Calendar_functions::date_to_sql($value['date_to']);
            $date_from_obj = new DateTime($date_from);
            $date_to_obj = new DateTime($date_to);
            
            if($update_id){
                $wpdb->update(
                   BABE_Prices::$table_discount,
                     array(
                       'date_from' => $date_from_obj->format('Y-m-d H:i:s'),
                       'date_to' => $date_to_obj->format('Y-m-d H:i:s'),
                       'discount' => $discount,
                     ),
                     array(
                       'booking_obj_id' => $object_id,
                     ),
                     array( 
                      '%s',	// value1
                      '%s',	// value2
                      '%d'	// value3
                     ), 
                     array( '%d' )
               );
            } else {
               $wpdb->insert(
                   BABE_Prices::$table_discount,
                     array(
                       'booking_obj_id' => $object_id,
                       'date_from' => $date_from_obj->format('Y-m-d H:i:s'),
                       'date_to' => $date_to_obj->format('Y-m-d H:i:s'),
                       'discount' => $discount,
                     )
               );
            }
            
        } elseif ($update_id) {
            $wpdb->query( $wpdb->prepare( 'DELETE FROM '.BABE_Prices::$table_discount.' WHERE booking_obj_id = %d', $object_id) );
        }

	  return $value;
    
     }     

///////////tax_children_multicheck////////     
     /**
	 * Sanitize tax children multichek fields.
	 */ 
     public static function cmb2_sanitize_tax_children_multicheck( $override_value, $value, $object_id, $field_args, $sanitizer_object ) {
        
        $taxonomy = isset($field_args['taxonomy']) ? $field_args['taxonomy'] : '';
        
        if ($taxonomy){
            
           $category = $field_args['render_row_cb'][0]->data_to_save['categories'];
           
           if ($field_args['id'] == $taxonomy.'_'.$category){
           
             if(empty($value)){
               $value = array();
             }
             
             $term_ids = array_map( 'intval', $value );
             $term_ids = array_unique( $term_ids );
             wp_set_object_terms( $object_id, $term_ids, $taxonomy, false );
        
           }
        }

	  return $value;
    
     }
     
////////////cmb2_object_code///////////          
     /**
	 * Register booking_obj text_title fields.
	 */ 
     public static function cmb2_object_code($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '';
      
      $category_id = $field->args['category_id'] ? intval($field->args['category_id']) : 0;
      
      $category_id = $category_id<10 ? '0'.$category_id : $category_id;
      
      $generated_code = apply_filters('cmb2_booking_obj_generated_code', $category_id.'-'.$object_id, $category_id, $object_id); 
      
      $value = !$value ? $generated_code : $value;
      
      $output .= $field_type->input( array(
			'name'  => $field_type->_name(),
			'id'    => $field_type->_id(),
			'value' => $value,
          //  'class' => 'regular-text',
		//	'desc'  => '<p class="cmb2-metabox-description">'.$field->args['desc'].'</p>',
            'data-conditional-id' => $field->args['attributes']['data-conditional-id'],
            'data-conditional-value' => $field->args['attributes']['data-conditional-value'],
		) );
    
      echo $output;
     }
     
////////cmb2_before_row_divider//////     

     /**
	 * CMB2 row header
     * @param  object $field_args Current field args
     * @param  object $field      Current field object
	 */ 
     public static function cmb2_before_row_header($field_args, $field){
     
      $output = '';
      
      $title = isset($field_args['row_title']) ? $field_args['row_title'] : '';
      $data_id = isset($field_args['attributes']['data-conditional-id']) ? ' data-conditional-id="'.$field_args['attributes']['data-conditional-id'].'"': '';
      $data_value = isset($field_args['attributes']['data-conditional-value']) ? ' data-conditional-value="'.$field_args['attributes']['data-conditional-value'].'"': '';
      
      $output .= '
      <div class="cmb-row cmb-type-row-header">
      <div class="cmb2-before-row-header"'.$data_id.$data_value.' name="__row_title_'.$field_args['id'].'">'.$title.'</div>
      </div>';
    
      echo $output;
     } 
               
//////////////////////////////////////
     /**
	 * Register booking_obj text_title fields.
	 */ 
     public static function cmb2_text_title($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '';
      
      $output .= $field_type->input( array(
			'name'  => $field_type->_name(),
			'id'    => $field_type->_id(),
			'value' => $value,
            'class' => 'regular-text q_translatable',
			'desc'  => '',
		) );
    
      echo $output;
     } 
     
//////////////////////////////////////
     /**
	 * Register booking_obj discount fields.
	 */ 
     public static function cmb2_discount($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '';
      
      // make sure we specify each part of the value we need.
	  $value = wp_parse_args( $value, array(
		'discount' => '',
		'date_from' => '',
		'date_to' => '',
	  ) );
      
      $output .= '<div class="discount-block" data-obj-id="'.$object_id.'">
      <div class="discount"><label for="'.$field_type->_id( '_discount' ).'">'.__( 'Discount, %', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->input( array(
			'name'  => $field_type->_name( '[discount]' ),
			'id'    => $field_type->_id( '_discount' ),
			'value' => $value['discount'],
            'class' => 'cmb2-text-small',
            'type' => 'number',
            'min' => '0',
            'max' => '99',
            'pattern' => '[0-9]*',
            'desc'  => '',
		) ).'
       </div>
       
       <div class="discount_date"><label for="'.$field_type->_id( '_date_from' ).'">'.__( 'Date from', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->input( array(
			'name'  => $field_type->_name( '[date_from]' ),
			'id'    => $field_type->_id( '_date_from' ),
			'value' => $value['date_from'],
            'class' => 'cmb2-text-small date_input',
			'desc'  => '',
		) ).'
       </div>
       
       <div class="discount_date"><label for="'.$field_type->_id( '_date_to' ).'">'.__( 'Date to', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->input( array(
			'name'  => $field_type->_name( '[date_to]' ),
			'id'    => $field_type->_id( '_date_to' ),
			'value' => $value['date_to'],
            'class' => 'cmb2-text-small date_input',
			'desc'  => '',
		) ).'
       </div>
        
       </div>';
    
      echo $output;
     }
     
//////////////////////////////
    /**
	 * Get mpoints option list.
     * @return array
	 */
    public static function cmb2_mpoints_select($field, $value, $object_id, $object_type, $field_type){
       
       $output = '';
       
       $args = array(
        'post_type'   => BABE_Post_types::$mpoints_post_type,
        'numberposts' => -1,
        'post_parent' => 0,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
       );
       
       $children_args = $args;
       
       $posts = get_posts( $args );
       
       if ( $posts ) {
        
        $output .= '<select class="cmb2_mpoints_select" name="'.$field_type->_name().'" id="'.$field_type->_id().'" data-conditional-id="'.$field->args['attributes']['data-conditional-id'].'" data-conditional-value="'.$field->args['attributes']['data-conditional-value'].'">';
        
        foreach ( $posts as $post ) {
            
          $children_args['post_parent'] = $post->ID;
          $children = get_children( $children_args );
          $disabled = !empty($children) ? ' disabled' : '';   
          $output .= '<option class="" value="'.$post->ID.'"'.$disabled.' '.selected( $value, $post->ID, false ).' data-parent="0">'.$post->post_title.'</option>';
          
          if (!empty($children)){
              foreach($children as $child_post){
                 $output .= '<option class="" value="'.$child_post->ID.'" '.selected( $value, $child_post->ID, false ).' data-parent="'.$post->ID.'"> - '.$child_post->post_title.'</option>';
              }
          }
          
        }
        
        $output .= '</select>';
        
       }
       
       echo $output;
       
       return;
    }              
      
//////////////////////////////////////
     /**
	 * Register booking_obj address fields.
	 */ 
     public static function cmb2_address($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '';
      
      // make sure we specify each part of the value we need.
	  $value = wp_parse_args( $value, array(
		'address' => '',
		'latitude' => '',
		'longitude' => '',
	  ) );
      
      $output .= '<div class="address_block" data-obj-id="'.$object_id.'">
      <div class="address_address"><label for="'.$field_type->_id( '_address' ).'">'.__( 'Address', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->input( array(
			'name'  => $field_type->_name( '[address]' ),
			'id'    => $field_type->_id( '_address' ),
			'value' => $value['address'],
            'class' => 'regular-text q_translatable',
			'desc'  => '',
		) ).'
       </div>
       
       <div class="address_latitude"><label for="'.$field_type->_id( '_latitude' ).'">'.__( 'Latitude', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->input( array(
			'name'  => $field_type->_name( '[latitude]' ),
			'id'    => $field_type->_id( '_latitude' ),
			'value' => $value['latitude'],
			'desc'  => '',
		) ).'
       </div>
       
       <div class="address_longitude"><label for="'.$field_type->_id( '_longitude' ).'">'.__( 'Longitude', BABE_TEXTDOMAIN ).'</label>
      '.$field_type->input( array(
			'name'  => $field_type->_name( '[longitude]' ),
			'id'    => $field_type->_id( '_longitude' ),
			'value' => $value['longitude'],
			'desc'  => '',
		) ).'
       </div>
       
       <div class="address_from_google">
          <button class="btn button get_from_google">'.__('Get data from Google API', BABE_TEXTDOMAIN).'</button>
          <div class="google_map_get">
            <div class="locationField">
              <input class="autocomplete" name="autocomplete" placeholder="'.__( 'Enter address here', BABE_TEXTDOMAIN ).'" type="text" />
              <button class="btn button save_from_google">'.__('Get address', BABE_TEXTDOMAIN).'</button>
            </div>
            <div class="google_map">
            </div>
          </div>
       </div>
        
       </div>';
    
      echo $output;
     }      
     
//////////////////////////////////////
     /**
	 * Register booking_obj schedule fields.
	 */ 
     public static function cmb2_schedule($field, $value, $object_id, $object_type, $field_type ){
     
      $output = '<div id="schedule_block" data-obj-id="'.$object_id.'">
      <div class="schedule_details">
      ';
      
      $schedule = get_post_meta( $object_id, 'schedule', true );
      
      //// get week days
      $days_arr = BABE_Calendar_functions::get_week_days_arr();
      
      //// foreach weekday show timespans
      foreach ($days_arr as $day_num => $day_title){
        $output .= '<div class="schedule_day" data-day-num="'.$day_num.'">
                   <h4>'.$day_title.':</h4>
                   ';
                   
        if (!empty($schedule) && isset($schedule[$day_num])){
            foreach($schedule[$day_num] as $time){
                $output .= '<span class="schedule_time">'.$time.'<input type="hidden" class="schedule_time_'.$day_num.'" name="_schedule_'.$day_num.'[]" value="'.$time.'"><i class="fas fa-times"></i></span>';
            }
        }           
        
        $output .= '</div>';
      }
      
      $output .= '</div>'; //// end schedule_details
      
      $output .= '<div class="schedule_form">';
      
      //// form to add time span
      $output .= '
      <div class="schedule_form_item">
      <label for="schedule_form_day">'.__( 'Day of the week', BABE_TEXTDOMAIN ).':</label>
      <select id="schedule_form_day" class="schedule_form_select" name="schedule_form_day">';
      foreach ($days_arr as $day_num => $day_title){
          $output .= '<option value="'. $day_num .'">'. $day_title .'</option>';
      }
      $output .= '
      </select>
      </div>';
      
      $output .= '
      <div class="schedule_form_item">
      <label for="schedule_form_hour">'.__( 'Hour', BABE_TEXTDOMAIN ).':</label>
      <select id="schedule_form_hour" class="schedule_form_select" name="schedule_form_hour">
      '.BABE_Functions::get_range_select_options(0,23,1).'
      </select>
      </div>';
      
      $output .= '
      <div class="schedule_form_item">
      <label for="schedule_form_minute">'.__( 'Minutes', BABE_TEXTDOMAIN ).':</label>
      <select id="schedule_form_minute" class="schedule_form_select" name="schedule_form_minute">
      '.BABE_Functions::get_range_select_options(0,55,5).'
      </select>
      </div>';
      
      $output .= '<div class="schedule_form_item">
      <button class="btn button" id="add_schedule">'.__('Add time to schedule', BABE_TEXTDOMAIN).'</button>
      </div>';
      
      $output .= '</div>'; //// end schedule_form
      $output .= '<div class="schedule_form_save"><button class="btn button button-primary" id="save_schedule">'.__('Save schedule', BABE_TEXTDOMAIN).'</button>
      <div id="save_schedule_spinner"></div>
      </div>';
      $output .= '</div>'; //// end schedule_block
      
      echo $output;
     }
      
///////////////////////////////////////    
    /**
	 * Save schedule.
	 */
    public static function ajax_save_schedule(){
        global $wpdb;
        $output = '';
        
        if (isset($_POST['obj_id']) && intval($_POST['obj_id']) > 0 && isset($_POST['start_date']) && BABE_Calendar_functions::isValidDate($_POST['start_date'], BABE_Settings::$settings['date_format']) && isset($_POST['end_date']) && BABE_Calendar_functions::isValidDate($_POST['end_date'], BABE_Settings::$settings['date_format']) && isset($_POST['cyclic_start_every']) && isset($_POST['cyclic_av']) && isset($_POST['schedule']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title ) && BABE_Users::current_user_can_edit_post($_POST['obj_id'])){  
            
          $booking_obj_id = intval($_POST['obj_id']);
          $schedule = empty($_POST['schedule']) ? array() : $_POST['schedule'];
          
          foreach ($schedule as $ind => $day_arr){
            sort($schedule[$ind]);
          }
          
          update_post_meta($booking_obj_id, 'schedule', $schedule);
          //// update av calendar
          BABE_Calendar_functions::update_av_cal($booking_obj_id, $_POST['start_date'], $_POST['end_date'], $schedule, absint($_POST['cyclic_start_every']), absint($_POST['cyclic_av']));          
          $output = 1;
        }
        
        echo $output;
        wp_die();                   
    }               
     
////////booking_obj_after_select_category/////
    /**
	 * Register booking_obj after_select_category fields.
	 */
    public static function booking_obj_after_select_category($cmb, $prefix) {
        
        /// Conditional magic starts here...
        
        /// get all categories
        
        $all_categories = BABE_Post_types::get_categories_arr();
        
        /// foreach category
        
        foreach ($all_categories as $category_id => $category_name){
        /// get post category
        //$terms = wp_get_post_terms( $post_id, BABE_Post_types::$categories_tax, array("fields" => "ids") );
        //if (!empty($terms)){
        //$category_id = $terms[0];
        
        $category = get_term_by( 'id', $category_id, BABE_Post_types::$categories_tax );
        
        /// get category meta
        
        $category_meta = BABE_Post_types::get_term_meta($category_id);
        //Array ( [categories_week] => Array ( [0] => 1 [1] => 2 [2] => 3 [3] => 4 [4] => 5 [5] => 6 [6] => 7 ) [categories_booking_rule] => 0 [categories_gmap_active] => 1 [categories_reviews_active] => 0 [categories_add_taxes] => 0 [categories_taxonomies] => Array ( [0] => 8 ) [categories_step_by_step] => 0 [categories_address] => 0 )
        
        $rule_id = $category_meta['categories_booking_rule'];
        $rules = BABE_Booking_Rules::get_rule($rule_id);
        
        if(!empty($rules)){
            
            if ( $rules['booking_mode'] == 'object' ){
                
              $cmb->add_field( array(
                'name'       => __( 'Number of items', BABE_TEXTDOMAIN ),
                'desc'       => __( 'Number of the same rooms, cars, etc.', BABE_TEXTDOMAIN ),
                'id'         => $prefix . 'items_number_'.$category->slug,
                'type'       => 'text',
                'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                   'type' => 'number',
                   'min' => '0',
                   'pattern' => '[0-9]*',
                ),
              ) );
                
            }
            
            if(apply_filters('cmb2_booking_obj_add_obj_code', true, $cmb, $prefix, $category, $category_id, $rules)){
            //object id for front-end, generated
            $cmb->add_field( array(
              'name'       => __( 'Object code (unique)', BABE_TEXTDOMAIN ),
              'desc'       => __( 'any unique character set for identification', BABE_TEXTDOMAIN ),
              'id'         => $prefix . 'code_'.$category->slug,
              'type'       => 'object_code',
              'category_id' => $category_id,
              'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
            ) );
            }
            
            if($rules['stop_booking_before']){
                
              $cmb->add_field( array(
              'name'       => __( 'Stop booking .. hours before the start (optional)', BABE_TEXTDOMAIN ),
              'desc'       => '',
              'id'         => $prefix . 'stop_booking_before_'.$category->slug,
              'type'       => 'text',
              'default'    => $rules['stop_booking_before'],
              'category_id' => $category_id,
              'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                   'type' => 'number',
                   'min' => '0',
                   'pattern' => '[0-9]*',
                ),
              ) );
                
            }
        
        // $rules['basic_booking_period']
        if ($rules['basic_booking_period'] == 'single_custom'){
            $cmb->add_field( array(
              'name' => __( 'Start Time', BABE_TEXTDOMAIN ),
              'desc' => '',
              'id'   => $prefix . 'start_time_'.$category->slug,
              'type' => 'text_time',
              'time_format' => get_option('time_format'),
              'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
             ) );
              
            $cmb->add_field( array(
              'name' => __( 'End Time', BABE_TEXTDOMAIN ),
              'desc' => '',
              'id'   => $prefix . 'end_time_'.$category->slug,
              'type' => 'text_time',
              'time_format' => get_option('time_format'),
              'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
              ) );
        } /// end if single_custom
        
         if ($rules['basic_booking_period'] == 'recurrent_custom'){
            
            //// add duration
            $cmb->add_field( array(
              'name' => __( 'Duration', BABE_TEXTDOMAIN ),
              'desc' => '',
              'id'   => $prefix . 'duration_'.$category->slug,
              'type' => 'duration',
              'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
              'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
              'row_title' => __( 'Schedule section', BABE_TEXTDOMAIN ),  
             ) );
             
             //// add schedule
            $cmb->add_field( array(
              'id'   => '_schedule_conditions_'.$category->slug,
              'type' => 'hidden',
             ) );
            
         } //// end if recurrent_custom
         } //// end if !empty($rules)
        
        } //// end foreach $all_categories
        
        //// add schedule
            $cmb->add_field( array(
              'name' => __( 'Schedule', BABE_TEXTDOMAIN ),
              'desc' => '',
              'id'   => $prefix . 'schedule_group',
              'type' => 'schedule',
             ) );
        
    }
    
//////////////////////////////////////
     /**
	 * Register order details fields.
	 */ 
     public static function cmb2_order_items($field, $value, $object_id, $object_type, $field_type){
     
      $output = '';
      
      $output .= BABE_html::order_items($object_id); 
    
      echo $output;
     }    
    
/////////order_metabox/////////////              
///////////////////////////////////////
    /**
	 * Register order extra fields.
	 */
    public static function order_metabox() {
      $prefix = '_';
      
      $cmb = new_cmb2_box( array(
        'id'            => 'order_metabox',
        'title'         => __( '&nbsp;', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$order_post_type, ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Order Number (unique)', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'order_number',
         'type'    => 'text',
         'default' => BABE_Order::generate_order_num(),
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Status', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'status',
         'type'    => 'select',
         'show_option_none' => false,
         'options' => BABE_Order::$order_statuses,
         'default' => 'payment_deferred',
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Total amount, ', BABE_TEXTDOMAIN ).BABE_Currency::get_currency_symbol(),
         'id'   => $prefix . 'total_amount',
         'type'    => 'text',
         'default' => 0,
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Expected Prepaid amount, ', BABE_TEXTDOMAIN ).BABE_Currency::get_currency_symbol(),
         'id'   => $prefix . 'prepaid_amount',
         'type'    => 'text',
         'default' => 0,
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Prepaid received, ', BABE_TEXTDOMAIN ).BABE_Currency::get_currency_symbol(),
         'id'   => $prefix . 'prepaid_received',
         'type'    => 'text',
         'default' => 0,
      ) );
      
      
    }
    
///////////////////////////////////////
    /**
	 * Register order extra fields.
	 */
    public static function order_items_metabox() {
      $prefix = '_';
      
      ////// Order details//////////
      
      $cmb = new_cmb2_box( array(
        'id'            => 'order_items_metabox',
        'title'         => __( 'Order items', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$order_post_type, ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Order items', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'order_items',
         'type'    => 'order_items',
      ) );
      
    }
    
///////////////////////////////////////
    /**
	 * Register order extra fields.
	 */
    public static function order_customer_metabox() {
      $prefix = '_';
      
      ////// Customer details//////////
      
      $cmb = new_cmb2_box( array(
        'id'            => 'order_customer_metabox',
        'title'         => __( 'Customer contacts', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$order_post_type, ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
      
      $order_id = 0;
       if ( isset( $_REQUEST['post'] ) ) {
        $order_id = $cmb->object_id( absint( $_REQUEST['post'] ) );
       } elseif ( isset( $_REQUEST['post_ID'] ) ) {
        $order_id = $cmb->object_id( absint( $_REQUEST['post_ID'] ) );
       }
      
      $customer_details_arr = BABE_Order::get_order_customer_details($order_id);
      
      $customer_details_arr_texts = apply_filters('babe_cmb2_order_customer_fields_arr', $customer_details_arr, $order_id);
      
      foreach($customer_details_arr_texts as $field_name => $field_value){

          if ($field_name == 'email_check' || $field_name == 'extra_guests'){
              continue;
          }

          $cmb->add_field( array(
              'name' => BABE_html::checkout_field_label($field_name),
              'id'   =>  $field_name,
              'type'    => 'text',
          ) );
      }
      
      do_action('babe_cmb2_order_customer_fields', $cmb, $customer_details_arr, $order_id);
      
    }

///////////////////////////////////////
    /**
     * Register order extra guests fields.
     */
    public static function order_customer_extra_guests_metabox() {

        ////// Extra guest details//////////

        $cmb = new_cmb2_box( array(
            'id'            => 'order_customer_extra_guests_metabox',
            'title'         => __( 'Extra guest contacts', BABE_TEXTDOMAIN ),
            'object_types'  => array( BABE_Post_types::$order_post_type, ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $order_id = $cmb->object_id();

        $order_items = BABE_Order::get_order_items($order_id);

        if ( empty($order_items) ){
            return;
        }

        $order = reset($order_items);
        $ages_arr = BABE_Post_types::get_post_ages($order['booking_obj_id']);

        $total_number_of_guests = array_sum($order['meta']['guests']);

        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($order['booking_obj_id']);

        if ( empty($rules_cat['category_meta']['categories_other_guests']) || $total_number_of_guests < 2 ) {
            return;
        }

        $custom_field_id = $cmb->add_field( array(
            'id'          => 'extra_guests',
            'type'        => 'group',
            'options'     => array(
                'group_title'   => __( 'Extra guest', BABE_TEXTDOMAIN ).' {#}', // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __( 'Add guest data', BABE_TEXTDOMAIN ),
                'remove_button' => __( 'Remove guest data', BABE_TEXTDOMAIN ),
                'sortable'      => true, // beta
            ),
        ) );

        $customer_meta = apply_filters('babe_order_extra_guest_fields', [
            'first_name' => '',
            'last_name' => '',
            'age_group' => '',
        ]);

        foreach ($customer_meta as $customer_meta_key => $customer_meta_desc){

            if ( $customer_meta_key == 'age_group' && !empty($ages_arr) ){

                $age_options = [];

                foreach ( $ages_arr as $age ){
                    $age_options[$age['age_id']] = $age['name'] . ' ' . $age['description'];
                }

                $cmb->add_group_field( $custom_field_id, [
                    'name'       => BABE_html::checkout_field_label($customer_meta_key),
                    'id'         => $customer_meta_key,
                    'type'       => 'select',
                    'options' => $age_options,
                ] );

            } else {

                $cmb->add_group_field( $custom_field_id, [
                    'name'       => BABE_html::checkout_field_label($customer_meta_key),
                    'id'         => $customer_meta_key,
                    'type'       => 'text',
                ] );
            }
        }

        do_action('babe_cmb2_order_customer_extra_guest_fields', $cmb, $order_id);

    }

/////////faq_metabox/////////////              
///////////////////////////////////////
    /**
	 * Register faq extra fields.
	 */
    public static function faq_metabox() {
      
      $prefix = '';
      
      $cmb = new_cmb2_box( array(
        'id'            => 'faq_metabox',
        'title'         => __( '&nbsp;', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$faq_post_type, ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
        
     if (!is_admin()){
      
     do_action('babe_cmb2_faq_metabox_not_admin_before', $cmb, $prefix); 
      
      $cmb->add_field( array(
    'name' => __( 'Title', BABE_TEXTDOMAIN ),
    'id'   => 'tmp_post_title',
    'type' => 'text',
    'attributes'  => array(
         'required'    => 'required',
         'placeholder' => __( 'Enter title here', BABE_TEXTDOMAIN ),
         ),
    ) );
    
    $cmb->add_field( array(
    'name' => __( 'Content', BABE_TEXTDOMAIN ),
    'id'   => 'tmp_post_content',
    'type' => 'wysiwyg',
    'options' => array(
        'textarea_rows' => get_option('default_post_edit_rows', 7),
    ),
    ) );
    
    do_action('babe_cmb2_faq_metabox_not_admin_after', $cmb, $prefix);
    
    } else {
        do_action('babe_cmb2_faq_metabox_admin', $cmb, $prefix);
    }
          
    }          
    
/////////service_metabox/////////////              
///////////////////////////////////////
    /**
	 * Register service extra fields.
	 */
    public static function service_metabox() {
      $prefix = '';
      
      $cmb = new_cmb2_box( array(
        'id'            => 'service_metabox',
        'title'         => __( '&nbsp;', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$service_post_type, ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
      
      do_action('cmb2_service_before_service_type', $cmb, $prefix);
      
      $cmb->add_field( array(
         'name' => __( 'Service type', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'service_type',
         'type'    => 'radio',
         'options' => BABE_Post_types::$service_type_names,
         'default' => 'booking',
      ) );
      
      $cmb->add_field( array(
         'name' => __( 'Price type', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'price_type',
         'type'    => 'radio_inline',
         'options' => array(
            'amount' => __( 'Amount', BABE_TEXTDOMAIN ),
            'percent' => __( 'Percentages from booking (only for per Booking service type)', BABE_TEXTDOMAIN ),
         ),
         'default' => 'amount',
      ) );      
      
      $cmb->add_field( array(
         'name' => __( 'Prices', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'prices',
         'type' => 'service_prices',
      ) );
      
    }

/////////fee_metabox/////////////
///////////////////////////////////////
    /**
     * Register fee extra fields.
     */
    public static function fee_metabox() {
        $prefix = '';

        $cmb = new_cmb2_box( array(
            'id'            => 'fee_metabox',
            'title'         => __( '&nbsp;', BABE_TEXTDOMAIN ),
            'object_types'  => array( BABE_Post_types::$fee_post_type, ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
        ) );

        do_action('cmb2_fee_before_fields', $cmb, $prefix);

        $cmb->add_field( array(
            'name' => __( 'Price type', BABE_TEXTDOMAIN ),
            'id'   => $prefix . 'price_type',
            'type'    => 'radio_inline',
            'options' => array(
                'amount' => __( 'Amount', BABE_TEXTDOMAIN ),
                'percent' => __( 'Percentage', BABE_TEXTDOMAIN ),
            ),
            'default' => 'amount',
        ) );

        $cmb->add_field( array(
            'name' => __( 'Price', BABE_TEXTDOMAIN ).', '.BABE_Currency::get_currency_symbol().' | %',
            'id'   => $prefix . 'price',
            'type' => 'text',
        ) );

        $cmb->add_field( array(
            'name' => __( 'Is mandatory?', BABE_TEXTDOMAIN ),
            'id'   => $prefix . 'is_mandatory',
            'type'    => 'radio_inline',
            'options' => array(
                0 => __( 'No', BABE_TEXTDOMAIN ),
                1 => __( 'Yes', BABE_TEXTDOMAIN ),
            ),
            'default' => 0,
        ) );

    }

/////////mpoints_metabox/////////////              
///////////////////////////////////////
    /**
	 * Register service extra fields.
	 */
    public static function mpoints_metabox() {
      $prefix = '';
      
      $cmb = new_cmb2_box( array(
        'id'            => 'mpoints_metabox',
        'title'         => __( '&nbsp;', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$mpoints_post_type, ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
      
      $cmb->add_field( array(
                'name'       => __( 'Address', BABE_TEXTDOMAIN ),
                'id'         => 'address',
                'type'       => 'address',
                'desc'       => __( 'Street, etc.', BABE_TEXTDOMAIN ),
      ) );
      
      $cmb->add_field( array(
                'name'       => __( 'Address description (optional)', BABE_TEXTDOMAIN ),
                'id'         => 'description',
                'type'       => 'textarea_small',
                'desc'       => '',
      ) );
      
    }
    
////////booking_obj_before_av_dates////    
     /**
	 * Register booking_obj before_av_dates fields.
	 */
    public static function booking_obj_before_av_dates($cmb, $prefix) {
        
        if (!is_admin()){
            
    //$object_id = isset($_GET['edit_post_id']) ? absint($_GET['edit_post_id']) : $cmb->object_id();        
            //// front end extra fields
    $cmb->add_field( array(
    'name' => __( 'Title', BABE_TEXTDOMAIN ),
    'id'   => 'tmp_post_title',
    'type' => 'text',
    'attributes'  => array(
         'required'    => 'required',
         'placeholder' => __( 'Enter title here', BABE_TEXTDOMAIN ),
         ),
    ) );
    
    $cmb->add_field( array(
    'name' => __( 'Content', BABE_TEXTDOMAIN ),
    'id'   => 'tmp_post_content',
    'type' => 'wysiwyg',
    'options' => array(
        'textarea_rows' => get_option('default_post_edit_rows', 7),
    ),
    ) );
    
    $cmb->add_field( array(
	'name'    => __( 'Featured image', BABE_TEXTDOMAIN ),
	'id'      => 'tmp_featured_image',
	'type'    => 'file',
	'options' => array(
		'url' => false, // Hide the text input for the url
	),
	'text'    => array(
		'add_upload_file_text' => 'Add image' // Change upload button text. Default: "Add or Upload File"
	),
	'query_args' => array(
	  'type' => array(
		'image/gif',
		'image/jpeg',
		'image/png',
	  ),
	),
	'preview_size' => array( 70, 70 ), // Image size to use when previewing in the admin.
    ) );  
            
          $group_images_id = $cmb->add_field( array(
                 'id'          => $prefix . 'images',
                 'type'        => 'group',
                 'description' => __( 'Slideshow Images', BABE_TEXTDOMAIN ),
                 // 'repeatable'  => false, // use false if you want non-repeatable group
                 'options'     => array(
                   'group_title'   => __( 'Slideshow Image', BABE_TEXTDOMAIN ).' {#}', // since version 1.1.4, {#} gets replaced by row number
                   'add_button'    => __( 'Add slideshow image', BABE_TEXTDOMAIN ),
                   'remove_button' => __( 'Remove image', BABE_TEXTDOMAIN ),
                   'sortable'      => true, // beta
                 ),
                ) );
    
    $cmb->add_group_field( $group_images_id, array(
                'name'       => __( 'Image file', BABE_TEXTDOMAIN ),
                'id'         => 'image',
                'type'       => 'file',
                'query_args' => array(
                   'type' => array(
                      'image/gif',
                      'image/jpeg',
                      'image/png',
                   ),
                ),
               // 'desc'       => __( 'image URL', BABE_TEXTDOMAIN ),
                'preview_size' => array( 70, 70 ),
                'options' => array(
                  'url' => false, // Hide the text input for the url
                ),
                ) );
                
    $cmb->add_group_field( $group_images_id, array(
                'name'       => __( 'Image description (optional)', BABE_TEXTDOMAIN ),
                'id'         => 'description',
                'type'       => 'textarea_small',
                ) );  
            
        }
        
        return;
    }
    
////////service_before_service_type_front////    
     /**
	 * Register service before_service_type fields.
	 */
    public static function service_before_service_type_front($cmb, $prefix) {
        
        if (!is_admin()){
            //// front end extra fields
    $cmb->add_field( array(
    'name' => __( 'Title', BABE_TEXTDOMAIN ),
    'id'   => 'tmp_post_title',
    'type' => 'text',
    'attributes'  => array(
         'required'    => 'required',
         'placeholder' => __( 'Enter title here', BABE_TEXTDOMAIN ),
         ),
    ) );
    
    $cmb->add_field( array(
    'name' => __( 'Content', BABE_TEXTDOMAIN ),
    'id'   => 'tmp_post_content',
    'type' => 'wysiwyg',
    'options' => array(
        'textarea_rows' => get_option('default_post_edit_rows', 7),
    ),
    ) );
            
        }
        
        return;
    }
     
///////////cmb2_save_field////////     
     /**
		 * Hooks after save field action.
		 *
		 * @since 2.2.0
		 *
		 * @param string            $field_id the current field id paramater.
		 * @param bool              $updated  Whether the metadata update action occurred.
		 * @param string            $action   Action performed. Could be "repeatable", "updated", or "removed".
		 * @param CMB2_Field object $field_obj    This field object
		 */ 
     public static function cmb2_save_field( $field_id, $updated, $action, $field_obj ) {
       
       if (!is_admin() && $updated){
        
        $object_id = $field_obj->object_id;
        
       if ($field_id == 'tmp_post_title'){
          
          $title = get_post_meta($object_id, 'tmp_post_title', 1);
          if ($title){
          $post_args = array(
           'ID'           => $object_id,
           'post_title'   => $title,
           'post_name' => sanitize_title($title),
           'post_status' => 'publish',
          );
          wp_update_post( $post_args );
          } else {
            $title = get_the_tilte($object_id);
            update_post_meta($object_id, 'tmp_post_title', $title);
          }
                    
          return;
       }
       if ($field_id == 'tmp_post_content'){
          
          $content = get_post_meta($object_id, 'tmp_post_content', 1);
          $post_args = array(
           'ID'           => $object_id,
           'post_content'   => $content,
          );
          wp_update_post( $post_args );
          
          return;
       }
       if ($field_id == 'tmp_featured_image_id'){
          
          $image_id = get_post_meta($object_id, 'tmp_featured_image_id', 1);
          if ($image_id){
            set_post_thumbnail( $object_id, $image_id );
          } else {
            delete_post_meta( $object_id, '_thumbnail_id' );
          }  
          
          return;
       }
      }

	  return;
    
     }
     
////////cmb2_can_save//////////////////
    /**
		 * Filter to determine if metabox is allowed to save.
		 *
		 * @param bool   $can_save Whether the current metabox can save.
		 * @param object $cmb      The CMB2 instance
		 */
     public static function cmb2_can_save($can_save, $cmb){
        
        $object_id = $cmb->object_id();
        
        if ($can_save && $object_id && BABE_Users::current_user_can_edit_post($object_id)){
           return true;
        }
        
        return $can_save;
     }         
                   
///////////////////////////////////////
    /**
	 * Register booking_obj extra fields.
	 */
    public static function booking_obj_metabox() {

        $prefix = '';
      
      ///////////sidebar metabox/////////
      
      $cmb = new_cmb2_box( array(
        'id'            => 'booking_obj_metabox_side',
        'title'         => __( 'Slideshow Images', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$booking_obj_post_type, ), // Post type
        'context'       => 'side',
        'priority'      => 'low',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
      
      $group_images_id = $cmb->add_field( array(
                 'id'          => $prefix . 'images',
                 'type'        => 'group',
                // 'description' => __( 'Slideshow Images', BABE_TEXTDOMAIN ),
                 // 'repeatable'  => false, // use false if you want non-repeatable group
                 'options'     => array(
                   'group_title'   => __( 'Image', BABE_TEXTDOMAIN ).' {#}', // since version 1.1.4, {#} gets replaced by row number
                   'add_button'    => __( 'Add slideshow image', BABE_TEXTDOMAIN ),
                   'remove_button' => __( 'Remove image', BABE_TEXTDOMAIN ),
                   'sortable'      => true, // beta
                 ),
                ) );
    
    $cmb->add_group_field( $group_images_id, array(
                'name'       => __( 'Image file', BABE_TEXTDOMAIN ),
                'id'         => 'image',
                'type'       => 'file',
               // 'desc'       => __( 'image URL', BABE_TEXTDOMAIN ),
                'preview_size' => array( 70, 70 ),
                'options' => array(
                  'url' => false, // Hide the text input for the url
                ),
                ) );
                
    $cmb->add_group_field( $group_images_id, array(
                'name'       => __( 'Image description (optional)', BABE_TEXTDOMAIN ),
                'id'         => 'description',
                'type'       => 'textarea_small',
                ) );
      
      ////////////main metabox////////////////

      $cmb = new_cmb2_box( array(
        'id'            => 'booking_obj_metabox',
        'title'         => __( '&nbsp;', BABE_TEXTDOMAIN ),
        'object_types'  => array( BABE_Post_types::$booking_obj_post_type, ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
      ) );
      
      $post_id = 0;
      
      if ( isset( $_REQUEST['post'] ) ) {
        $post_id = $cmb->object_id( absint( $_REQUEST['post'] ) );
       } elseif ( isset( $_REQUEST['post_ID'] ) ) {
        $post_id = $cmb->object_id( absint( $_REQUEST['post_ID'] ) );
       }
      
    do_action('cmb2_booking_obj_before_av_dates', $cmb, $prefix);  
      
    $cmb->add_field( array(
    'name' => __( 'Available from Date', BABE_TEXTDOMAIN ),
    'id'   => $prefix . 'start_date',
    'type' => 'text',
    'attributes'  => array(
         'required'    => 'required',
         ),
     'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
     'row_title' => __( 'Basic settings', BABE_TEXTDOMAIN ),    
    ) );

    $cmb->add_field( array(
    'name' => __( 'Available to Date', BABE_TEXTDOMAIN ),
    'id'   => $prefix . 'end_date',
    'type' => 'text',
    'attributes'  => array(
         'required'    => 'required',
         ),
    ) );
    
    $cmb->add_field( array(
    'name'       => __( 'Cyclic availability: start after every N days', BABE_TEXTDOMAIN ),
    'desc'       => __( 'Blank or 0 to skip this option', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'cyclic_start_every',
    'type'       => 'text',
    'attributes' => array(
           'type' => 'number',
           'min' => '0',
           'pattern' => '[0-9]*',
          ),
    ) );
    
    $cmb->add_field( array(
    'name'       => __( 'Cyclic availability: available N days after start', BABE_TEXTDOMAIN ),
    'desc'       => __( 'Used if previous field value > 1', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'cyclic_av',
    'type'       => 'text',
    'attributes' => array(
           'type' => 'number',
           'min' => '0',
           'pattern' => '[0-9]*',
          ),
    ) );
    
    $group_excluded_dates = $cmb->add_field( array(
                 'id'          => $prefix . 'excluded_dates',
                 'type'        => 'group',
                // 'description' => __( 'Slideshow Images', BABE_TEXTDOMAIN ),
                 // 'repeatable'  => false, // use false if you want non-repeatable group
                 'options'     => array(
                   'group_title'   => __( 'Excluded Date', BABE_TEXTDOMAIN ).' {#}', // since version 1.1.4, {#} gets replaced by row number
                   'add_button'    => __( 'Add date to exclude from schedule', BABE_TEXTDOMAIN ),
                   'remove_button' => __( 'Remove date', BABE_TEXTDOMAIN ),
                   'sortable'      => true, // beta
                 ),
                ) );
                
    $cmb->add_group_field( $group_excluded_dates, array(
                'name' => __( 'Date to exclude', BABE_TEXTDOMAIN ),
                'id'   => $prefix . 'excluded_date',
                'type' => 'text',
                'classes' => array( 'av_dates' ),
    ) );
    
    do_action('cmb2_booking_obj_after_av_dates', $cmb, $prefix);
    
    //maximum number of guests
    $cmb->add_field( array(
    'name'       => __( 'Maximum number of Guests', BABE_TEXTDOMAIN ),
   // 'desc'       => __( 'field description (optional)', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'guests',
    'type'       => 'text',
    'attributes' => array(
           'type' => 'number',
           'min' => '0',
           'pattern' => '[0-9]*',
          ),
    ) );
        
        $cmb->add_field( array(
                  'name'           => __( 'Select category to setup other post fields', BABE_TEXTDOMAIN ),
                  'id'             => $prefix . BABE_Post_types::$categories_tax,
                  'taxonomy'       => BABE_Post_types::$categories_tax, //Enter Taxonomy Slug
                  'type'           => 'taxonomy_select',
                  'show_option_none' => false,
                  'text'           => array(
                  'no_terms_text' => __( 'Sorry, no terms could be found.', BABE_TEXTDOMAIN )
                  ),
                  'remove_default' => true
                ) );
                
        do_action('cmb2_booking_obj_after_select_category', $cmb, $prefix);
        
        $cmb->add_field( array(
         'name' => __( 'Fixed Deposit amount, ', BABE_TEXTDOMAIN ).BABE_Currency::get_currency_symbol(),
         'id'   => $prefix . 'deposit_fixed',
         'type' => 'text',
         'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
         'row_title' => __( 'Prices', BABE_TEXTDOMAIN ),
         ) );
        
        $cmb->add_field( array(
         'name' => __( 'Prices', BABE_TEXTDOMAIN ),
         'id'   => $prefix . 'prices',
         'type' => 'price_details',
         ) );
         
         //discount for promotions
         $cmb->add_field( array(
         'name'       => __( 'Discount (optional)', BABE_TEXTDOMAIN ),
          'desc'       => __( 'applies to all prices', BABE_TEXTDOMAIN ),
          'id'         => $prefix . 'discount',
          'type'       => 'discount',
         ) );

        $fees_options = self::get_posts_options(BABE_Post_types::$fee_post_type, $cmb);

        if (!empty($fees_options)){
            $cmb->add_field( array(
                'name'       => __( 'Fees', BABE_TEXTDOMAIN ),
                'id'         => $prefix . 'fees',
                'type'       => 'multicheck',
                'options' => $fees_options,
                'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
                'row_title' => __( 'Fees section', BABE_TEXTDOMAIN ),
            ) );
        }

        /// Conditional magic starts here...
        
        /// get all categories
        
        $all_categories = BABE_Post_types::get_categories_arr();
        
        /// foreach category
        
        foreach ($all_categories as $category_id => $category_name){
        
        $category = get_term_by( 'id', $category_id, BABE_Post_types::$categories_tax );
        
        /// get category meta
        if ($category){
        
        $category_meta = BABE_Post_types::get_term_meta($category_id);
        //Array ( [categories_week] => Array ( [0] => 1 [1] => 2 [2] => 3 [3] => 4 [4] => 5 [5] => 6 [6] => 7 ) [categories_booking_rule] => 0 [categories_gmap_active] => 1 [categories_reviews_active] => 0 [categories_add_taxes] => 0 [categories_taxonomies] => Array ( [0] => 8 ) [categories_step_by_step] => 0 [categories_address] => 0 )
        $rule_id = $category_meta['categories_booking_rule'];
        $rules = BABE_Booking_Rules::get_rule($rule_id);
        
        if(!empty($rules)){
            
            do_action('cmb2_booking_obj_after_prices', $cmb, $prefix, $category);
        
        /// create metaboxes by meta
        if (isset($category_meta['categories_address']) && $category_meta['categories_address']){
            
            if(apply_filters('cmb2_booking_obj_add_address', true, $cmb, $prefix, $category, $category_meta, $rules)){

                $cmb->add_field( array(
                    'name'       => __( 'Address', BABE_TEXTDOMAIN ),
                    'id'         => $prefix . 'address_'.$category->slug,
                    'type'       => 'address',
                    'desc'       => __( 'Street, etc.', BABE_TEXTDOMAIN ),
                    'attributes' => array(
                        'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                        'data-conditional-value' => $category->slug,
                    ),
                    'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
                    'row_title' => __( 'Address section', BABE_TEXTDOMAIN ),
                ) );

            }

            $add_meeting_places = $rules['basic_booking_period'] == 'recurrent_custom' && BABE_Settings::$settings['mpoints_active'];
            
            if ( apply_filters('cmb2_booking_obj_add_meeting_places', $add_meeting_places, $cmb, $prefix, $category, $category_meta, $rules) ){
               
               if( apply_filters('cmb2_booking_obj_add_select_meeting_place', true, $cmb, $prefix, $category, $category_meta, $rules) ){
               $cmb->add_field( array(
                'name'       => __( 'Meeting place', BABE_TEXTDOMAIN ),
                'id'         => $prefix . 'meeting_place_'.$category->slug,
                'type'    => 'radio_inline',
                'options' => array(
                   'address' => __( 'Main address', BABE_TEXTDOMAIN ),
                   'point' => __( 'Meeting point', BABE_TEXTDOMAIN ),
                   'custom' => __( 'Customer address', BABE_TEXTDOMAIN ),
                ),
                'default' => 'point',
                'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
               ) );
               }
               
               do_action('cmb2_booking_obj_before_mpoints_group', $cmb, $prefix, $category, $category_meta, $rules);
                
               $group_meeting_id = $cmb->add_field( array(
                 'id'          => $prefix . 'meeting_points_'.$category->slug,
                 'type'        => 'group',
                 'description' => __( 'Add meeting point', BABE_TEXTDOMAIN ),
                 // 'repeatable'  => false, // use false if you want non-repeatable group
                 'options'     => array(
                   'group_title'   => __( 'Meeting point', BABE_TEXTDOMAIN ).' {#}', // since version 1.1.4, {#} gets replaced by row number
                   'add_button'    => __( 'Add meeting point', BABE_TEXTDOMAIN ),
                   'remove_button' => __( 'Remove meeting point', BABE_TEXTDOMAIN ),
                   'sortable'      => true, // beta
                 ),
                ) );
                
                do_action('cmb2_booking_obj_before_mpoints_select', $group_meeting_id, $cmb, $prefix, $category);
                
                $cmb2_place_field_args = array(
                'name'       => __( 'Place', BABE_TEXTDOMAIN ),
                'id'         => 'place',
                'type'       => 'mpoints_select',
              //  'classes' => array('babe_cmb2_select_2_row'),
                'desc'       => '',
                'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
                );
                
                $cmb2_place_field_args = apply_filters('cmb2_booking_obj_place_field_args', $cmb2_place_field_args, $cmb, $prefix, $category);
                
                $cmb->add_group_field( $group_meeting_id, $cmb2_place_field_args );
                
                $cmb2_time_shift_args = array(
                  'name' => __( 'Difference with the main time', BABE_TEXTDOMAIN ),
                  'desc' => '',
                  'id'   => 'time_shift',
                  'type' => 'time_shift',
                  'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
                );
                
                $cmb2_time_shift_args = apply_filters('cmb2_booking_obj_time_shift_field_args', $cmb2_time_shift_args, $cmb, $prefix, $category);
                
                //// add time_shift
                $cmb->add_group_field( $group_meeting_id, $cmb2_time_shift_args );    
                
            }  //// end if recurrent_custom
        }
        
        do_action('cmb2_booking_obj_after_address', $cmb, $prefix, $category);
        
        if (isset($category_meta['categories_step_by_step']) && $category_meta['categories_step_by_step']){
        //////////////////////////////////////////////
        //////////// Attractions ////////////////////
        
        $step_title = isset($category_meta['categories_step_title']) && $category_meta['categories_step_title'] ? $category_meta['categories_step_title'] : __( 'Step', BABE_TEXTDOMAIN );

    $group_field_id = $cmb->add_field( array(
    'id'          => $prefix . 'steps_'.$category->slug,
    'type'        => 'group',
    'description' => sprintf(__( 'Add %s description', BABE_TEXTDOMAIN ), $step_title),
    // 'repeatable'  => false, // use false if you want non-repeatable group
    'options'     => array(
        'group_title'   => $step_title.' {#}', // since version 1.1.4, {#} gets replaced by row number
        'add_button'    => sprintf(__( 'Add %s', BABE_TEXTDOMAIN ), $step_title),
        'remove_button' => sprintf(__( 'Remove %s', BABE_TEXTDOMAIN ), $step_title),
        'sortable'      => true, // beta
    ),
    'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
    'before_group' => array( __CLASS__, 'cmb2_before_row_header'),
    'row_title' => $step_title.__( ' section', BABE_TEXTDOMAIN ),
    ) );

    $cmb->add_group_field( $group_field_id, array(
              'name'       => __( 'Title', BABE_TEXTDOMAIN ),
              'id'         => 'title',
              'type'       => 'text_title',
              'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
            ) );
    
    $cmb->add_group_field( $group_field_id, array(
	'name'    => __( 'Description', BABE_TEXTDOMAIN ),
	'id'      => 'attraction',
	'type'    => 'wysiwyg',
	'options' => array(
        'wpautop' => true,
        'textarea_rows' => get_option('default_post_edit_rows', 7)
    ),
       'before' => '<div data-conditional-id="'.$prefix . BABE_Post_types::$categories_tax.'" data-conditional-value="'.$category->slug.'" name="__attraction">',
       'after' => '</div>'
    ) );
        
        //////////////////////////////////////////////    
        }
        
        /////other fields title
        $cmb->add_field( array(
              'name'       => '',
              'id'         => $prefix . 'rowtitle_'.$category->slug,
              'type'       => 'title',
              'classes' => 'cmb2-row-hidden',
              'attributes' => array(
                   'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
                   'data-conditional-value' => $category->slug,
                ),
               'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
               'row_title' => __( 'Taxonomies and Other fields', BABE_TEXTDOMAIN ),
        ) );       
        
        do_action('cmb2_booking_obj_after_steps', $cmb, $prefix, $category);
        
        if (isset($category_meta['categories_taxonomies']) && !empty($category_meta['categories_taxonomies'])){
            foreach($category_meta['categories_taxonomies'] as $taxonomy_id){
                if (isset(BABE_Post_types::$taxonomies_list[$taxonomy_id]['slug'])){
		            $taxonomy_slug = BABE_Post_types::$taxonomies_list[$taxonomy_id]['slug'];
		            $taxonomy_meta = BABE_Post_types::get_taxonomy_meta_by_slug($taxonomy_slug);

		            switch ($taxonomy_meta['select_mode']){
			            case 'multi_checkbox':
				            $select_type = 'tax_children_multicheck';
				            break;
			            case 'multi_select':
				            $select_type = 'taxonomy_multicheck';
				            break;
			            case 'single_radio':
				            $select_type = 'taxonomy_radio';
				            break;
			            case 'single_select':
				            $select_type = 'taxonomy_select';
				            break;
		            }

		            $cmb->add_field( array(
			            'name'           => BABE_Post_types::$taxonomies_list[$taxonomy_id]['name'],
			            'id'             => $prefix . BABE_Post_types::$taxonomies_list[$taxonomy_id]['slug'].'_'.$category->slug,
			            'taxonomy'       => BABE_Post_types::$taxonomies_list[$taxonomy_id]['slug'], //Enter Taxonomy Slug
			            'type'           => $select_type,
			            'text'           => array(
				            'no_terms_text' => __( 'Sorry, no terms could be found.', BABE_TEXTDOMAIN )
			            ),
			            'remove_default' => 'true',
			            'attributes' => array(
				            'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
				            'data-conditional-value' => $category->slug,
			            ),
		            ) );
                }

            }
        }
        
        do_action('cmb2_booking_obj_after_taxonomies', $cmb, $prefix, $category);
        
        if (isset($category_meta['categories_services']) && !empty($category_meta['categories_services'])){
            
            $services_options = self::get_posts_options(BABE_Post_types::$service_post_type, $cmb);

            if (!empty($services_options)){
	            $cmb->add_field( array(
		            'name'       => __( 'Services', BABE_TEXTDOMAIN ),
		            'id'         => $prefix . 'services_'.$category->slug,
		            'type'       => 'multicheck',
		            'options' => $services_options,
		            'attributes' => array(
			            'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
			            'data-conditional-value' => $category->slug,
		            ),
		            'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
		            'row_title' => __( 'Services section', BABE_TEXTDOMAIN ),
	            ) );
            }

            
        }
        
        if (isset($category_meta['categories_faq']) && !empty($category_meta['categories_faq'])){
            
            $faq_options = self::get_posts_options(BABE_Post_types::$faq_post_type, $cmb);

            if(!empty($faq_options)){
	            $cmb->add_field( array(
		            'name'       => __( 'FAQ', BABE_TEXTDOMAIN ),
		            'id'         => $prefix . 'faq_'.$category->slug,
		            'type'       => 'multicheck',
		            'options' => $faq_options,
		            'attributes' => array(
			            'data-conditional-id'    => $prefix . BABE_Post_types::$categories_tax,
			            'data-conditional-value' => $category->slug,
		            ),
		            'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
		            'row_title' => __( 'Questions & Answers section', BABE_TEXTDOMAIN ),
	            ) );
            }
        }
        
        } //// end if !empty($rules)
        
        } ///// if $category
        
       } //// end foreach $all_categories

        //////////// Custom sections ////////////////////

        $custom_field_title = __( 'Custom section', BABE_TEXTDOMAIN );

        $custom_field_id = $cmb->add_field( array(
            'id'          => $prefix . 'custom_section',
            'type'        => 'group',
            'options'     => array(
                'group_title'   => $custom_field_title.' {#}', // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => sprintf(__( 'Add %s', BABE_TEXTDOMAIN ), $custom_field_title),
                'remove_button' => sprintf(__( 'Remove %s', BABE_TEXTDOMAIN ), $custom_field_title),
                'sortable'      => true, // beta
            ),
            'before_group' => array( __CLASS__, 'cmb2_before_row_header'),
            'row_title' => $custom_field_title,
        ) );

        $cmb->add_group_field( $custom_field_id, array(
            'name'       => __( 'Title', BABE_TEXTDOMAIN ),
            'id'         => 'title',
            'type'       => 'text_title',
        ) );

        $cmb->add_group_field( $custom_field_id, array(
            'name'       => __( 'Font Awesome 5 class (far fa-eye)', BABE_TEXTDOMAIN ),
            'id'         => 'fa_class',
            'type'       => 'text_title',
        ) );

        $cmb->add_group_field( $custom_field_id, array(
            'name'    => __( 'Content', BABE_TEXTDOMAIN ),
            'id'      => 'content',
            'type'    => 'wysiwyg',
            'options' => array(
                'wpautop' => true,
                'textarea_rows' => get_option('default_post_edit_rows', 7)
            ),
        ) );

        //////////////////////////////////////////////

        $related_items_options = [];
	    foreach ($all_categories as $cat_id => $cat_name){

	        $related_items_options[$cat_name] = self::get_posts_options(
                    BABE_Post_types::$booking_obj_post_type,
                    $cmb,
                    [],
                    [
                        'post__not_in' => [$post_id],
                        'tax_query' => [
                            [
                                'taxonomy' => BABE_Post_types::$categories_tax,
                                'field'    => 'term_id',
                                'terms'    => [ $cat_id ],
                            ]
                        ],
                    ]
            );
	    }

	    if (!empty($related_items_options)) {
		    $cmb->add_field( array(
			    'name'       => __( 'Related items', BABE_TEXTDOMAIN ),
			    'desc' => 'Mark the categories that apply to this object (optional)',
			    'id'         => $prefix . 'related_items',
			    'type' => 'multicheck',
			    'select_all_button' => false,
			    'options' => $related_items_options,
			    'render_row_cb' => array( __CLASS__, 'cmb2_related_items_cb'),
                'before_row' => array( __CLASS__, 'cmb2_before_row_header'),
                'row_title' => __( 'Related items', BABE_TEXTDOMAIN ),
		    ) );
        }
       
       do_action('cmb2_booking_obj_after_all', $cmb, $prefix);         
    
    }

    /////////////
    /**
     * Related items callback
     *
     * @param array $field_args
     * @param object $field
     */
    public static function cmb2_related_items_cb( $field_args, $field ) {
		$id          = $field->args( 'id' );
		$label       = $field->args( 'name' );
		$name        = $field->args( '_name' );
		$options     = $field->args["options"];
		$description = $field->args( 'desc' );
		$valls       = empty($field_args["display_cb"][0]->value)? array(): $field_args["display_cb"][0]->value;
		?>
		<div class="cmb-row cmb-type-row-header">
			<div class="cmb2-before-row-header" name="__row_title_related_items"><?php echo __( 'Related items', BABE_TEXTDOMAIN ); ?></div>
		</div>
		<div class="cmb-row cmb-type-multicheck-inline cmb2-id-related-items cmb-inline" data-fieldtype="multicheck_inline">
			<div class="cmb-th">
				<label for="<?php echo $id; ?>"><?php echo $label; ?></label>
				<p class="cmb2-metabox-description"><?php echo $description; ?></p>
			</div>
			<div class="cmb-td">

            <?php
                $output =''; $i =1;
                foreach ($options as $cat_name => $cat_list){
                $output .= '<button type="button" class="related_collapsible">' . $cat_name . '</button> 
                            <div class="content">
                            <span class="button-secondary related_all_non">Select / Deselect All</span>
                                <ul class="cmb2-checkbox-list no-select-all cmb2-list "> <br/>';

                    foreach ($cat_list as $cat_id => $cat){

	                    $checked = '';
                        foreach ($valls as $active_checkbox){
                            if ((int)$active_checkbox == $cat_id) {
	                            $checked = ' checked="" ';
	                            break;
                            }
                        }
                        //$checked = (array_search($cat_id, $valls)) ? ' checked="" ': '';
                        $output .= '<li><input type="checkbox" class="cmb2-option" name="related_items[]" id="related_items'.$i.'" value="'.$cat_id.'" '. $checked . ' > 
                                        <label for="related_items'.$i.'">'.$cat .'</label></li>';
                        $i++;
                    }
                    $output .= '</ul></div>';

                }
                echo $output;
            ?>
			</div>
		</div>

		<?php
	}


///////////////////////////////////////
    /**
	 * Register ages extra fields.
	 */
    public static function ages_metabox() {
        $prefix = 'ages_';

	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => __( 'Ages Metabox', BABE_TEXTDOMAIN ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( BABE_Post_types::$ages_tax ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );
    
    //// get all ages
    $ages_arr = BABE_Post_types::get_ages_arr();
    $num = count($ages_arr) + 1;
    
    $cmb_term->add_field( array(
    'name'       => __( 'Order (1, 2, etc.), *required', BABE_TEXTDOMAIN ),
    'desc'       => __( 'With the smallest number will be the main age, others will be sorted by ASC', BABE_TEXTDOMAIN ),
    'id'         => 'menu_order',
    'type'       => 'text',
    'attributes' => array(
           'type' => 'number',
           'min' => '1',
           'pattern' => '[0-9]*',
          ),
    'default'  => $num,
    ) );
    
   }             
    
///////////////////////////////////////
    /**
	 * Register categories extra fields.
	 */
    public static function categories_metabox() {
        $prefix = 'categories_';

	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => __( 'Categories Metabox', BABE_TEXTDOMAIN ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( BABE_Post_types::$categories_tax ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );
    
    $cmb_term->add_field( array(
    'name'    => __( 'Available days', BABE_TEXTDOMAIN ),
    'desc'    => __( 'Setup available days template', BABE_TEXTDOMAIN ),
    'id'      => $prefix . 'week',
    'type'    => 'multicheck_inline',
    'select_all_button' => false,
    'default' => array('0', '1', '2', '3', '4', '5', '6', '7'),
    'options_cb' => 'BABE_Calendar_functions::cmb2_get_week_options',
    ) );
    
    $cmb_term->add_field( array(
    'name'       => __( 'Booking rule', BABE_TEXTDOMAIN ),
   // 'desc'       => __( 'field description (optional)', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'booking_rule',
    'type'       => 'select',
    'options_cb' => array( __CLASS__ , 'get_booking_rules_options'),
    'show_option_none' => false,
    'attributes'  => array(
         'required'    => 'required',
         ),
    ) );
    
    $cmb_term->add_field( array(
		'name'         => __( 'Add checkout fields for all guests', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'other_guests',
		'desc'       => __( 'User will be prompted to enter names off all guest in order', BABE_TEXTDOMAIN ),
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
	) );

    $cmb_term->add_field( array(
		'name'         => __( 'Make extra checkout fields mandatory', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'other_guests_mandatory',
		'desc'       => __( 'User must fill all extended guest data to finish order', BABE_TEXTDOMAIN ),
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
	) );

    $cmb_term->add_field( array(
		'name'         => __( 'Remove guests from booking form', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'remove_guests',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
	) );
    
    $cmb_term->add_field( array(
		'name'         => __( 'Add taxes?', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'add_taxes',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
	) );
    
    $cmb_term->add_field( array(
    'name'       => __( 'Taxes, %', BABE_TEXTDOMAIN ),
   // 'desc'       => __( 'field description (optional)', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'tax',
    'type'       => 'text',
    ) );
    
    $cmb_term->add_field( array(
    'name'       => __( 'Taxes title', BABE_TEXTDOMAIN ),
   // 'desc'       => __( 'field description (optional)', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'tax_title',
    'type'       => 'text',
    ) );
    
    $cmb_term->add_field( array(
		'name'         => __( 'Add services?', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'services',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 1,
	) );
    
    $cmb_term->add_field( array(
    'name'       => __( 'Services title', BABE_TEXTDOMAIN ),
   // 'desc'       => __( 'field description (optional)', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'services_title',
    'type'       => 'text',
    ) );
    
    $cmb_term->add_field( array(
		'name'         => __( 'Add FAQ?', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'faq',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 1,
	) );
    
    $cmb_term->add_field( array(
    'name'       => __( 'FAQ title', BABE_TEXTDOMAIN ),
   // 'desc'       => __( 'field description (optional)', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'faq_title',
    'type'       => 'text',
    ) );
    
    $cmb_term->add_field( array(
    'name'       => __( 'Include taxonomies', BABE_TEXTDOMAIN ),
   // 'desc'       => __( 'field description (optional)', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'taxonomies',
    'type'    => 'multicheck',
    'options_cb' => array( __CLASS__ , 'get_taxonomies_options'),
    ) );
    
    $cmb_term->add_field( array(
		'name'         => __( 'Add step by step description?', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'step_by_step',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
	) );
    
    $cmb_term->add_field( array(
    'name'       => __( 'Step title', BABE_TEXTDOMAIN ),
   // 'desc'       => __( 'field description (optional)', BABE_TEXTDOMAIN ),
    'id'         => $prefix . 'step_title',
    'type'       => 'text',
    ) );
    
    $cmb_term->add_field( array(
		'name'         => __( 'Add address field?', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'address',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
	) );
    
    $cmb_term->add_field( array(
		'name'         => __( 'Add Google map to booking objects?', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'gmap_active',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
	) );
    
    /*
    $cmb_term->add_field( array(
		'name'         => __( 'Enable Reviews?', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'reviews_active',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
	) );
    */
    
    $cmb_term->add_field( array(
		'name' => __( 'Featured Image', BABE_TEXTDOMAIN ),
	//	'desc' => __( 'field description (optional)', BABE_TEXTDOMAIN ),
		'id'   => $prefix . 'image',
		'type' => 'file',
        'preview_size' => array( 100, 100 ),
	) );
    
    $cmb_term->add_field( array(
		'name'         => __( 'Slideshow Images', BABE_TEXTDOMAIN ),
		'desc'         => __( 'Upload or add multiple images.', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'file_list',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );
    
    }
    
///////////////////////////////////////
    /**
	 * Register taxonomies_list extra fields.
	 */
    public static function taxonomies_list_metabox() {
        $prefix = '';
        
        $cmb_term = new_cmb2_box( array(
		'id'               => 'taxonomies_list_edit',
		'title'            => __( 'Taxonomies Metabox', BABE_TEXTDOMAIN ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( BABE_Post_types::$taxonomies_list_tax ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	    ) );
        
        $cmb_term->add_field( array(
		'name'         => __( 'Google map: add latitude/longitude fields to terms?', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'gmap_active',
		'type'         => 'radio_inline',
		'options'          => array(
		  0 => __( 'No', BABE_TEXTDOMAIN ),
		  1 => __( 'Yes', BABE_TEXTDOMAIN ),
        ),
        'default' => 0,
        ) );
        
        $cmb_term->add_field( array(
		'name'         => __( 'Terms selection mode', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'select_mode',
		'type'         => 'radio',
		'options'          => array(
		  'multi_checkbox' => __( 'Multi checkbox', BABE_TEXTDOMAIN ),
		  'multi_select' => __( 'Multi select', BABE_TEXTDOMAIN ),
          'single_radio' => __( 'Single radio', BABE_TEXTDOMAIN ),
          'single_select' => __( 'Single select', BABE_TEXTDOMAIN ),
        ),
        'default' => 'multi_checkbox',
        ) );
        
        $cmb_term->add_field( array(
		'name'         => __( 'Front-end style', BABE_TEXTDOMAIN ),
		'id'           => $prefix . 'frontend_style',
		'type'         => 'radio',
		'options'          => array(
		  'buttons' => __( 'Buttons', BABE_TEXTDOMAIN ),
		  'text' => __( 'Comma-separated text', BABE_TEXTDOMAIN ),
          'col_3' => __( '3-column list', BABE_TEXTDOMAIN ),
          'col_2' => __( '2-column list', BABE_TEXTDOMAIN ),
          'col_1' => __( '1-column list', BABE_TEXTDOMAIN ),
        ),
        'default' => 'col_3',
        ) );
        
        $cmb_term->add_field( array(
        'name'       => __( 'Front-end custom class', BABE_TEXTDOMAIN ),
        'id'         => $prefix . 'frontend_class',
        'desc' => __( 'Optional', BABE_TEXTDOMAIN ),
        'type'       => 'text',
        ) );
    
    }        
    
///////////////////////////////////////
    /**
	 * Register custom taxonomies extra fields.
	 */
    public static function taxonomies_metabox() {
        global $pagenow;
        
        $prefix = '';
        
        $taxonomies_arr = array();
        foreach(BABE_Post_types::$taxonomies_list as $taxonomy_id => $taxonomy){
           $taxonomies_arr[] = $taxonomy['slug'];
        }
        
        if (!empty($taxonomies_arr)){
        
        $cmb_term = new_cmb2_box( array(
		'id'               => 'custom_taxonomies_' . 'edit',
		'title'            => __( 'Taxonomies Metabox', BABE_TEXTDOMAIN ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => $taxonomies_arr, // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	    ) );
        
        if(($pagenow == 'edit-tags.php' || $pagenow == 'term.php') && isset($_GET['taxonomy']) && isset($_GET['post_type']) && $_GET['post_type'] == BABE_Post_types::$booking_obj_post_type && !BABE_Post_types::is_core_taxonomy($_GET['taxonomy'])){
            
            $taxonomy_meta = BABE_Post_types::get_taxonomy_meta_by_slug($_GET['taxonomy']);
            if ($taxonomy_meta['gmap_active']){
              $cmb_term->add_field( array(
                'name'       => __( 'Location Latitude', BABE_TEXTDOMAIN ),
                'id'         => $prefix . 'latitude',
                'type'       => 'text',
              ) );
              
              $cmb_term->add_field( array(
              'name'       => __( 'Location Longitude', BABE_TEXTDOMAIN ),
              'id'         => $prefix . 'longitude',
              'type'       => 'text',
              ) );
            }
        }
        
        $cmb_term->add_field( array(
		'name' => __( 'Icon image', BABE_TEXTDOMAIN ),
	    //'desc' => __( 'field description (optional)', BABE_TEXTDOMAIN ),
		'id'   => $prefix . 'image',
		'type' => 'file',
        'preview_size' => array( 100, 100 ),
        ) );
        
        $cmb_term->add_field( array(
        'name'       => __( 'Icon image width, px', BABE_TEXTDOMAIN ),
        'desc'       => __( '0 to auto width', BABE_TEXTDOMAIN ),
        'id'         => $prefix . 'image_width',
        'type'       => 'text',
        'default' => '50',
        ) );
        
        $cmb_term->add_field( array(
        'name'       => __( 'Icon image height, px', BABE_TEXTDOMAIN ),
        'desc'       => __( '0 to auto height', BABE_TEXTDOMAIN ),
        'id'         => $prefix . 'image_height',
        'type'       => 'text',
        'default' => '50',
        ) );
        
        }    
    
    }
        
//////////////////////////////
    /**
	 * Get booking rules option list.
     * @return array
	 */
    public static function get_booking_rules_options() {
        $options = array();
        $booking_rules = BABE_Booking_Rules::get_all_rules();
        foreach($booking_rules as $rule_id => $rule){
            $options[$rule_id] = $rule['rule_title']; 
        }
        return $options;
    }

//////////////////////////////
    /**
	 * Get posts list.
     * 
     * @param string $post_type
     * @param object $cmb
     * @param array $ids
     * @param array $more_args
     * @return array
	 */
    public static function get_posts_options($post_type, $cmb, $ids = [], $more_args = []) {
    $args = array(
        'post_type'   => $post_type,
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );
    if (!empty($ids)){
        $args['post__in'] = $ids;
    }

    $args = array_merge($args, $more_args);

    $args = apply_filters('babe_cmb2_get_posts_options_args', $args, $post_type, $cmb);

        // create hash of the query args
        $args_hash = hash('sha256', json_encode($args, 512));
        if ( isset( self::$posts_options[$args_hash] ) ){
            // return from cache
            return self::$posts_options[$args_hash];
        }
    
    $posts = get_posts( $args );
    $post_options = array();
    if ( $posts ) {
        foreach ( $posts as $post ) {
            
          if(apply_filters('babe_cmb2_get_posts_options_add_post', true, $post, $post_type, $cmb)){  
          $post_options[ $post->ID ] = $post->post_title;
          }
          
        }
    }

        self::$posts_options[$args_hash] = $post_options;

    return $post_options;
    
    }

///////////////////////////////////
    /**
	 * Get Taxonomies option list.
     * @return array
	 */
    public static function get_taxonomies_options(){
        $post_options = array();
        foreach(BABE_Post_types::$taxonomies_list as $taxonomy_id => $taxonomy){
           $post_options[$taxonomy_id] = $taxonomy['name'];
        }
       return $post_options;
    }
    
///////////////////////////////
    /**
	 * Update availability calendar.
     * Fires after all fields have been saved.
     * 
	 *
	 * @param int    $post_id   The ID of the current object
	 * @param string $updated     Array of field ids that were updated.
	 *                            Will only include field ids that had values change.
	 * @param object  $cmb         This CMB2 object
	 */ 
    public static function update_booking_obj_post( $post_id, $updated, $cmb ) {
        
      $post = get_post($post_id);

      if ( BABE_Post_types::$booking_obj_post_type != $post->post_type || $post->post_status == 'auto-draft' ) {
        return;
      }
        
        $start_date = get_post_meta( $post_id, 'start_date', 1 );
        $start_date_before = get_post_meta( $post_id, '_start_date_before', 1 );
        $end_date = get_post_meta( $post_id, 'end_date', 1 );
        $end_date_before = get_post_meta( $post_id, '_end_date_before', 1 );
        $cyclic_start_every = get_post_meta( $post_id, 'cyclic_start_every', 1 );
        $cyclic_start_every_before = get_post_meta( $post_id, '_cyclic_start_every_before', 1 );
        $cyclic_av = get_post_meta( $post_id, 'cyclic_av', 1 );
        $cyclic_av_before = get_post_meta( $post_id, '_cyclic_av_before', 1 );
        
        if ($start_date != $start_date_before || $end_date != $end_date_before || $cyclic_start_every != $cyclic_start_every_before || $cyclic_av != $cyclic_av_before){
            update_post_meta($post_id, '_start_date_before', $start_date);
            update_post_meta($post_id, '_end_date_before', $end_date);
            update_post_meta($post_id, '_cyclic_start_every_before', $cyclic_start_every);
            update_post_meta($post_id, '_cyclic_av_before', $cyclic_av);
            
            $rules = BABE_Booking_Rules::get_rule_by_obj_id($post_id);            
            if(isset($rules['rules']['basic_booking_period']) && $rules['rules']['basic_booking_period'] == 'recurrent_custom'){
              $schedule = get_post_meta( $post_id, 'schedule', 1 );
              $schedule = empty($schedule) ? array() : $schedule;
              //// update av calendar
              BABE_Calendar_functions::update_av_cal($post_id, $start_date, $end_date, $schedule, $cyclic_start_every, $cyclic_av);
            } else {  
              BABE_Calendar_functions::update_av_cal($post_id, $start_date, $end_date, array(), $cyclic_start_every, $cyclic_av);  
            }
        } else {
            
            BABE_Calendar_functions::update_av_cal_excluded_dates($post_id);
        }
        
        return;
     }
     
///////////////////////////////
    /**
	 * Update tmp post data.
     * @param int $post_id
     * @param object $post
     * @param boolean $update
	 */
    public static function update_tmp_post_data( $post_id, $post, $update ) {

      if ( !is_admin() || !in_array($post->post_type, array(BABE_Post_types::$booking_obj_post_type, BABE_Post_types::$service_post_type, BABE_Post_types::$faq_post_type)) ) {
        return;
      }
      
            update_post_meta($post_id, 'tmp_post_title', $post->post_title);
            update_post_meta($post_id, 'tmp_post_content', $post->post_content);
            
          if ( BABE_Post_types::$booking_obj_post_type == $post->post_type ) {  
            $featured_image_id = get_post_thumbnail_id( $post_id );
            $featured_image_url = wp_get_attachment_image_url($featured_image_id, 'full');
            if ($featured_image_id && $featured_image_url){
              update_post_meta($post_id, 'tmp_featured_image_id', $featured_image_id);
              update_post_meta($post_id, 'tmp_featured_image', $featured_image_url);
            } else {
                delete_post_meta( $post_id, 'tmp_featured_image_id' );
                delete_post_meta( $post_id, 'tmp_featured_image' );
            }
           }
        
        return;
     }         

//////////////////////////////    

}

BABE_CMB2_admin::init();
