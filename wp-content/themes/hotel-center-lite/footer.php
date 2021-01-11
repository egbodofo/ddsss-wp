<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Hotel Center Lite
 */
?>

<div class="footer-copyright">
        	<div class="container">
            	<div class="copyright-txt">
					<?php bloginfo('name'); ?>. <?php esc_html_e('All Rights Reserved', 'hotel-center-lite');?>           
                </div>
                <div class="design-by">                  
                   <a href="<?php echo esc_url( __( 'https://gracethemes.com/themes/hotel-center-lite/', 'hotel-center-lite' ) ); ?>">
					<?php esc_html_e( 'Theme by Grace Themes', 'hotel-center-lite' ); ?>
				</a>
                  
                  
                </div>
                 <div class="clear"></div>
            </div>           
        </div>        
</div><!--#end site-holder-->

<?php wp_footer(); ?>
</body>
</html>