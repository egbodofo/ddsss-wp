<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Booking_Rules_admin Class.
 * Create and manage Booking rules - templates for creating and storing booking rules in Booking Objects later
 * @class 		BABE_Booking_Rules_admin
 * @version		1.2.7
 * @author 		Booking Algorithms
 */

class BABE_Booking_Rules_admin {
    
    private static $nonce_title = 'booking-rules-tpl-nonce';
    
///////////////////////////////////////    
    public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'add_booking_rules_page' ) );
        add_action( 'admin_init', array( __CLASS__, 'booking_rules_page_init' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueued_assets' ) );
        
        add_action( 'wp_ajax_del_rule', array( __CLASS__, 'ajax_del_booking_rule'));      
	}
///////////////////////////////////////
    /**
	 * Enqueue assets.
	 */
    public static function enqueued_assets() {
        
     if (isset($_GET['post_type']) && isset($_GET['page']) && $_GET['post_type'] == BABE_Post_types::$booking_obj_post_type && $_GET['page'] == 'booking_rules'){   
     
     wp_enqueue_script( 'babe-admin-modal-js', plugins_url( "js/babe-modal.js", BABE_PLUGIN ), array('jquery'), '1.0', true );   

     wp_enqueue_script( 'babe-admin-rules-js', plugins_url( "js/admin/babe-admin-rules.js", BABE_PLUGIN ), array('jquery'), '1.0', true );

     wp_localize_script( 'babe-admin-rules-js', 'babe_rules_lst', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce(self::$nonce_title)
         )
     );
     
     wp_enqueue_style( 'babe-admin-modal-style', plugins_url( "css/babe-modal.css", BABE_PLUGIN ));
       
     wp_enqueue_style( 'babe-admin-rules-style', plugins_url( "css/admin/babe-admin-rules.css", BABE_PLUGIN ));
      }
     }
///////////////////////////////////////    
    /**
	 * Add Booking rules admin page to menu.
	 */
    public static function add_booking_rules_page(){
        
        add_submenu_page( 'edit.php?post_type='.BABE_Post_types::$booking_obj_post_type, __('Booking rules', BABE_TEXTDOMAIN), __('Booking rules', BABE_TEXTDOMAIN), 'manage_options', 'booking_rules', array( __CLASS__, 'create_booking_rules_page' ));
        
    }
///////////////////////////////////////
    /**
	 * Create Booking rules admin page.
	 */
    public static function create_booking_rules_page(){
                
        ?>
        <div class="wrap">
            <h2><?php echo __('Booking rules', BABE_TEXTDOMAIN); ?></h2>
            
            <table id="booking-rules-table">
            <?php echo self::get_booking_rules_thead().self::get_booking_rules_list(); ?>
            </table>
            
            <?php echo '
            <div id="babe_overlay_container">
            <div id="confirm_del_rule" class="babe_overlay_inner">
              <span id="modal_close"><i class="fa fa-remove"></i></span>
              <h1>'.__('Delete selected rule?', BABE_TEXTDOMAIN).'</h1>
                  <input type="button" name="cancel" id="cancel" class="button babe-button-1" value="'.__('Cancel', BABE_TEXTDOMAIN).'">
                  <input type="button" name="delete" id="delete" class="button babe-button-2" value="'.__('Delete', BABE_TEXTDOMAIN).'">
            </div>
            </div>
            <div id="babe_overlay"></div>'; ?>
            
            <h2><?php // echo __('Add new booking rule', BABE_TEXTDOMAIN); ?></h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'babe-tmp-settings' );
                do_settings_sections( 'babe-tmp-settings' );
                submit_button(__('Add rule', BABE_TEXTDOMAIN));
            ?>
            </form>
        </div>
        <?php
    }
