<?php

/*
Widget Name: Lava Rooms Slider
Description: Display rooms slider.
Author: ThemeSpirit
Author URI: https://themespirit.com
*/

class Lava_Rooms_Slider_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lava-rooms-slider',
            esc_html__( 'Lava Rooms Slider', 'lava' ),
            array(
                'description' => esc_html__( 'Display rooms slider.', 'lava' ),
                'panels_icon' => 'dashicons dashicons-minus',
            ),
            array(),
            array(
                'query' => array(
                    'type' => 'posts',
                    'hide' => true,
                    'label' => esc_html__( 'Rooms Query', 'lava' ),
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => esc_html__( 'Settings', 'lava' ),
                    'fields' => array(
                        
                        'columns' => array(
                            'type' => 'slider',
                            'label' => esc_html__( 'Columns', 'lava' ),
                            'min' => 1,
                            'max' => 4,
                            'integer' => true,
                            'default' => 3,
                        ),

                        'one_line_title' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'One Line Title', 'lava' ),
                            'default' => true
                        ),

                        'excerpt' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Show Room Excerpt', 'lava' ),
                            'default' => false
                        ),

                        'price' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Show Room Price', 'lava' ),
                            'default' => true
                        ),

                        'image_size' => array(
                            'label' => esc_html__( 'Image size', 'lava' ),
                            'type' => 'image-size',
                            'default' => 'lava_thumb_medium_s',
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
            )
        ));
    }

    function get_template_variables( $instance, $args ) {
        return array(
            'columns' => isset( $instance['settings']['columns'] ) ? (int) $instance['settings']['columns'] : 3,
            'one_line_title' => isset( $instance['settings']['one_line_title'] ) ? (bool) $instance['settings']['one_line_title'] : false,
            'excerpt' => isset( $instance['settings']['excerpt'] ) ? (bool) $instance['settings']['excerpt'] : false,
            'price' => isset( $instance['settings']['price'] ) ? (bool) $instance['settings']['price'] : true,
            'image_size' => isset( $instance['settings']['image_size'] ) ? $instance['settings']['image_size'] : 'lava_thumb_medium_s',
        );
    }

}

siteorigin_widget_register( 'lava-rooms-slider', __FILE__, 'Lava_Rooms_Slider_Widget' );