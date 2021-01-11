<?php

add_action( 'pre_get_posts', 'lava_custom_query_vars' );

function lava_custom_query_vars( $query ) {
  	if ( !is_admin() && $query->is_main_query() ) {

  		if ( isset( $query->query['post_type'] ) ) {

  			if ( 'lava_offer' == $query->query['post_type'] ) {
  				$offer_ppp = Lava_Util::get_option( 'offer_archive_ppp' );
  				
  				if ( !empty( $offer_ppp ) ) {
  					$query->set( 'posts_per_page', $offer_ppp );
  				}
  			}
  		}
  	}
  	return $query;
}

// Disable wp hotel booking lightbox scripts
remove_action( 'hb_lightbox_assets_lightbox2', 'hb_lightbox_assets_lightbox2' );

// Remove library style on customizer screen
function lava_remove_hb_scripts() {
	if ( is_customize_preview() ) {
		wp_dequeue_style( 'wp-hotel-booking-libaries-style' );
		wp_deregister_style( 'wp-hotel-booking-libaries-style' );
	}
}

add_action( 'admin_enqueue_scripts', 'lava_remove_hb_scripts', 99 );

// Custom gallery settings
add_action( 'print_media_templates', function() {
  // define your backbone template;
  // the "tmpl-" prefix is required,
  // and your input field should have a data-setting attribute
  // matching the shortcode name
  ?>
    <script type="text/html" id="tmpl-lava-gallery-settings">
    <hr style="float:left;width:100%;margin:15px 0;">
    <h3 style="clear:both;"><?php esc_html_e( 'Lava Gallery Settings', 'lava' ); ?></h3>
    <label class="setting">
        <span><?php esc_html_e( 'Gallery Style', 'lava' ); ?></span>
        <select data-setting="style">
            <option value="bullet"><?php esc_html_e( 'Bullet', 'lava' ); ?></option>
            <option value="thumbnail"><?php esc_html_e( 'Thumbnail', 'lava' ); ?></option>
            <option value="wordpress"><?php esc_html_e( 'WordPress Default', 'lava' ); ?></option>
        </select>
    </label>
    <label class="setting">
        <span><?php esc_html_e( 'Fill Mode', 'lava' ); ?></span>
        <select data-setting="fill_mode">
            <option value="contain"><?php esc_html_e( 'Contain', 'lava' ); ?></option>
            <option value="cover"><?php esc_html_e( 'Cover', 'lava' ) ?></option>
        </select>
    </label>
    <label class="setting">
        <span><?php esc_html_e( 'Enable Autoplay', 'lava' ); ?></span>
        <input type="checkbox" data-setting="autoplay" checked>
    </label>
    <label class="setting">
        <span><?php esc_html_e( 'Autoplay Speed ( in seconds )', 'lava' ); ?></span>
        <input type="text" data-setting="autoplay_speed" value="" style="width:99%;">
    </label>
    <label class="setting">
        <span><?php esc_html_e( 'Lazy Loading', 'lava' ); ?></span>
        <select data-setting="lazyload">
          <option value=""><?php esc_html_e( 'Disable', 'lava' ); ?></option>
            <option value="ondemand"><?php esc_html_e( 'On Demand', 'lava' ); ?></option>
            <option value="progressive"><?php esc_html_e( 'Progressive', 'lava' ) ?></option>
        </select>
    </label>
    </script>
    <script>
        jQuery(document).ready(function() {
            // add your shortcode attribute and its default value to the
            // gallery settings list; $.extend should work as well...
            _.extend(wp.media.gallery.defaults, {
                style: 'wordpress',
                fill_mode: 'contain',
                autoplay: 'false',
                autoplay_speed: '3',
                lazyload: '',
            });

            // merge default gallery settings template with yours
            wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
                template: function(view){
                    return wp.media.template('gallery-settings')(view) + wp.media.template('lava-gallery-settings')(view);
                }
            });
        });
    </script>
    <?php
});
