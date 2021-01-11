<?php
/**
 * Recommended plugins
 *
 * @package bizstart
 */

if ( ! function_exists( 'bizstart_recommended_plugins' ) ) :

    /**
     * Recommend plugins.
     *
     * @since 1.0.0
     */
    function bizstart_recommended_plugins() {

        $plugins = array(
            array(
                'name'     => esc_html__( 'One Click Demo Import', 'bizstart' ),
                'slug'     => 'one-click-demo-import',
                'required' => false,
            ),
			
			 array(
                'name'     => esc_html__( 'Site Offline', 'bizstart' ),
                'slug'     => 'site-offline',
                'required' => false,
            ),
          
             array(
                'name'     => esc_html__( 'Contact Form 7', 'bizstart' ),
                'slug'     => 'contact-form-7',
                'required' => false,
            ),
        );

        tgmpa( $plugins );

    }

endif;

add_action( 'tgmpa_register', 'bizstart_recommended_plugins' );