//////////////////////////////////////    
    /**
	 * Booking rules table header.
     * @return string
	 */
    public static function get_booking_rules_thead(){
       $output = '';
       
       $output .= '<thead>
       <tr class="booking-rules-thead">
            <th>'.__('Title', BABE_TEXTDOMAIN).'</th>
            <th>'.__('Basic booking period', BABE_TEXTDOMAIN).'</th>
            <th>'.__('Use Ages', BABE_TEXTDOMAIN).'</th>
            <th>'.__('Payment model', BABE_TEXTDOMAIN).'</th>
            <th>'.__('Deposit, %', BABE_TEXTDOMAIN).'</th>
            <th>'.__('Hold', BABE_TEXTDOMAIN).'</th>
            <th>'.__('Stop booking .. hours before the start', BABE_TEXTDOMAIN).'</th>
            <th>'.__('Booking mode', BABE_TEXTDOMAIN).'</th>
            <th></span>
            </tr>
            </thead>';
            
       /*
       '<th>'.__('Min booking period', BABE_TEXTDOMAIN).'</th>
            <th>'.__('Max booking period', BABE_TEXTDOMAIN).'</th>'
            <th>'.__('Reccurent payments', BABE_TEXTDOMAIN).'</th>
       */     
       
       return $output; 
    }    
    
//////////////////////////////////////    
    /**
	 * Booking rules list.
     * @return string
	 */
    public static function get_booking_rules_list(){
    $output = ''; 
    
    $booking_rules = BABE_Booking_Rules::get_all_rules();
    
    if (!empty($booking_rules)){
   
      foreach ($booking_rules as $booking_rule_id => $rule){
        
       $ages_val = $rule['ages'] ? __('yes', BABE_TEXTDOMAIN) : __('no', BABE_TEXTDOMAIN);
       $recurrent_val = $rule['recurrent_payments'] ? __('yes', BABE_TEXTDOMAIN) : __('no', BABE_TEXTDOMAIN);
       $stop_before = isset($rule['stop_booking_before']) && $rule['stop_booking_before'] ? $rule['stop_booking_before'].' '. __('hours', BABE_TEXTDOMAIN).' '.'<span class="booking-rule-hidden-label">'.__(' before the start', BABE_TEXTDOMAIN).'</span>' : '';
       $hold = isset($rule['hold']) && $rule['hold'] ? $rule['hold'].' '. __('hours', BABE_TEXTDOMAIN) : '';
       
       switch($rule['payment_model']){
        case 'deposit':
          $payment_model_val = __('deposit', BABE_TEXTDOMAIN);
          break;
        case 'deposit_full':
          $payment_model_val = __('deposit and full', BABE_TEXTDOMAIN);
          break;
        case 'full':
        default:
          $payment_model_val = __('full', BABE_TEXTDOMAIN);
          break;    
       }
       
       switch($rule['basic_booking_period']){
        case 'single_custom':
          $basic_booking_val = __('single custom', BABE_TEXTDOMAIN);
          break;
        case 'recurrent_custom':
          $basic_booking_val = __('recurrent custom', BABE_TEXTDOMAIN);
          break;  
        case 'day':
          $basic_booking_val = __('1 day', BABE_TEXTDOMAIN);
          break;
        case 'month':
          $basic_booking_val = __('1 month', BABE_TEXTDOMAIN);
          break;
       case 'hour':
	       $basic_booking_val = __('1 hour', BABE_TEXTDOMAIN);
	       break;
	       case 'night':
        default:
          $basic_booking_val = __('1 night', BABE_TEXTDOMAIN);
          break;    
       }
        
       $output .= '
       <tr data-i="'.$booking_rule_id.'">
       
       <td class="booking-rule-title">
       <span class="booking-rule-hidden-label">'.__('Title', BABE_TEXTDOMAIN).':</span>       
       '.$rule['rule_title'].'
       </td>
       
       <td class="booking-rule-basic">
       <span class="booking-rule-hidden-label">'.__('Basic booking period', BABE_TEXTDOMAIN).':</span>       
       '.$basic_booking_val.'
       </td>
       
       <td class="booking-rule-ages">
       <span class="booking-rule-hidden-label">'.__('Use Ages', BABE_TEXTDOMAIN).':</span>       
       '.$ages_val.'
       </td>
       
       <td class="booking-rule-payment">
       <span class="booking-rule-hidden-label">'.__('Payment model', BABE_TEXTDOMAIN).':</span>       
       '.$payment_model_val.'
       </td>
       
       <td class="booking-rule-deposit">
       <span class="booking-rule-hidden-label">'.__('Deposit, %', BABE_TEXTDOMAIN).':</span>       
       '.$rule['deposit'].'
       </td>
       
       <td class="booking-rule-stop-before">
       <span class="booking-rule-hidden-label">'.__('Hold', BABE_TEXTDOMAIN).':</span>       
       '.$hold.'
       </td>
       
       <td class="booking-rule-stop-before">
       <span class="booking-rule-hidden-label">'.__('Stop booking ', BABE_TEXTDOMAIN).':</span>       
       '.$stop_before.'
       </td>
       
       <td class="booking-rule-mode">
       <span class="booking-rule-hidden-label">'.__('Booking mode', BABE_TEXTDOMAIN).':</span>       
       '.$rule['booking_mode'].'
       </td>
       
       <td class="booking_rule_del" data-i="'.$booking_rule_id.'">
       <span class="booking-rule-hidden-label">'.__('Delete this rule', BABE_TEXTDOMAIN).':</span>
       <i class="fas fa-trash-alt"></i></td>  
       </tr>';
       
       }
     }
     
   $output = '<tbody>'.$output.'</tbody>';  
        
   return $output; 
   }    
