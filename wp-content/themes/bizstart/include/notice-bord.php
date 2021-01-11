<?php 

/**
* 
*/
if ( ! defined( 'ABSPATH' ) ) exit;
class bizstart_notice_bord
{
	
	function __construct()
	{
		
		add_action( 'admin_notices', array(&$this,'bizstart_review_notice') );
		add_action( 'wp_ajax_bizstart_dismiss_review', array(&$this,'bizstart_dismiss_review') );
	}

	
	function bizstart_review_notice(){
		$review = get_option( 'bizstart_review_data' );
		//print_r($review);
		$time	= time();
		$load	= false;
		if ( ! $review ) {
			$review = array(
				'time' 		=> $time,
				'dismissed' => false
				);
			add_option('bizstart_review_data', $review);
		//$load = true;
		} else {
		// Check if it has been dismissed or not.
			if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + (DAY_IN_SECONDS * 4)) <= $time)) ) {
				$load = true;
			}
		}
	// If we cannot load, return early.
		if ( ! $load ) {
			return;
		}

	// We have a candidate! Output a review message.
		?>	
		<div class="notice notice-success is-dismissible notice-box">

			<p style="font-size:16px;">'<?php _e( 'Hi! We saw you have been using', 'bizstart' ); ?> <strong><?php _e( 'Bizstart Theme', 'bizstart' ); ?></strong> <?php _e( 'for a few days and wanted to ask for your help to', 'bizstart' ); ?> <?php _e( '.We just need a minute of your time to rate the theme. Thank you!', 'bizstart' ); ?></p>
			<p style="font-size:17px;"> 
				<a style="color: #fff;background: #31a3dd;padding: 5px 7px 4px 6px;border-radius: 4px;" href="<?php echo esc_url('https://wordpress.org/support/theme/bizstart/reviews/?filter=5');  ?>" class="bizstart-dismiss-review-notice review-out" target="_blank" rel="noopener"><?php _e('Rate the theme','bizstart') ?></a>&nbsp; &nbsp;
				<a style="color: #fff;background: #27d63c;padding: 5px 7px 4px 6px;border-radius: 4px;" href="#"  class="bizstart-dismiss-review-notice rate-later" target="_self" rel="noopener"><?php _e( 'Nope, maybe later', 'bizstart' ); ?></a>&nbsp; &nbsp;
				<a style="color: #fff;background: #000;padding: 5px 7px 4px 6px;border-radius: 4px;" href="#" class="bizstart-dismiss-review-notice already-rated" target="_self" rel="noopener"><?php _e( 'I already did', 'bizstart' ); ?></a>&nbsp; &nbsp;
				<a style="color: #fff;background: #27d63c;padding: 5px 7px 4px 6px;border-radius: 4px;" href="http://freehtmldesigns.com/themes/?product=bizstart-premium-wordpress-theme"  class="bizstart-dismiss-review-notice rate-later" target="_self" rel="noopener"><?php _e( 'Buy Premium', 'bizstart' ); ?></a> 
			</p>
		</div>
		
		<script type="text/javascript">
		jQuery(function($){
			jQuery(document).on("click",'.bizstart-dismiss-review-notice',function(){
				if ( $(this).hasClass('review-out') ) {
					var bizstart_rate_data_val = "1";
				}
				if ( $(this).hasClass('rate-later') ) {
					var bizstart_rate_data_val =  "2";
					event.preventDefault();
				}
				if ( $(this).hasClass('already-rated') ) {
					var bizstart_rate_data_val =  "3";
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'bizstart_dismiss_review',
					bizstart_rate : bizstart_rate_data_val
				});
				
				$('.notice-box').hide();
			});
		});
		</script>
		<?php
	}

	function bizstart_dismiss_review(){
		if ( ! $review ) {
			$review = array();
		}

		if($_POST['bizstart_rate']=="1"){
			$review['time'] 	 = time();
			$review['dismissed'] = true;

		}
		if($_POST['bizstart_rate']=="2"){
			$review['time'] 	 = time();
			$review['dismissed'] = false;

		}
		if($_POST['bizstart_rate']=="3"){
			$review['time'] 	 = time();
			$review['dismissed'] = true;

		}
		
		update_option( 'bizstart_review_data', $review );
		die;
	}
}
?>