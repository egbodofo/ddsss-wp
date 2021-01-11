<?php

/*
Widget Name: Lava Divider
Description: Horizontal divider.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Divider_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-divider',
            esc_html__( 'Lava Divider', 'lava' ),
            array(
                'description' => esc_html__( 'Horizontal divider', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus'
            ),
            array(),
            array(
                'style' => array(
                    'type' => 'select',
                    'label' => esc_html__( 'Style', 'lava' ),
                    'default' => 'solid',
                    'options' => array(
                        'solid' => esc_html__( 'Solid', 'lava' ),
                        'dashed' => esc_html__( 'Dashed', 'lava' ),
                        'dotted' => esc_html__( 'Dotted', 'lava' ),
                        'double' => esc_html__( 'Double Line', 'lava' ),
                        'gradient' => esc_html__( 'Gradient', 'lava' )
                    )
                ),

                'color' => array(
                    'type' => 'color',
                    'label' => esc_html__( 'Color', 'lava' ),
                    'default' => ''
                ),

                'height' => array(
                    'type' => 'measurement',
                    'label' => esc_html__( 'Line Height', 'lava' ),
                    'default' => ''
                ),

                'attributes' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Attributes', 'lava' ),
                    'hide' => true,
                    'fields' => array(
                        'classes' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Extra CSS Class', 'lava' ),
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

    function get_template_variables( $instance, $args ) {
        return array(
            'style' => $instance['style'],
            'color' => $instance['color'],
            'height' => $instance['height'],
            'attributes' => $instance['attributes']
        );
    }

}

siteorigin_widget_register( 'lava-divider', __FILE__, 'Lava_Divider_Widget' );