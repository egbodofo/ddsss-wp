<?php
/**
 *Hotel Center Lite About Theme
 *
 * @package Hotel Center Lite
 */

//about theme info
add_action( 'admin_menu', 'hotel_center_lite_abouttheme' );
function hotel_center_lite_abouttheme() {    	
	add_theme_page( __('About Theme Info', 'hotel-center-lite'), __('About Theme Info', 'hotel-center-lite'), 'edit_theme_options', 'hotel_center_lite_guide', 'hotel_center_lite_mostrar_guide');   
} 

//Info of the theme
function hotel_center_lite_mostrar_guide() { 	
?>
<div class="wrap-GT">
	<div class="gt-left">
   		   <div class="heading-gt">
			  <h3><?php esc_html_e('About Theme Info', 'hotel-center-lite'); ?></h3>
		   </div>
          <p><?php esc_html_e('Hotel Center Lite is a simple, clean, easy to setup and user friendly hotel WordPress theme. This theme is developed to create websites for hotel, restaurants, guest house, resorts and all hotel related businesses. It can also be used for corporate, portfolio, creative agencies, tours & travel agencies, photography, blog and any other business websites. Hotel Center Lite theme is perfect for to create a professional and beautiful website for hotel business.','hotel-center-lite'); ?></p>
<div class="heading-gt"> <?php esc_html_e('Theme Features', 'hotel-center-lite'); ?></div>
 

<div class="col-2">
  <h4><?php esc_html_e('Theme Customizer', 'hotel-center-lite'); ?></h4>
  <div class="description"><?php esc_html_e('The built-in customizer panel quickly change aspects of the design and display changes live before saving them.', 'hotel-center-lite'); ?></div>
</div>

<div class="col-2">
  <h4><?php esc_html_e('Responsive Ready', 'hotel-center-lite'); ?></h4>
  <div class="description"><?php esc_html_e('The themes layout will automatically adjust and fit on any screen resolution and looks great on any device. Fully optimized for iPhone and iPad.', 'hotel-center-lite'); ?></div>
</div>

<div class="col-2">
<h4><?php esc_html_e('Cross Browser Compatible', 'hotel-center-lite'); ?></h4>
<div class="description"><?php esc_html_e('Our themes are tested in all mordern web browsers and compatible with the latest version including Chrome,Firefox, Safari, Opera, IE11 and above.', 'hotel-center-lite'); ?></div>
</div>

<div class="col-2">
<h4><?php esc_html_e('E-commerce', 'hotel-center-lite'); ?></h4>
<div class="description"><?php esc_html_e('Fully compatible with WooCommerce plugin. Just install the plugin and turn your site into a full featured online shop and start selling products.', 'hotel-center-lite'); ?></div>
</div>
<hr />  
</div><!-- .gt-left -->
	
<div class="gt-right">			
        <div>            
            <a href="https://gracethemes.com/demo/hotel-center/" target="_blank"><?php esc_html_e('Live Demo', 'hotel-center-lite'); ?></a> | 
            <a href="https://gracethemes.com/documentation/hotel-center/#homepage-lite" target="_blank"><?php esc_html_e('Documentation', 'hotel-center-lite'); ?></a>    
     
        </div>		
</div><!-- .gt-right-->
<div class="clear"></div>
</div><!-- .wrap-GT -->
<?php } ?>