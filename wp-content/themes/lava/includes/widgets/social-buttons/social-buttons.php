<?php

/*
Widget Name: Lava Social Buttons
Description: Social button links to your social media profiles.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Social_Buttons_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-social-buttons',
            esc_html__( 'Lava Social Buttons', 'lava' ),
            array(
                'description' => esc_html__( 'Social button links to your social media profiles.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus',
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Title', 'lava' ),
                    'hide' => false,
                    'fields' => array(
                        'text' => array(
                            'type' => 'text',
                            'label' => esc_html__( 'Title', 'lava' ),
                        ),

                        'color' => array(
                            'type' => 'color',
                            'label' => esc_html__( 'Color', 'lava' ),
                        ),

                        'align' => array(
                            'type' => 'select',
                            'label' => esc_html__( 'Alignment', 'lava' ),
                            'default' => 'left',
                            'options' => array(
                                'left' => esc_html__( 'Left', 'lava' ),
                                'right' => esc_html__( 'Right', 'lava' ),
                                'center' => esc_html__( 'Center', 'lava' ),
                            ),
                        )
                    )
                ),

                'style' => array(
                    'type' => 'select',
                    'label' => esc_html__( 'Style', 'lava' ),
                    'default' => 'a',
                    'options' => array(
                        'a' => esc_html__( 'Style A', 'lava' ),
                        'b' => esc_html__( 'Style B', 'lava' ),
                    )
                ),

                'alignment' => array(
                    'type' => 'select',
                    'label' => esc_html__( 'Button Alignment', 'lava' ),
                    'default' => 'left',
                    'options' => array(
                        'left' => esc_html__( 'Left', 'lava' ),
                        'right' => esc_html__( 'Right', 'lava' ),
                        'center' => esc_html__( 'Center', 'lava' ),
                    )
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
            ),
            array(
                'material-icons',
                LAVA_THEME_URI . '/assets/css/material-icons.min.css',
                false,
                LAVA_THEME_VERSION
            )
        ));
    }

    function get_template_variables( $instance, $args ) {
        return array(
            'title' => $instance['title'],
            'style' => $instance['style'],
            'alignment' => isset( $instance['alignment'] ) ? $instance['alignment'] : 'left',
            'attributes' => $instance['attributes']
        );
    }

}

siteorigin_widget_register( 'lava-social-buttons', __FILE__, 'Lava_Social_Buttons_Widget' );