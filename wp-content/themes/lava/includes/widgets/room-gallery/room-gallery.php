<?php
/*
Widget Name: Lava Room Gallery
Description: Display room gallery
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Room_Gallery_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'lava-room-gallery',
			esc_html__( 'Lava Room Gallery', 'lava' ),
			array(
				'description' => esc_html__( 'Display room gallery', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus'
			),
			array(),
			array(
				'items' => array(
					'type' => 'repeater',
					'label' => esc_html__( 'Images', 'lava' ),
					'item_label' => array(
						'selector'     => "[id*='title']"
					),
					'fields' => array(
						'image' => array(
							'type' => 'media',
							'label' => esc_html__( 'Image', 'lava')
						)
					)
				),

                'settings' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Settings', 'lava' ),
                    'fields' => array(
                        
                        'label' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Show Label', 'lava' ),
                            'default' => false,
                        ),

                        'label_text' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Label Text', 'lava' ),
                        )
                    )
                ),
			)
		);
	}


    function initialize() {
        $this->register_frontend_styles( array(
            array(
                'lava-so-widgets',
                LAVA_THEME_URI . '/assets/css/widgets'. LAVA_MIN_SUFFIX .'.css',
                false,
                LAVA_THEME_VERSION
            ),
            array(
                'material-icons',
                LAVA_THEME_URI . '/assets/css/material-icons.min.css',
                false,
                LAVA_THEME_VERSION
            ),
			array(
				'fancybox',
				LAVA_THEME_URI . '/assets/css/fancybox.min.css'
			),
            array(
                'slick',
                LAVA_THEME_URI . '/assets/css/slick.min.css',
                false,
                LAVA_THEME_VERSION
            )
        ));
        $this->register_frontend_scripts( array(
            array(
                'lava-sliders',
                LAVA_THEME_URI . '/assets/js/sliders'. LAVA_MIN_SUFFIX .'.js',
                array( 'jquery', 'slick' ),
                LAVA_THEME_VERSION,
                true
            ),
            array(
                'fancybox',
                LAVA_THEME_URI . '/assets/lib/js/jquery.fancybox.min.js',
                array( 'jquery' ),
                LAVA_THEME_VERSION,
                true
            )
        ));
    }

	public function get_template_variables( $instance, $args ) {
		return array(
			'items' => isset( $instance['items'] ) ? $instance['items'] : array(),
			'label' => isset( $instance['settings']['label'] ) ? (bool) $instance['settings']['label'] : true,
			'label_text' => isset( $instance['settings']['label_text'] ) ? $instance['settings']['label_text'] : esc_html__( 'Gallery', 'lava' )
		);
	}
}

siteorigin_widget_register( 'lava-room-gallery', __FILE__, 'Lava_Room_Gallery_Widget');