///////////////////////////////////////    
    /**
	 * Delete Booking rule by buking_rule_id.
	 */
    public static function ajax_del_booking_rule(){
        
        $output = '<li>'.__('An error occurred while deleting the rule', BABE_TEXTDOMAIN).'</li>';
        
        if (isset($_POST['booking_rule_id']) && isset($_POST['nonce']) && wp_verify_nonce( $_POST['nonce'], self::$nonce_title )){
           $deleted = BABE_Booking_Rules::delete_rule((int)$_POST['booking_rule_id']);
           $output = $deleted ? self::get_booking_rules_thead().self::get_booking_rules_list() : $output;
        }
        
        echo $output;
        wp_die();
        
    }
///////////////////////////////////////    
    /**
	 * Booking rules page form init.
	 */
    public static function booking_rules_page_init(){
        register_setting(
            'babe-tmp-settings', // Option group
            'babe_tmp_settings', // Option name
            array( __CLASS__, 'sanitize' ) // Sanitize
        );

        ///////// Add new booking rule
        
        add_settings_section(
            'setting_section_1', // ID
            __('Add new booking rule',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'print_section_info_1' ), // Callback
            'babe-tmp-settings' // Page
        );

        add_settings_field(
            'rule_title', // ID
            __('Title',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_title' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        add_settings_field(
            'basic_booking_period', // ID
            __('Basic booking period',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_basic_booking_period' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        /*
        add_settings_field(
            'min_booking_period', // ID
            __('Minimum booking period',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_min_booking_period' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        add_settings_field(
            'max_booking_period', // ID
            __('Maximum booking period',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_max_booking_period' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        */
        
        add_settings_field(
            'hold', // ID
            __('Hold after each booking for service actions (applied to 1 day booking priod only)',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_hold' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        add_settings_field(
            'stop_booking_before', // ID
            __('Stop booking .. hours before the start (applied to recurrent custom booking priod only)',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_stop_booking_before' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        add_settings_field(
            'ages', // ID
            __('Use Age categories for prices?',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_ages' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        add_settings_field(
            'payment_model', // ID
            __('Payment model',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_payment_model' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        add_settings_field(
            'deposit', // ID
            __('Deposit, %',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_deposit' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        
        /*
        add_settings_field(
            'recurrent_payments', // ID
            __('Recurrent payments',BABE_TEXTDOMAIN).' <span class="babe_developement">'.__('(*in the development)', BABE_TEXTDOMAIN).'</span>', // Title
            array( __CLASS__, 'callback_recurrent_payments' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );
        */
        
        add_settings_field(
            'booking_mode', // ID
            __('Booking mode',BABE_TEXTDOMAIN), // Title
            array( __CLASS__, 'callback_booking_mode' ), // Callback
            'babe-tmp-settings', // Page
            'setting_section_1' // Section
        );

    }
///////////////////////////////////////    
    /**
	 * Sanitize form inputs and save our new booking rule.
	 */
    public static function sanitize($input){

        $rule['rule_title'] = isset($input['rule_title']) ? sanitize_text_field($input['rule_title']) : '';

        $rule['basic_booking_period'] = isset($input['basic_booking_period'], BABE_Booking_Rules::$booking_periods[$input['basic_booking_period']]) ? $input['basic_booking_period'] : 'night';
       /*
       $rule['min_booking_period'] = isset($input['min_booking_period']) ? intval($input['min_booking_period']) : 0;
       $rule['max_booking_period'] = intval($input['max_booking_period']);
       */

        $rule['hold'] = isset($input['hold']) && absint($input['hold']) < 24 ? absint($input['hold']) : 0;

        $rule['stop_booking_before'] = isset($input['stop_booking_before']) ? (int)$input['stop_booking_before'] : 0;

        $rule['deposit'] = isset($input['deposit']) ? (float)$input['deposit'] : '';

        $rule['ages'] = isset($input['ages']) ? (int)$input['ages'] : 0;

        $rule['payment_model'] = isset($input['payment_model'], BABE_Booking_Rules::$payment_models[$input['payment_model']]) ? $input['payment_model'] : 'full';

        $rule['recurrent_payments'] = isset($input['recurrent_payments']) ? (int)$input['recurrent_payments'] : 0;

        $rule['booking_mode'] = isset($input['booking_mode']) && isset(BABE_Booking_Rules::$booking_modes[$input['booking_mode']]) ? $input['booking_mode'] : 'object';

        if ($rule['rule_title']){
            BABE_Booking_Rules::add_rule($rule);
        }

        return [];
    }    
//////////////////////////////////////
    /**
	 * Section info.
	 */
    public static function print_section_info_1(){        
    }    
//////////////////////////////////////
    /**
	 * Title form input.
	 */
    public static function callback_title(){
        echo '<input type="text" id="rule_title" name="babe_tmp_settings[rule_title]" value="" />';        
    }    
//////////////////////////////////////
    /**
	 * Basic booking period form input.
	 */
    public static function callback_basic_booking_period(){
        echo '<p><input id="babe_tmp_settings[basic_booking_period]1" name="babe_tmp_settings[basic_booking_period]" type="radio" value="single_custom" class="booking_period_data" data-label="'.__('not used', BABE_TEXTDOMAIN).'"/><label for="babe_tmp_settings[basic_booking_period]1">'.__('Single custom (one-time events, etc.)', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[basic_booking_period]2" name="babe_tmp_settings[basic_booking_period]" type="radio" value="recurrent_custom" class="booking_period_data" data-label="'.__('not used', BABE_TEXTDOMAIN).'"/><label for="babe_tmp_settings[basic_booking_period]2">'.__('Recurrent custom (weekly schedule for tours, events, etc.)', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[basic_booking_period]3" name="babe_tmp_settings[basic_booking_period]" type="radio" value="day" class="booking_period_data" data-label="'.__('days', BABE_TEXTDOMAIN).'" /><label for="babe_tmp_settings[basic_booking_period]3">'.__('1 day (cars, bikes, etc.)', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[basic_booking_period]4" name="babe_tmp_settings[basic_booking_period]" type="radio" value="night" class="booking_period_data" data-label="'.__('nights', BABE_TEXTDOMAIN).'" checked="checked" /><label for="babe_tmp_settings[basic_booking_period]4">'.__('1 night (hotels, apartments, hostels, etc.)', BABE_TEXTDOMAIN).'</label></p>';
        //'
        //<p><input id="babe_tmp_settings[basic_booking_period]5" name="babe_tmp_settings[basic_booking_period]" type="radio" value="hour" class="booking_period_data" data-label="'.__('hours', BABE_TEXTDOMAIN).'" /><label for="babe_tmp_settings[basic_booking_period]5">'.__('1 hour (hourly rent: bikes, sport equipment, etc.)', BABE_TEXTDOMAIN).'</label></p>
        //<p><input id="babe_tmp_settings[basic_booking_period]6" name="babe_tmp_settings[basic_booking_period]" type="radio" value="month"  class="booking_period_data" data-label="'.__('not used', BABE_TEXTDOMAIN).'" /><label for="babe_tmp_settings[basic_booking_period]6">'.__('1 month (realty, properties, etc.)', BABE_TEXTDOMAIN).'</label></p>';
    }
/////////////////////////////////////
    /**
	 * Minimum booking period form input.
	 */
    public static function callback_min_booking_period(){
        echo '<input type="text" id="min_booking_period" name="babe_tmp_settings[min_booking_period]" value="" /><span class="booking_period_label"></span>';        
    }    
//////////////////////////////////////
    /**
	 * Maximum booking period form input.
	 */
    public static function callback_max_booking_period(){
        echo '<input type="text" id="max_booking_period" name="babe_tmp_settings[max_booking_period]" value="" /><span class="booking_period_label"></span>';        
    }    
//////////////////////////////////////
    /**
	 * Hold after each booking form input.
	 */
    public static function callback_hold(){
        echo '<input type="text" id="hold" name="babe_tmp_settings[hold]" value="" /><span class="booking_period_label2">'.__('hours. 0 or nothing for no hold period.', BABE_TEXTDOMAIN).'</span>';        
    }
    
/////////stop_booking_before////////////
    /**
	 * Stop booking before form input.
	 */
    public static function callback_stop_booking_before(){
        echo '<input type="text" id="stop_booking_before" name="babe_tmp_settings[stop_booking_before]" value="" /><span class="booking_period_label2">'.__('hours', BABE_TEXTDOMAIN).'</span>';        
    }
    
//////////////////////////////////////
    /**
	 * Deposit, %.
	 */
    public static function callback_deposit(){
        echo '<input type="text" id="hold" name="babe_tmp_settings[deposit]" value="" />';        
    }
        
//////////////////////////////////////    
    /**
	 * Use Age categories for prices form input.
	 */
    public static function callback_ages(){
        echo '<p><input id="babe_tmp_settings[ages]1" name="babe_tmp_settings[ages]" type="radio" value="0" checked="checked" /><label for="babe_tmp_settings[ages]1">'.__('No', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[ages]2" name="babe_tmp_settings[ages]" type="radio" value="1" /><label for="babe_tmp_settings[ages]2">'.__('Yes', BABE_TEXTDOMAIN).'</label></p>';        
    }
/////////////////////////////////////     
    /**
	 * Payment model form input.
	 */
    public static function callback_payment_model(){
        echo '<p><input id="babe_tmp_settings[payment_model]1" name="babe_tmp_settings[payment_model]" type="radio" value="deposit" /><label for="babe_tmp_settings[payment_model]1">'.__('Pay deposit amount', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[payment_model]2" name="babe_tmp_settings[payment_model]" type="radio" value="full" checked="checked" /><label for="babe_tmp_settings[payment_model]2">'.__('Pay full amount', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[payment_model]3" name="babe_tmp_settings[payment_model]" type="radio" value="deposit_full" /><label for="babe_tmp_settings[payment_model]3">'.__('Pay deposit or full amount (the customer will choose)', BABE_TEXTDOMAIN).'</label></p>';        
    }
///////////////////////////////////// 
    /**
	 * Recurrent Payments form input.
	 */
    public static function callback_recurrent_payments(){
        echo '<p><input id="babe_tmp_settings[recurrent_payments]1" name="babe_tmp_settings[recurrent_payments]" type="radio" value="0" checked="checked" /><label for="babe_tmp_settings[recurrent_payments]1">'.__('No', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[recurrent_payments]2" name="babe_tmp_settings[recurrent_payments]" type="radio" value="1" /><label for="babe_tmp_settings[recurrent_payments]2">'.__('Yes (for 1 month basic booking period and pay full amount mode only)', BABE_TEXTDOMAIN).'</label></p>';        
    }
/////////////////////////////////////
    /**
	 * Booking mode form input.
	 */
    public static function callback_booking_mode(){
        echo '<p><input id="babe_tmp_settings[booking_mode]1" name="babe_tmp_settings[booking_mode]" type="radio" value="object" checked="checked" /><label for="babe_tmp_settings[booking_mode]1">'.__('Object booking', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[booking_mode]2" name="babe_tmp_settings[booking_mode]" type="radio" value="places" /><label for="babe_tmp_settings[booking_mode]2">'.__('Places booking', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[booking_mode]3" name="babe_tmp_settings[booking_mode]" type="radio" value="tickets" /><label for="babe_tmp_settings[booking_mode]3">'.__('Tickets booking', BABE_TEXTDOMAIN).'</label></p>
        <p><input id="babe_tmp_settings[booking_mode]4" name="babe_tmp_settings[booking_mode]" type="radio" value="request" /><label for="babe_tmp_settings[booking_mode]4">'.__('Request for price and details', BABE_TEXTDOMAIN).'</label> <span class="babe_developement">'.__('(*in the development)', BABE_TEXTDOMAIN).'</span></p>';        
    }
/////////////////////////////////////
    
}

BABE_Booking_Rules_admin::init();
