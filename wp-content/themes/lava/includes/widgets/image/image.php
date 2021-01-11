<?php
/*
Widget Name: Lava Image
Description: A very simple image widget.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Image_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'lava-image',
			esc_html__( 'Lava Image', 'lava' ),
			array(
				'description' => esc_html__( 'A simple image widget with massive power.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus'
			),
			array(),
			array(
				'image' => array(
					'type' => 'media',
					'label' => esc_html__( 'Image File', 'lava' ),
					'library' => 'image',
					'fallback' => true,
				),

				'size' => array(
					'type' => 'image-size',
					'label' => esc_html__( 'Image Size', 'lava' ),
				),

                'overlay' => array(
                    'type' => 'color',
                    'label' => esc_html__( 'Image Overlay', 'lava' ),
                ),

                'overlay_opacity' => array(
                    'type' => 'slider',
                    'label' => esc_html__( 'Overlay Opacity', 'lava' ),
                    'min' => 0,
                    'max' => 90,
                    'integer' => true,
                    'default' => 38
                ),

				'url' => array(
					'type' => 'link',
					'label' => esc_html__( 'Destination URL', 'lava' ),
				),

				'new_window' => array(
					'type' => 'checkbox',
					'default' => false,
					'label' => esc_html__( 'Open in new window', 'lava' ),
				),

                'content' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Content', 'lava' ),
                    'hide' => true,
                    'fields' => array(

						'text' => array(
							'type' => 'text',
							'label' => esc_html__( 'Text', 'lava' ),
						),

		                'icon_type' => array(
		                    'type' => 'select',
		                    'label' => esc_html__( 'Icon Type', 'lava' ),
		                    'default' => 'none',
		                    'state_emitter' => array(
		                        'callback' => 'select',
		                        'args' => array( 'icon_type' )
		                    ),
		                    'options' => array(
		                        'none' => esc_html__( 'None', 'lava' ),
		                        'icon' => esc_html__( 'Icon', 'lava' ),
		                        'icon_image' => esc_html__( 'Image Icon', 'lava' ),
		                    )
		                ),

		                'icon_image' => array(
		                    'type' => 'media',
		                    'label' => esc_html__( 'Image Icon', 'lava' ),
		                    'state_handler' => array(
		                        'icon_type[icon_image]' => array( 'show' ),
		                        '_else[icon_type]' => array( 'hide' ),
		                    ),
		                ),

		                'icon' => array(
		                    'type' => 'icon',
		                    'label' => esc_html__( 'Icon', 'lava' ),
		                    'state_handler' => array(
		                        'icon_type[icon]' => array( 'show' ),
		                        '_else[icon_type]' => array( 'hide' ),
		                    )
		                )
		            )
                ),

                'layout' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Layout', 'lava' ),
                    'hide' => true,
                    'fields' => array(
                        'container' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Container', 'lava' ),
                            'options' => array(
                                '' => esc_html__( 'Default', 'lava' ),
                                'full' => esc_html__( 'Container Full Width', 'lava' ),
                                'half' => esc_html__( 'Container Half Width', 'lava' ),
                                'fluid' => esc_html__( 'Container Full Without Top & Bottom Padding', 'lava' )
                            )
                        ),

                        'height' => array(
                            'type' => 'measurement',
                            'label' => esc_html__( 'Content Height', 'lava' ),
                            'description' => esc_html__( 'Set minimum content height', 'lava' ),
                            'default' => '',
                        ),
                        
                        'equal_height' => array(
                            'type' => 'checkbox',
                            'default' => true,
                            'label' => esc_html__( 'Equal Content Height', 'lava' ),
                            'description' => esc_html__( 'This will make the contents in this row have the same height.', 'lava' ),
                        )
                    )
                )
			)
		);
	}


    function initialize(){
        $this->register_frontend_styles( array(
            array(
                'lava-so-widgets',
                LAVA_THEME_URI . '/assets/css/widgets'. LAVA_MIN_SUFFIX .'.css',
                false,
                LAVA_THEME_VERSION
            )
        ));
    }

	public function get_template_variables( $instance, $args ) {
		return array(
			'title' => !empty( $instance['title'] ) ? $instance['title'] : '',
			'image' => $instance['image'],
			'overlay' => $instance['overlay'],
			'overlay_opacity' => $instance['overlay_opacity'],
			'size' => $instance['size'],
			'url' => $instance['url'],
			'new_window' => !empty( $instance['new_window'] ) ? $instance['new_window'] : $instance['new_window'],
		);
	}
}

siteorigin_widget_register( 'lava-image', __FILE__, 'Lava_Image_Widget');
